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
		$sql = "SELECT p.price, m.currency_id, m.market_id, p.lastupdate, m.symbol_id, m.id as 'pair_id' FROM markets_pairs m 
				LEFT JOIN price_chart p ON m.currency_id = p.currency_id AND m.market_id = p.market_id 
				WHERE m.active = '1' 
				GROUP BY m.market_id, m.currency_id
				order by MAX(p.created) DESC";
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

		}
	}

}