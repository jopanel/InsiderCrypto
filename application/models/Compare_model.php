<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compare_model extends CI_Model {

	private function calculatePercentage($price1=null, $price2=null) {
		if ($price1 == null || $price2 == null) { return 0; }
		return (($price1 - $price2) / ($price1)) * 100;
	}

	public function generateArbitrageEvents() {
		/*
			1. Generate Data
			2. Sort based off currency
			3. Calculate % match pairs
			4. Save above 3%
		*/
		$time = time();
		$output = [];
		$data = [];
		$followup = [];
		$sql = "SELECT
					p.price,
					m.currency_id,
					m.market_id,
					p.lastupdate,
					m.symbol_id,
					m.id AS 'pair_id'
				FROM
					markets_pairs m
				JOIN price_chart p ON p.id =(
					SELECT
						MAX(z.id)
					FROM
						price_chart z
					WHERE
						z.currency_id = m.currency_id
					AND z.market_id = m.market_id
					AND z.symbol_id = m.symbol_id
				)
				WHERE
					m.active = '1'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $res) {
				$data[$res["currency_id"].$res["symbol_id"]][] = array("price"=>$res["price"], "market_id"=>$res["market_id"], "lastupdate"=>$res["lastupdate"], "pair_id" => $res["pair_id"]);
			}
		}

		foreach ($data as $k => $v) {
			$forcount = count($v);
			if ($forcount > 1) {
				foreach ($v as $kk => $vv) {
					for ($i = 0; $i < $forcount; $i++) {
						if ($kk != $i) {
							$percent = $this->calculatePercentage($vv["price"], $v[$i]["price"]);
							if ($percent > 3) {
								//check if match is active
								$sql = "SELECT id FROM matches WHERE pair1_id = ".$this->db->escape($vv["pair_id"])." AND pair2_id = ".$this->db->escape($v[$i]["pair_id"])." AND finished IS NULL";
								$query = $this->db->query($sql);
								if ($query->num_rows() > 0) {
									// match is active
									$match_id = $query->row()->id;
									$sql = "INSERT INTO matches_log (match_id, pair1_id, pair2_id, pair1_price, pair2_price, created) VALUES (".$this->db->escape($match_id).", ".$this->db->escape($vv["pair_id"]).", ".$this->db->escape($v[$i]["pair_id"]).", ".$this->db->escape($vv["price"]).", ".$this->db->escape($v[$i]["price"]).", ".$this->db->escape($time).")";
									$this->db->query($sql);
								} else {
									// match doesnt exist
									$sql = "INSERT INTO matches (pair1_id, pair2_id, started) VALUES (".$this->db->escape($vv["pair_id"]).", ".$this->db->escape($v[$i]["pair_id"]).", ".$this->db->escape($time).")";
									$this->db->query($sql);
									$sql = "SELECT id FROM matches WHERE pair1_id = ".$this->db->escape($vv["pair_id"])." AND pair2_id = ".$this->db->escape($v[$i]["pair_id"])." AND finished IS NULL";
									$query2 = $this->db->query($sql);
									$match_id = $query2->row()->id;
									$sql = "INSERT INTO matches_log (match_id, pair1_id, pair2_id, pair1_price, pair2_price, created) VALUES (".$this->db->escape($match_id).", ".$this->db->escape($vv["pair_id"]).", ".$this->db->escape($v[$i]["pair_id"]).", ".$this->db->escape($vv["price"]).", ".$this->db->escape($v[$i]["price"]).", ".$this->db->escape($time).")";
									$this->db->query($sql);
								}
							} else {
								// save pair to check if match is active to end
								$followup[] = array("pair1_id" => $vv["pair_id"], "pair2_id" => $v[$i]["pair_id"]);
							}
						}
					}
				}
				
			}
		}
		return $this->generateFollowUp($followup);
	}

	public function generatePairEvents() {

	}

	public function generatePairArbitrateEvents() {
				$sql = "SELECT 
				        	mp.market_id, 
				        	mp.currency_id, 
				        	mp.symbol_id, 
				        	m.name as 'market',
				        	c.abbr as 'currency_abbr', 
				        	s.abbr as 'symbol_abbr',
				        	p.price 
				        	FROM markets_pairs mp
				        	LEFT JOIN markets m ON m.id = mp.market_id
				        	LEFT JOIN currency c ON c.id = mp.currency_id
				        	LEFT JOIN symbols s ON s.id = mp.symbol_id
				        	JOIN price_chart p ON p.id =(
								SELECT
									MAX(z.id)
								FROM
									price_chart z
								WHERE
									z.currency_id = mp.currency_id
								AND z.market_id = mp.market_id
								AND z.symbol_id = mp.symbol_id
							)  
				        	WHERE 
				        	EXISTS(SELECT 1 FROM markets mm WHERE mm.id = mp.market_id AND mm.active = '1')
				        	AND mp.active = '1'
	        	";
	        
	        	$query = $this->db->query($sql);
	        	if ($query->num_rows() > 0) {
	        		$sortcalls = [];
	        		$sortcallsSym = [];
	        		foreach ($query->result_array() as $v) {
	        			// to minimize the amount of calls I make to crypto compare I must first organize calls
	        			$sortcalls[$v["market_id"].$v["currency_id"]] = array(
	        				"market_id" => $v["market_id"],
	        				"currency_id" => $v["currency_id"],
	        				"currency" => $v["currency_abbr"],
	        				"market" => $v["market"]
	        			);
	        			$sortcallsSym[$v["market_id"].$v["currency_id"]]["symbols"][] = $v["symbol_abbr"];
	        			$sortcallsSym[$v["market_id"].$v["currency_id"]]["symbols_id"][] = $v["symbol_id"];
	        			
	        		}
	        		foreach ($sortcallsSym as $k => $v) {
	        			$sortcalls[$k]["symbols"] = $v["symbols"];
	        			$sortcalls[$k]["symbols_id"] = $v["symbols_id"];
	        		}
	        		
	        		$calls = [];  
	        		foreach ($sortcalls as $k => $v) {
	        			// get the special keyname by symbols
	        			$symbolKey = "";
	        			foreach ($v["symbols_id"] as $vv) {
	        				$symbolKey .= $vv;
	        			}
	        			$calls[$v["market_id"].$symbolKey] = array(
	        				"market" => $v["market"],
	        				"market_id" => $v["market_id"],
	        				"symbols" => $v["symbols"],
	        				"symbols_id" => $v["symbols_id"],
	        				"currency" => array(),
	        				"currency_id" => array()
	        			); 
	        		}
	        		foreach ($sortcalls as $k => $v) {
	        			// get the special keyname by symbols
	        			$symbolKey = "";
	        			foreach ($v["symbols_id"] as $vv) {
	        				$symbolKey .= $vv;
	        			}
	        			$calls[$v["market_id"].$symbolKey]["currency"][] = $v["currency"];
	        			$calls[$v["market_id"].$symbolKey]["currency_id"][] = $v["currency_id"];
	        		}
	        	}
	        	echo "<pre>";
	        	var_dump($calls);
	        	echo "</pre>";
	}

	public function generateFollowUp($checkData=array()) {
		if (count($checkData) > 0) {
			// check if the data in $checkData has an open id, if so, close it.
			$time = time();
			$deleteIDs = [];
			$sql = "SELECT id, pair1_id, pair2_id FROM matches WHERE finished IS NULL";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $res) {
					foreach ($checkData as $d) {
						if ($res["pair1_id"] == $d["pair1_id"] && $res["pair2_id"] == $d["pair2_id"]) {
							$deleteIDs[] = $res["id"];
						}
					}
				}
			} else {
				return TRUE;
			}
			if (count($deleteIDs) > 0) {
				$instatement = implode(',',$deleteIDs);
				$sql = "UPDATE matches SET finished = ".$this->db->escape($time)." WHERE id IN (".$instatement.")";
				$this->db->query($sql);
			}
			return TRUE;
		} else {
			$output = [];
			$sql = "SELECT pair1_id, pair2_id FROM matches WHERE finished IS NULL";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $res) {
					$output[$res["pair1_id"]] = $res["pair1_id"];
					$output[$res["pair2_id"]] = $res["pair2_id"];
				}
			}
		}
		return $output;
	}

}