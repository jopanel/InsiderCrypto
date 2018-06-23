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
					m.price,
					m.currency_id,
					m.market_id,
					m.lastupdate,
					m.symbol_id,
					m.id AS 'pair_id'
				FROM
					markets_pairs m 
				WHERE
					m.active = '1'
					AND
					m.price > '0'";
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
									$sql = "INSERT INTO matches_log (match_id, pair1_id, pair2_id, pair1_price, pair2_price, created, percent) VALUES (".$this->db->escape($match_id).", ".$this->db->escape($vv["pair_id"]).", ".$this->db->escape($v[$i]["pair_id"]).", ".$this->db->escape($vv["price"]).", ".$this->db->escape($v[$i]["price"]).", ".$this->db->escape($time).", ".$this->db->escape($percent).")";
									$this->db->query($sql);
								} else {
									// match doesnt exist
									$sql = "INSERT INTO matches (pair1_id, pair2_id, started) VALUES (".$this->db->escape($vv["pair_id"]).", ".$this->db->escape($v[$i]["pair_id"]).", ".$this->db->escape($time).")";
									$this->db->query($sql);
									$sql = "SELECT id FROM matches WHERE pair1_id = ".$this->db->escape($vv["pair_id"])." AND pair2_id = ".$this->db->escape($v[$i]["pair_id"])." AND finished IS NULL";
									$query2 = $this->db->query($sql);
									$match_id = $query2->row()->id;
									$sql = "INSERT INTO matches_log (match_id, pair1_id, pair2_id, pair1_price, pair2_price, created, percent) VALUES (".$this->db->escape($match_id).", ".$this->db->escape($vv["pair_id"]).", ".$this->db->escape($v[$i]["pair_id"]).", ".$this->db->escape($vv["price"]).", ".$this->db->escape($v[$i]["price"]).", ".$this->db->escape($time).", ".$this->db->escape($percent).")";
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
				$sql = "SELECT 
				        	mp.market_id, 
				        	mp.currency_id, 
				        	mp.symbol_id, 
				        	m.name as 'market',
				        	c.abbr as 'currency_abbr', 
				        	s.abbr as 'symbol_abbr',
				        	mp.id as 'market_pair',
				        	mp.price 
				        	FROM markets_pairs mp
				        	LEFT JOIN markets m ON m.id = mp.market_id
				        	LEFT JOIN currency c ON c.id = mp.currency_id
				        	LEFT JOIN symbols s ON s.id = mp.symbol_id  
				        	WHERE 
				        	EXISTS(SELECT 1 FROM markets mm WHERE mm.id = mp.market_id AND mm.active = '1')
				        	AND NOT EXISTS(SELECT 1 FROM symbols ss WHERE c.abbr = ss.abbr)
				        	AND mp.active = '1'
				        	AND mp.price > '0'
	        	";
	        	//echo 1;
	        	$query = $this->db->query($sql);
	        	if ($query->num_rows() > 0) {
	        		$orgArr = [];
	        		$symbols = [];
	        		$presymbols = [];
	        		$presymbolsnoescape = [];
	        		foreach ($query->result_array() as $res) {
	        			$orgArr[$res["market_id"]][$res["symbol_id"]][$res["currency_id"]] = $res;
	        			$presymbols[$res["symbol_id"]] = "'".$res["symbol_abbr"]."'";
	        			$presymbolsid[$res["symbol_id"]] = "'".$res["symbol_id"]."'";
	        			$presymbolsnoescape[$res["symbol_id"]] = $res["symbol_abbr"];
	        		} 
	        		//echo 2;
	        		// get bitcoin symbol_id 
	        		$sql = "SELECT id FROM symbols WHERE abbr = 'BTC' LIMIT 1";
	        		$query2 = $this->db->query($sql);
	        		if ($query2->num_rows() > 0) {
	        			$btc_symbol_id = $query2->row()->id;
	        		} else {
	        			return FALSE;
	        		}
	        		//echo 3;
	        		// get bitcoin currency_id
	        		$sql = "SELECT id FROM currency WHERE abbr = 'BTC' LIMIT 1";
	        		$query2 = $this->db->query($sql);
	        		if ($query2->num_rows() > 0) {
	        			$btc_currency_id = $query2->row()->id;
	        		} else {
	        			return FALSE;
	        		}
	        		//echo 4;
	        		// get btc current usd price
	        		$sql = "SELECT cost FROM bitcoin_value ORDER BY id DESC LIMIT 1";
	        		$query2 = $this->db->query($sql);
	        		if ($query2->num_rows() > 0) {
	        			$bitcoin_usd_value = $query2->row()->cost;
	        		} else {
	        			return FALSE;
	        		}
	        		//echo 5;
					/*$sql = "SELECT
								ROUND(p.price,2) as 'price',
								p.symbol_id
							FROM
								price_chart p
							LEFT JOIN 
								price_chart pp ON 
								(p.symbol_id = pp.symbol_id AND p.currency_id = pp.currency_id AND p.lastupdate < pp.lastupdate)
							WHERE
								p.symbol_id IN(".implode(",",$presymbolsid).")
							AND p.currency_id = ".$this->db->escape($btc_currency_id)."
							AND NOT EXISTS(
								SELECT
									1
								FROM
									markets_pairs mp
								WHERE
									mp.symbol_id = p.symbol_id
								AND mp.currency_id = p.currency_id
								AND mp.market_id = p.market_id
								AND mp.active = '0'
							)
							AND p.volume24hour > 0
							AND pp.lastupdate is NULL";*/
						$sql = "SELECT
									ROUND(mp.price, 2)AS 'price',
									mp.symbol_id
								FROM
									markets_pairs mp 
								WHERE
									mp.symbol_id IN(
										".implode(",",$presymbolsid)."
									)
								AND mp.currency_id = ".$this->db->escape($btc_currency_id)."
								AND mp.volume24hour > 0
								AND mp.price > 0
								AND mp.active = '1'";
							//echo $sql;
							//echo "<br><br><br>";
	        		$query2 = $this->db->query($sql);
	        		$presymbols = $presymbolsid = $presymbolsnoescape = null;
	        		if ($query2->num_rows() > 0) {
	        			foreach ($query2->result_array() as $res) {
	        				$symbols[$res["symbol_id"]] = array("symbol_id" => $res["symbol_id"], "btc_cost" => $res["price"]);
	        			}
	        		} else {
	        			return FALSE;
	        		} 
	        		//echo 6;
	        		$marketData = [];
	        		foreach ($orgArr as $market_id => $mArr) {
	        			foreach ($mArr as $sym_id => $cArr) {
	        				foreach ($cArr as $cur_id => $cur_data) {
	        					if (isset($symbols[$sym_id]["btc_cost"]) || !empty($symbols[$sym_id]["btc_cost"])) {

		        					$usd_val = (($bitcoin_usd_value / $symbols[$sym_id]["btc_cost"]) * $cur_data["price"]);  
		        					$marketData[$market_id][$sym_id][$cur_id] = array("market_price" => $cur_data["price"], "usd_cost" => $usd_val, "pair_id" => $cur_data["market_pair"]);
	        					}
	        					
	        				}
	        			}
	        		}
	        	
	        		$pairsFound = [];
	        		foreach ($marketData as $market_id => $mArr) {
	        			foreach ($mArr as $sym_id => $cArr) {
	        				foreach ($cArr as $cur_id => $cur_data) {
	        					foreach ($marketData as $market_id2 => $mArr2) {
				        			foreach ($mArr2 as $sym_id2 => $cArr2) {
				        				foreach ($cArr2 as $cur_id2 => $cur_data2) {
				        					if ($sym_id2 != $sym_id && $cur_id2 == $cur_id) {
				        						$percent = $this->calculatePercentage($cur_data["usd_cost"],$cur_data2["usd_cost"]); 
				        						$pairsFound[] = array("pair1_id" => $cur_data["pair_id"], "pair1_price" => $cur_data["market_price"], "pair2_id" => $cur_data2["pair_id"], "pair2_price" => $cur_data2["market_price"], "percent" => $percent); 
				        					}
				        				}
				        			}
				        		}
	        				}
	        			}
	        		}  
	        		
	        		$started = time();
	        		$marketData = null;
	        		foreach ($pairsFound as $m) { 
	        			$sql = "SELECT
									EXISTS(
										SELECT
											1
										FROM
											matches m
										WHERE
											m.pair1_id = ".$this->db->escape($m["pair1_id"])."
										AND m.pair2_id = ".$this->db->escape($m["pair2_id"])."
										AND m.finished IS NULL
										LIMIT 1
									)AS 'e' 
								";
	        			$query = $this->db->query($sql);
	        			if ($query->row()->e == 1) {
	        				// has open match,  check if percent > 3, if so insert history new row else close match
	        				if ($m["percent"] > 3) {
	        					$sql = "SELECT id FROM matches WHERE pair1_id = ".$this->db->escape($m["pair1_id"])." AND pair2_id = ".$this->db->escape($m["pair2_id"])." AND finished IS NULL";
	        					$query2 = $this->db->query($sql);
	        					$match_id = $query2->row()->id;
	        					$sql = "INSERT INTO matches_log (match_id, pair1_id, pair2_id, pair1_price, pair2_price, percent, created) VALUES (".$this->db->escape($match_id).", ".$this->db->escape($m["pair1_id"]).", ".$this->db->escape($m["pair2_id"]).", ".$this->db->escape($m["pair1_price"]).", ".$this->db->escape($m["pair2_price"]).", ".$this->db->escape($m["percent"]).", ".$this->db->escape($started).")";
	        					$this->db->query($sql);
	        				} else {

	        					$sql = "SELECT id, started FROM matches WHERE pair1_id = ".$this->db->escape($m["pair1_id"])." AND pair2_id = ".$this->db->escape($m["pair2_id"])." AND finished IS NULL";
	        					$query2 = $this->db->query($sql);
	        					$match_id = $query2->row()->id;
	        					$started = $query2->row()->started;
	        					$sql = "SELECT
											COALESCE(AVG(pair1_price), 0)AS 'avg_price_pair1',
											COALESCE(AVG(pair2_price), 0)AS 'avg_price_pair2',
											COALESCE(AVG(percent), 0)AS 'avg_percent',
											COALESCE(COUNT(id), 0)AS 'price_calls',
											COALESCE(MIN(pair1_price), 0)AS 'low_price_pair1',
											COALESCE(MIN(pair2_price), 0)AS 'low_price_pair2',
											COALESCE(MAX(pair1_price), 0)AS 'high_price_pair1',
											COALESCE(MAX(pair2_price), 0)AS 'high_price_pair2',
											GROUP_CONCAT(id)AS 'ids'
										FROM
											matches_log
										WHERE
											match_id = ".$this->db->escape($match_id);
								$query3 = $this->db->query($sql); 
								$sql = "INSERT INTO match_history (match_id, pair1_id, pair2_id, started, finished, avg_percent, price_calls, avg_price_pair1, avg_price_pair2, low_price_pair1, low_price_pair2, high_price_pair1, high_price_pair2) VALUES (".$this->db->escape($match_id).", ".$this->db->escape($m["pair1_id"]).", ".$this->db->escape($m["pair2_id"]).", ".$this->db->escape($started).",".$this->db->escape(time()).", ".$this->db->escape($query3->row()->avg_percent).", ".$this->db->escape($query3->row()->price_calls).", ".$this->db->escape($query3->row()->avg_price_pair1).", ".$this->db->escape($query3->row()->avg_price_pair2).", ".$this->db->escape($query3->row()->low_price_pair1).", ".$this->db->escape($query3->row()->low_price_pair2).", ".$this->db->escape($query3->row()->high_price_pair1).", ".$this->db->escape($query3->row()->high_price_pair2).")";
								$this->db->query($sql);
								$sql = "DELETE FROM matches WHERE match_id = ".$this->db->escape($match_id);
								$this->db->query($sql);
								$sql = "DELETE FROM matches_log WHERE match_id = ".$this->db->escape($match_id);
								$this->db->query($sql);
	        				}
	        			} else { 
	        				// if percent > 3 insert new row
	        				if ($m["percent"] > 3) {
	        					$sql = "INSERT INTO matches (pair1_id, pair2_id, started) VALUES (".$this->db->escape($m["pair1_id"]).", ".$this->db->escape($m["pair2_id"]).", ".$this->db->escape($started).")";
	        					$this->db->query($sql);
	        					$sql = "SELECT id FROM matches WHERE pair1_id = ".$this->db->escape($m["pair1_id"])." AND pair2_id = ".$this->db->escape($m["pair2_id"])." AND finished IS NULL";
	        					$query2 = $this->db->query($sql);
	        					$match_id = $query2->row()->id;
	        					$sql = "INSERT INTO matches_log (match_id, pair1_id, pair2_id, pair1_price, pair2_price, percent, created) VALUES (".$this->db->escape($match_id).", ".$this->db->escape($m["pair1_id"]).", ".$this->db->escape($m["pair2_id"]).", ".$this->db->escape($m["pair1_price"]).", ".$this->db->escape($m["pair2_price"]).", ".$this->db->escape($m["percent"]).", ".$this->db->escape($started).")";
	        					$this->db->query($sql);
	        				}
	        			}
	        		} 
	        		
	        		return TRUE;
	        	}

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