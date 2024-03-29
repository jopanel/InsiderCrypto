<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Cryptocompare;

class Cryptocompareapi extends Model
{


		/*
		I'm not interested in Lambo Land. Maybe Porsche GT3RS Land though. 
		▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄
		█░░░░░░░░▀█▄▀▄▀██████░▀█▄▀▄▀██████                                    
		░░░░ ░░░░░░░▀█▄█▄███▀░░░ ▀█▄█▄███
        */

		private $timeoutPeriod = 2; // how many minutes to wait before checking for new pricing data
		private $weeksBeforeReset = 1; // how many weeks to wait until check for new market/currency/pairs
		private $daysBeforeDisable = 3; // amount of days to wait before deactivating a market pair based on last update

		public function activateExchanges() {
			// set the exchanges that should be set to active
			// active exchanges actively pull price information
			// database may be manually changed to on position but this works for initial setup
			/*$exchanges = array(
				"Poloniex" => 1,
				"Binance" => 1,
				"YoBit" => 1,
				"Bittrex" => 1,
				"Kucoin" => 1,
				"Liqui" => 1,
				"Coinbase" => 1

			);*/
			$exchanges = [];
			foreach ($exchanges as $k => $v) {
				$sql = "UPDATE markets SET active = ".$this->db->escape($v)." WHERE name = ".$this->db->escape($k);
				$this->db->query($sql);
			}
			return TRUE;
		}

        public function build() {
        	date_default_timezone_set('America/Los_Angeles');
        	ini_set('max_execution_time', 0);
        	set_time_limit(0);
        	// check if the last call is older than timeout period
        	$timeoutPeriod = strtotime("-".$this->timeoutPeriod." minutes");
        	$sql = "SELECT lastupdate FROM last_update ORDER BY id DESC LIMIT 1";
        	$query = DB::select($sql);
        	if (count($query) > 0) {
        		$lastupdate = $query[0]->lastupdate;
        		// check last update table again for the reset column
        		$sql2 = "SELECT lastupdate FROM last_update WHERE reset = '1' ORDER BY id DESC LIMIT 1";
        		$query2 = DB::select($sql2);
        		$lastreset = $query2[0]->lastupdate;
        		if ($lastreset < strtotime("-".$this->weeksBeforeReset." week")) {
        			$this->generateCurrency();
        			return TRUE;
        		}
        		if ($lastupdate < $timeoutPeriod) {
        			$this->generatePrices();
        			return TRUE;
        		} else {
        			return FALSE; // Has not waited long enough before next price check
        		}
        	} else {
        		// most likely first run, so generate markets and market pairs
        		$this->generateCurrency();
        		return TRUE;
        	}
        }

        public function generateCurrency() {
        	$cryptocompareCoin = new Cryptocompare\Coin();
        	$dataObj = $cryptocompareCoin->getList();
        	foreach ($dataObj->Data as $k => $v) {
        		$sql = "SELECT 1 FROM currency WHERE name = :name AND abbr = :symbol";
        		$query = DB::select($sql, ["name" => $v->Name, "symbol" => $v->Symbol]);
        		if (count($query) == 0) {
        			$sql = "INSERT INTO currency (name, abbr) VALUES (?, ?)";
        			DB::insert($sql, [$v->Name, $v->Symbol]);
        		}
        	}
        	$dataObj = null;
        	$cryptocompareCoin = null;
        	$this->generateMarkets();
        }

        public function generateMarkets() {
        	$cryptocompareMarket = new Cryptocompare\Market();
        	$dataObj = $cryptocompareMarket->getList(); 
        	// insert new exchanges 
        	foreach ($dataObj as $k => $v) {
        		$sql = "SELECT 1 FROM markets WHERE name = ?";
        		$query = DB::select($sql, [$k]);
        		if (count($query) == 0) {
        			$sql = "INSERT INTO markets (name, active) VALUES (?, '1')";
        			DB::insert($sql, [$k]);
        		}
        	}
        	// insert new pairs for exchanges
        	foreach ($dataObj as $k => $v) {
        		// loop through exchange results
        		foreach ($v as $kk => $vv) {
        			$requirements = 0;
        			// get currency_id
        			$sql = "SELECT id FROM currency WHERE abbr = ?";
        			$query = DB::select($sql, [$kk]);
        			if (count($query) > 0) {
        				$currency_id = $query[0]->id;
        				$requirements += 1;
        			} 
        			// get market_id
        			$sql2 = "SELECT id FROM markets WHERE name = ?";
        			$query2 = DB::select($sql2, [$k]);
        			if (count($query2) > 0) {
        				$market_id = $query2[0]->id;
        				$requirements += 1;
        			}
        			if ($requirements == 2) {
        				// get symbol_id, if not exist, create
	        			foreach ($vv as $sym) {
	        				$continue = 0;
	        				$sql3 = "SELECT id FROM symbols WHERE abbr = ?";
	        				$query3 = DB::select($sql3, [$sym]);
	        				if (count($query3) > 0) {
	        					$symbol_id = $query3[0]->id;
	        					$continue = 1;
	        				} else {
	        					$sql4 = "INSERT INTO symbols (abbr) VALUES (?)";
	        					DB::insert($sql4, [$sym]);
	        					$sql5 = "SELECT id FROM symbols WHERE abbr = ?";
	        					$query5 = DB::select($sql5, [$sym]);
	        					if (count($query5) > 0) {
	        						$continue = 1;
	        						$symbol_id = $query5[0]->id;
	        					}
	        				}
	        				if ($continue == 1) {
	        					// check if the market pair already exists
	        					$sql6 = "SELECT 1 FROM markets_pairs WHERE market_id = ? AND currency_id = ? AND symbol_id = ?";
	        					$query6 = DB::select($sql6, [$market_id, $currency_id, $symbol_id]);
	        					if (count($query6) == 0) {
	        						// doesnt exist, insert
	        						$sql7 = "INSERT INTO markets_pairs (market_id, currency_id, symbol_id) VALUES (?, ?, ?)";
	        						DB::insert($sql7, [$market_id, $currency_id, $symbol_id]);
	        					}
	        				} else {
	        					// something went wrong with the symbols
	        				}
	        			}
        			} else {
        				// did not meet the requirements, missing currency_id or market_id
        			}
        		} 
        	}
        	//$this->activateExchanges(); 
        	date_default_timezone_set('America/Los_Angeles');
        	$sql = "INSERT INTO last_update (lastupdate, reset) VALUES (?, '1')";
        	DB::insert($sql, [time()]);
        	$this->generatePrices();
        }

        public function generatePrices($followUps=array()) {
        	$this->getBitcoinValue();
        	$insertSQL = []; 
        	if (count($followUps) > 0) {
        		$sql = "SELECT 
				        	mp.market_id, 
				        	mp.currency_id, 
				        	mp.symbol_id, 
				        	m.name as 'market',
				        	c.abbr as 'currency_abbr', 
				        	s.abbr as 'symbol_abbr' 
				        	FROM markets_pairs mp
				        	LEFT JOIN markets m ON m.id = mp.market_id
				        	LEFT JOIN currency c ON c.id = mp.currency_id
				        	LEFT JOIN symbols s ON s.id = mp.symbol_id  
				        	WHERE 
				        	EXISTS(SELECT 1 FROM markets mm WHERE mm.id = mp.market_id AND mm.active = '1')
				        	AND mp.id IN (?)
				        	AND mp.active = '1'
				        	ORDER BY s.abbr ASC
	        	";
	        	$query = DB::select($sql, [implode(",",$followUps)]);
        	} else {
				$sql = "SELECT 
				        	mp.market_id, 
				        	mp.currency_id, 
				        	mp.symbol_id, 
				        	m.name as 'market',
				        	c.abbr as 'currency_abbr', 
				        	s.abbr as 'symbol_abbr' 
				        	FROM markets_pairs mp
				        	LEFT JOIN markets m ON m.id = mp.market_id
				        	LEFT JOIN currency c ON c.id = mp.currency_id
				        	LEFT JOIN symbols s ON s.id = mp.symbol_id  
				        	WHERE 
				        	EXISTS(SELECT 1 FROM markets mm WHERE mm.id = mp.market_id AND mm.active = '1')
				        	AND mp.active = '1'
				        	ORDER BY s.abbr ASC
	        	";
	        	$query = DB::select($sql);
	        } 
	        	if (count($query) > 0) {
	        		$sortcalls = [];
	        		$sortcallsSym = [];
	        		foreach (json_decode(json_encode($query), true) as $v) {  
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

	 

	        		$calls = $this->cleanPriceData($calls); 
	        		$sortcalls = null;
	        		$callcounter = 0;
	        		echo "calls: ".count($calls)."<br>";
	        		foreach ($calls as $v) {
	        			$callcounter += 1;
	        			if ($callcounter == 5) {
	        				sleep(1);
	        				$callcounter = 1;
	        			}   
	        			$this->curl_post_async(url('/').'/api/asyncPriceRequest', $v);
	        			
	        		}
	        	}

	        
        	$sql = "INSERT INTO last_update (lastupdate) VALUES (?)";
        	DB::insert($sql, [time()]);
        	return TRUE;
        }

        public function cleanPriceData($calls=array()) {
        	$output = [];
        	foreach ($calls as $k => $v) {
        		if (count($v["currency"]) > 50) { 
        			$keybuilder = $k + 1;
        			$counter = -1;
        			foreach ($v["currency"] as $key => $val) {
        				$counter += 1;
        				if ($counter == 50) {
        					$counter = 0;
        					$keybuilder += 1;
        				}
        				$output[$keybuilder]["market"] = $v["market"];
        				$output[$keybuilder]["market_id"] = $v["market_id"];
        				$output[$keybuilder]["symbols"] = $v["symbols"];
        				$output[$keybuilder]["symbols_id"] = $v["symbols_id"];
        				$output[$keybuilder]["currency"][] = $val;
        				$output[$keybuilder]["currency_id"][] = $v["currency_id"][$key];
        			}
        		} else {
        			$output[] = $v;
        		}
        	}
        	return $output;
        }

        public function priceDataParse($calls=array()) { 
        		$insertSQL = [];
        		$v = json_decode($calls, TRUE);  
        		$cryptocomparePrice = new Cryptocompare\Price(); 

	        			$getPrices = $cryptocomparePrice->getMultiPriceFull($v["currency"], $v["symbols"],$v["market"]); 
	        			$disableDate = strtotime("-".$this->daysBeforeDisable." days"); 
	        			if (!isset($getPrices->RAW) || empty($getPrices->RAW)) {
	        				if (!isset($getPrices->Message) || empty($getPrices->Message)) {
	        					$sql = "INSERT INTO api_errors (error, json, created) VALUES ('No Message, Price API', ?, ?)";
	        					DB::insert($sql, [json_encode($v), time()]);
	        				} else {
	        					if ($this->handle_price_error($getPrices->Message, $v) == FALSE) {
	        						$sql = "INSERT INTO api_errors (error, json, created) VALUES ('Price API', ?, ?)";
									$this->db->query($sql, [json_encode($getPrices), time()]);
	        					}
	        				} 
	        			} else {
	        				foreach ($getPrices->RAW as $currency => $pairSets) {
		        				foreach ($pairSets as $pair => $pairData) {
		        					// obtain the currency_id and symbol_id
		        					$currency_id = 0;
		        					$symbol_id = 0;
		        					foreach ($v["currency"] as $keyNum => $cur) {
		        						if ($cur == $pairData->FROMSYMBOL) {
		        							$currency_id = $v["currency_id"][$keyNum];
		        						}
		        					}
		        					foreach ($v["symbols"] as $keyNum => $sym) {
		        						if ($sym == $pairData->TOSYMBOL) {
		        							$symbol_id = $v["symbols_id"][$keyNum];
		        						}
		        					}
		        					if ($currency_id > 0 && $symbol_id > 0) {
		        						// check if last update is old and pair data should be disabled before continuing
			        					if ($pairData->LASTUPDATE < $disableDate || !isset($pairData->LASTUPDATE) || empty($pairData->LASTUPDATE)) { 
			        						$updateSQLBAD[] = array(
			        							"currency_id" => $currency_id,
			        							"market_id" => $v["market_id"],
			        							"symbol_id" => $symbol_id
			        						);
			        					} else {
			        						/*$insertSQL[] ="
			        						(".$this->db->escape($v["market_id"]).",
			        						".$this->db->escape($currency_id).",
			        						".$this->db->escape($symbol_id).",
			        						".$this->db->escape($pairData->PRICE).",
			        						".$this->db->escape($pairData->LASTUPDATE).",
			        						".$this->db->escape($pairData->LOW24HOUR).",
			        						".$this->db->escape($pairData->HIGH24HOUR).",
			        						".$this->db->escape($pairData->CHANGEPCT24HOUR).",
			        						".$this->db->escape($pairData->VOLUME24HOURTO).",
			        						".$this->db->escape(time()).")";*/
			        						$updateSQL[] = array(
			        							"currency_id" => $currency_id,
			        							"market_id" => $v["market_id"],
			        							"symbol_id" => $symbol_id,
			        							"volume24hour" => $pairData->VOLUME24HOURTO,
			        							"price" => $pairData->PRICE,
			        							"lastupdate" => $pairData->LASTUPDATE
			        						);
			        					}
		        					} else {
		        						// problem obtaining symbol_id and currency_id
		        					}
		        				}
		        			}
	        			}
	        			
	        		

	        		if (count($updateSQL) > 0) {
			      //   	$sql = "INSERT INTO price_chart 
					    //     						(market_id, 
					    //     						currency_id,
					    //     						symbol_id,
					    //     						price,
					    //     						lastupdate,
					    //     						price_low,
					    //     						price_high,
					    //     						changepct24hour,
					    //     						volume24hour,
					    //     						created) VALUES ".implode(",",$insertSQL).";";
					    // $this->db->query($sql);
					    if (count($updateSQL) > 0) {
					    	foreach ($updateSQL as $q) {
						    	$sql = "UPDATE markets_pairs SET volume24hour = ?, price = ?, lastupdate = ? WHERE market_id = ? AND currency_id = ? AND symbol_id = ?";
						    	DB::update($sql, [$q["volume24hour"], $q["price"], $q["lastupdate"], $q["market_id"], $q["currency_id"], $q["symbol_id"]]);
						    }
					    }
					    if (count($updateSQLBAD) > 0) {
					    	foreach ($updateSQLBAD as $q) {
					    		$sql = "UPDATE markets_pairs SET active = '0' WHERE market_id = ? AND currency_id = ? AND symbol_id = ?";
						    	DB::update($sql, [$q["market_id"], $q["currency_id"], $q["symbol_id"]]);
					    	}
					    }
			        }

        }

        public function curl_post_async($url, $params = array()){ 
	            $post_string = $params;
	            $parts = parse_url($url);
	            $fp = fsockopen($parts['host'],
	                isset($parts['port'])?$parts['port']:80,
	                $errno, $errstr, 30);
				$content = http_build_query($params); 
				fwrite($fp, "POST ".$parts['path']." HTTP/1.1\r\n");
				fwrite($fp, "Host: ".$parts['host']."\r\n");
				fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
				fwrite($fp, "Content-Length: ".strlen($content)."\r\n");
				fwrite($fp, "Connection: close\r\n");
				fwrite($fp, "\r\n");
				fwrite($fp, $content);
				fclose($fp); 
				return;
	    }

        public function getBitcoinValue() {
        	date_default_timezone_set('America/Los_Angeles');
        	$cryptocomparePrice = new Cryptocompare\Price();
			$getPrice = $cryptocomparePrice->getSingleSymbolPriceEndpoint(true, "BTC","USD","Coinbase"); 
			$sql = "INSERT INTO bitcoin_value (fiat,cost,updated) VALUES ('USD', ?, ?)";
			DB::insert($sql, [$getPrice->USD, time()]);
			return TRUE;
        }

        public function handle_price_error($error, $price_array) {
        	// detect if pair doesnt exist, fix database for future calls
        	if (strpos($error, 'market does not exist for this coin pair') !== false) {
			    $createarr = explode("(", $error);
				$prepare = str_replace(')', '', $createarr[1]);
				$newarr = explode("-", $prepare);
				$currency = $newarr[0];
				$symbol = $newarr[1];
				// find currency_id and symbol_id without using database
					$symbol_id = 0;
					$currency_id = 0;
					foreach ($price_array["currency"] as $k => $v) {
						if ($v == $currency) {
							if (!isset($price_array["symbols_id"][$k])) {
								return FALSE;
							}
							if (!isset($price_array["currency_id"][$k])) {
								return FALSE;
							}
							$symbol_id = $price_array["symbols_id"][$k];
							$currency_id = $price_array["currency_id"][$k];
						}
					}
				
				if ($symbol_id > 0 && $currency_id > 0) {
					$market_id = $price_array["market_id"];
					$sql = "UPDATE markets_pairs SET active = '0' WHERE market_id = ? AND symbol_id = ? AND currency_id = ?";
					DB::update($sql, [$market_id, $symbol_id, $currency_id]);
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return FALSE; // will create more handlers when i find more errors
			}
        }

}