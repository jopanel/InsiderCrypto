<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Cryptocompare;

class Compare extends Model
{

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
		$query = DB::select($sql);
		if (count($query) > 0) {
			foreach (json_decode(json_encode($query), true) as $res) {
				$data[$res["currency_id"].$res["symbol_id"]][] = array("price"=>(float)$res["price"], "market_id"=>$res["market_id"], "lastupdate"=>$res["lastupdate"], "pair_id" => $res["pair_id"]);
			}
		}

		foreach ($data as $k => $v) {
			$forcount = count($v);
			if ($forcount > 1) {
				foreach ($v as $kk => $vv) {
					for ($i = 0; $i < $forcount; $i++) {
						if ($kk != $i) {

							$percent = $this->calculatePercentage((float)$vv["price"], (float)$v[$i]["price"]);
							//dd(["first_price"=>$vv["price"], "second_price"=>$v[$i]["price"], "percent"=>$percent]);
							if ($percent > 3) {
								//check if match is active
								$sql = "SELECT id FROM matches WHERE pair2_id = ? AND pair1_id = ? AND finished IS NULL";
								$query = DB::select($sql, [$vv["pair_id"], $v[$i]["pair_id"]]);
								if (count($query) > 0) {
									// match is active
									$match_id = $query[0]->id;
									$sql = "UPDATE matches SET percent = ? WHERE id = ?";
									DB::update($sql, [$percent, $query[0]->id]);
								} else {
									// match doesnt exist
									$sql = "INSERT INTO matches (pair1_id, pair2_id, started, percent) VALUES (?, ?, ?, ?)";
									DB::insert($sql, [$v[$i]["pair_id"], $vv["pair_id"], $time, $percent]);
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
	        	$query = DB::select($sql);
	        	if (count($query) > 0) {
	        		$orgArr = []; 
	        		$presymbolsid = []; 
	        		foreach (json_decode(json_encode($query), true) as $res) {
	        			$orgArr[$res["market_id"]][$res["symbol_id"]][$res["currency_id"]] = $res; 
	        			$presymbolsid[$res["symbol_id"]] = "'".$res["symbol_id"]."'"; 
	        		} 
	        		//echo 2;
	        		// get bitcoin symbol_id 
	        		$sql = "SELECT id FROM symbols WHERE abbr = 'BTC' LIMIT 1";
	        		$query2 = DB::select($sql);
	        		if (count($query2) > 0) {
	        			$btc_symbol_id = $query2[0]->id;
	        		} else {
	        			return FALSE;
	        		}
	        		//echo 3;
	        		// get bitcoin currency_id
	        		$sql = "SELECT id FROM currency WHERE abbr = 'BTC' LIMIT 1";
	        		$query2 = DB::select($sql);
	        		if (count($query2) > 0) {
	        			$btc_currency_id = $query2[0]->id;
	        		} else {
	        			return FALSE;
	        		}
	        		//echo 4;
	        		// get btc current usd price
	        		$sql = "SELECT cost FROM bitcoin_value ORDER BY id DESC LIMIT 1";
	        		$query2 = DB::select($sql);
	        		if (count($query2) > 0) {
	        			$bitcoin_usd_value = $query2[0]->cost;
	        		} else {
	        			return FALSE;
	        		}
	        		//echo 5;
						$sql = "SELECT
									ROUND(AVG(mp.price), 2) AS 'price',
									mp.symbol_id
								FROM
									(SELECT symbol_id, MAX(volume24hour) as 'volume24hour', currency_id, price, active, lastupdate FROM markets_pairs WHERE currency_id = ? and price > 0 and lastupdate > ? GROUP BY symbol_id) mp 
								WHERE
									mp.symbol_id IN(
										?
									)
								AND mp.currency_id = ?
								AND mp.volume24hour > 0
								AND mp.price > 0
								AND mp.active = '1'
								GROUP BY 
								mp.symbol_id";
							//echo $sql; 
					// the script above gets how many of a specific currency is needed to equal 1 bitcoin. BUT its all over the place because I get the data from my internal data sources. Different exchanges contain different prices, an average of all is still very different from USD to USDT even.
	        		$query2 = DB::select($sql, [$btc_currency_id, strtotime("-1 day"), implode(",",$presymbolsid), $btc_currency_id]);
	        		$presymbolsid = null;
	        		if (count($query2) > 0) {
	        			foreach (json_decode(json_encode($query2), true) as $res) {
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
				        						if ($percent > 3) {
				        							$pairsFound[] = array("pair1_id" => $cur_data["pair_id"], "pair1_price" => $cur_data["market_price"], "pair2_id" => $cur_data2["pair_id"], "pair2_price" => $cur_data2["market_price"], "percent" => $percent); 
				        						} 
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
											m.pair1_id = ?
										AND m.pair2_id = ?
										AND m.finished IS NULL
										LIMIT 1
									)AS 'e' 
								";
	        			$query = DB::select($sql, [$m["pair1_id"], $m["pair2_id"]]);
	        			if ($query[0]->e == 1) {
	        				// has open match,  check if percent > 3, if so insert history new row else close match
	        				if ($m["percent"] > 3) {
	        					$sql = "SELECT id FROM matches WHERE pair1_id = ? AND pair2_id = ? AND finished IS NULL";
	        					$query2 = DB::select($sql, [$m["pair1_id"], $m["pair2_id"]]);
	        					$match_id = $query2[0]->id;
	        					$sql = "UPDATE matches SET percent = ? WHERE id = ?";
	        					DB::update($sql, [$m["percent"], $match_id]);
	        				} else {

	        					$sql = "SELECT id, started FROM matches WHERE pair1_id = ? AND pair2_id = ? AND finished IS NULL";
	        					$query2 = DB::select($sql, [$m["pair1_id"], $m["pair2_id"]]);
	        					$match_id = $query2[0]->id;
	        					$started = $query2[0]->started; 
								$query3 = DB::select($sql, [$m["pair1_id"], $m["pair2_id"]]); 
								$sql = "INSERT INTO match_history (match_id, pair1_id, pair2_id, started, finished, avg_percent, price_calls, avg_price_pair1, avg_price_pair2, low_price_pair1, low_price_pair2, high_price_pair1, high_price_pair2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
								DB::insert($sql, [$match_id, $m["pair1_id"], $m["pair2_id"], $started, time(), 0, $query3[0]->price_calls, 0, 0, 0, 0, 0, 0]);
								$sql = "DELETE FROM matches WHERE match_id = ?";
								DB::delete($sql, [$match_id]); 
	        				}
	        			} else { 
	        				// if percent > 3 insert new row
	        				if ($m["percent"] > 3) {
	        					$sql = "INSERT INTO matches (pair1_id, pair2_id, started, percent) VALUES (?, ?, ?, ?)";
	        					DB::insert($sql, [$m["pair1_id"], $m["pair2_id"], $started, $m["percent"]]);
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
			$sql = "SELECT id, pair1_id, pair2_id, started, finished, percent FROM matches WHERE finished IS NULL";
			$query = DB::select($sql);
			if (count($query) > 0) {
				foreach (json_decode(json_encode($query), true) as $res) {
					foreach ($checkData as $d) {
						if ($res["pair1_id"] == $d["pair1_id"] && $res["pair2_id"] == $d["pair2_id"]) {
							$deleteIDs[] = $res["id"];
							$deleteData[$res["id"]] = $d;
						}
					}
				}
			} else {
				return TRUE;
			}
			if (count($deleteIDs) > 0) {
				$instatement = implode(',',$deleteIDs);
				$sql = "DELETE FROM matches WHERE id IN (?)";
				DB::delete($sql, [$instatement]); 
				//foreach ($deleteData as $k) {
					//$sql = "INSERT INTO match_history (match_id, pair1_id, pair2_id, started, finished, avg_percent, price_calls, avg_price_pair1, avg_price_pair2, low_price_pair1, low_price_pair2, high_price_pair1, high_price_pair2) VALUES (".$this->db->escape($k["id"]).", ".$this->db->escape($k["pair1_id"]).", ".$this->db->escape($k["pair2_id"]).", ".$this->db->escape($k["started"]).",".$this->db->escape(time()).", ".$this->db->escape(0).", ".$this->db->escape(0).", ".$this->db->escape(0).", ".$this->db->escape(0).", ".$this->db->escape(0).", ".$this->db->escape(0).", ".$this->db->escape(0).", ".$this->db->escape(0).")";
					//$this->db->query($sql);
				//}
			}
			return TRUE;
		} else {
			$output = [];
			$sql = "SELECT pair1_id, pair2_id FROM matches WHERE finished IS NULL";
			$query = DB::select($sql);
			if (count($query) > 0) {
				foreach (json_decode(json_encode($query), true) as $res) {
					$output[$res["pair1_id"]] = $res["pair1_id"];
					$output[$res["pair2_id"]] = $res["pair2_id"];
				}
			}
		}
		return $output;
	}

}
