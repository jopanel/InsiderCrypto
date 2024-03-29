<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class General extends Model
{

        protected function generateSalt() {
                $salt = "MA04UTNYG8251DDGHKK0582F2KGOUV29FG0YJT4JHW82OTJ20TJ02UHNJSPY853TT9M69RGYOYRT83PBUO3UN9PRYU0";
                return $salt;
        }

        protected function generateVerificationKey() {
                $length = 10;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
        } 

        protected function buildValidateEmail($email) {
            return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /><meta name='viewport' content='width=device-width, initial-scale=1.0'><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><meta name='format-detection' content='telephone=no' /> <style type='text/css'>html{background-color:#E1E1E1;margin:0;padding:0}body,#bodyTable,#bodyCell,#bodyCell{height:100% !important;margin:0;padding:0;width:100% !important;font-family:Helvetica,Arial,'Lucida Grande',sans-serif}table{border-collapse:collapse}table[id=bodyTable]{width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal}img, a img{border:0;outline:none;text-decoration:none;height:auto;line-height:100%}a{text-decoration:none !important;border-bottom:1px solid}h1,h2,h3,h4,h5,h6{color:#5F5F5F;font-weight:normal;font-family:Helvetica;font-size:20px;line-height:125%;text-align:Left;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}#outlook a{padding:0}img{-ms-interpolation-mode:bicubic;display:block;outline:none;text-decoration:none}body,table,td,p,a,li,blockquote{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-weight:normal!important}.ExternalClass td[class='ecxflexibleContainerBox'] h3{padding-top:10px !important}h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%}h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%}h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%}h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%}.flexibleImage{height:auto}.linkRemoveBorder{border-bottom:0 !important}table[class=flexibleContainerCellDivider]{padding-bottom:0 !important;padding-top:0 !important}body,#bodyTable{background-color:#E1E1E1}#emailHeader{background-color:#E1E1E1}#emailBody{background-color:#FFF}#emailFooter{background-color:#E1E1E1}.nestedContainer{background-color:#F8F8F8;border:1px solid #CCC}.emailButton{background-color:#205478;border-collapse:separate}.buttonContent{color:#FFF;font-family:Helvetica;font-size:18px;font-weight:bold;line-height:100%;padding:15px;text-align:center}.buttonContent a{color:#FFF;display:block;text-decoration:none!important;border:0!important}.emailCalendar{background-color:#FFF;border:1px solid #CCC}.emailCalendarMonth{background-color:#205478;color:#FFF;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:bold;padding-top:10px;padding-bottom:10px;text-align:center}.emailCalendarDay{color:#205478;font-family:Helvetica,Arial,sans-serif;font-size:60px;font-weight:bold;line-height:100%;padding-top:20px;padding-bottom:20px;text-align:center}.imageContentText{margin-top:10px;line-height:0}.imageContentText a{line-height:0}#invisibleIntroduction{display:none !important}span[class=ios-color-hack] a{color:#275100!important;text-decoration:none!important}span[class=ios-color-hack2] a{color:#205478!important;text-decoration:none!important}span[class=ios-color-hack3] a{color:#8B8B8B!important;text-decoration:none!important}.a[href^='tel'],a[href^='sms']{text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important}.mobile_link a[href^='tel'], .mobile_link a[href^='sms']{text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important}@media only screen and (max-width: 480px){/*/*/body{width:100% !important;min-width:100% !important}/**/ table[id='emailHeader'],table[id='emailBody'],table[id='emailFooter'],table[class='flexibleContainer'],td[class='flexibleContainerCell']{width:100% !important}td[class='flexibleContainerBox'], td[class='flexibleContainerBox'] table{display:block;width:100%;text-align:left}td[class='imageContent'] img{height:auto !important;width:100% !important;max-width:100% !important}img[class='flexibleImage']{height:auto !important;width:100% !important;max-width:100% !important}img[class='flexibleImageSmall']{height:auto !important;width:auto !important}table[class='flexibleContainerBoxNext']{padding-top:10px !important}table[class='emailButton']{width:100% !important}td[class='buttonContent']{padding:0 !important}td[class='buttonContent'] a{padding:15px !important}}@media only screen and (-webkit-device-pixel-ratio:.75){}@media only screen and (-webkit-device-pixel-ratio:1){}@media only screen and (-webkit-device-pixel-ratio:1.5){}@media only screen and (min-device-width : 320px) and (max-device-width:568px){}</style></head><body bgcolor='#E1E1E1' leftmargin='0' marginwidth='0' topmargin='0' marginheight='0' offset='0'><center style='background-color:#E1E1E1;'><table border='0' cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable' style='table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;'><tr><td align='center' valign='top' id='bodyCell'><table bgcolor='#E1E1E1' border='0' cellpadding='0' cellspacing='0' width='500' id='emailHeader'><tr><td align='center' valign='top'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td align='center' valign='top'><table border='0' cellpadding='10' cellspacing='0' width='500' class='flexibleContainer'><tr><td valign='top' width='500' class='flexibleContainerCell'><table align='left' border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td align='left' valign='middle' id='invisibleIntroduction' class='flexibleContainerBox' style='display:none !important; mso-hide:all;'><table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:100%;'><tr><td align='left' class='textContent'><div style='font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;'> The introduction of your message preview goes here. Try to make it short.</div></td></tr></table></td><td align='right' valign='middle' class='flexibleContainerBox'></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table bgcolor='#FFFFFF' border='0' cellpadding='0' cellspacing='0' width='500' id='emailBody'><tr><td align='center' valign='top'><table border='0' cellpadding='0' cellspacing='0' width='100%' style='color:#FFFFFF;' bgcolor='#3498db'><tr><td align='center' valign='top'><table border='0' cellpadding='0' cellspacing='0' width='500' class='flexibleContainer'><tr><td align='center' valign='top' width='500' class='flexibleContainerCell'><table border='0' cellpadding='30' cellspacing='0' width='100%'><tr><td align='center' valign='top' class='textContent'><h1 style='color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:35px;font-weight:normal;margin-bottom:5px;text-align:center;'>Validate Email</h1><h2 style='text-align:center;font-weight:normal;font-family:Helvetica,Arial,sans-serif;font-size:23px;margin-bottom:10px;color:#205478;line-height:135%;'>Crypto Insider Notifications</h2><div style='text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFFFFF;line-height:135%;'>To validate your email press the Validate Email button below.</div></td></tr></table></td></tr></table></td></tr></table></td></tr><tr mc:hideable><td align='center' valign='top'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td align='center' valign='top'><table border='0' cellpadding='30' cellspacing='0' width='500' class='flexibleContainer'><tr><td valign='top' width='500' class='flexibleContainerCell'><table align='left' border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td align='left' valign='top' class='flexibleContainerBox'><table border='0' cellpadding='0' cellspacing='0' width='210' style='max-width: 100%;'><tr><td align='left' class='textContent'><h3 style='color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;'>Earn More</h3><div style='text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;'>Set your preferences to get notified for the exchanges you set, the gains % threshold you set, when we find a match we will email you.</div></td></tr></table></td><td align='right' valign='middle' class='flexibleContainerBox'><table class='flexibleContainerBoxNext' border='0' cellpadding='0' cellspacing='0' width='210' style='max-width: 100%;'><tr><td align='left' class='textContent'><h3 style='color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;'>No Ads</h3><div style='text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;'>We won't spam you bs emails. Were all on the same team. If we email you not involving an opportunity to earn money it will be important.</div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td align='center' valign='top'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr style='padding-top:0;'><td align='center' valign='top'><table border='0' cellpadding='30' cellspacing='0' width='500' class='flexibleContainer'><tr><td style='padding-top:0;' align='center' valign='top' width='500' class='flexibleContainerCell'><table border='0' cellpadding='0' cellspacing='0' width='50%' class='emailButton' style='background-color: #3498DB;'><tr><td align='center' valign='middle' class='buttonContent' style='padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;'> <a style='color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;' href='".url('/')."api/validate/".$email."' target='_blank'>Validate Email</a></td></tr></table></td></tr></table></td></tr></table></td></tr><table bgcolor='#E1E1E1' border='0' cellpadding='0' cellspacing='0' width='500' id='emailFooter'><tr><td align='center' valign='top'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td align='center' valign='top'><table border='0' cellpadding='0' cellspacing='0' width='500' class='flexibleContainer'><tr><td align='center' valign='top' width='500' class='flexibleContainerCell'><table border='0' cellpadding='30' cellspacing='0' width='100%'><tr><td valign='top' bgcolor='#E1E1E1'><div style='font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;'><div>Insider Crypto</div><div>If you do not want to recieve emails from us, you can <a href='".url('/')."api/unsubscribe/".$email."' target='_blank' style='text-decoration:none;color:#828282;'><span style='color:#828282;'>unsubscribe</span></a>.</div></div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></center></body></html>";
        }

         protected function parseLiskResult($result) {
            $getall = 0;
            $output = [];
            $output["success"] = 1;
            $keycounter = -1; 
            $notlist = 0;
            foreach ((array)$result as $k => $v) {
                if (!is_array($v) && !is_object($v)) {
                    $dispersekey = explode("\\", $k);
                    $output["keys"][] = (string)$dispersekey[(count($dispersekey) - 1)];
                    $output["result"][] = $v;
                    $notlist = 1;
                }
                if ($notlist == 0) {
                    $keycounter += 1;
                    if ($keycounter == 0) { 
                        if (count((array)$v) > 1) { 
                            // an array of items
                            $justintimecounter = -1;
                            foreach((array)$v as $kk => $vv) {
                                $dispersekey = explode('"', $kk);
                                $dispersekey = explode("\\", $dispersekey[0]);
                                if (count((array)$vv) > 1) { 
                                    $justintimecounter += 1;
                                    foreach ((array)$vv as $kb => $vb) {
                                        $dispersekey = explode("\\", $kb);
                                        $output["keys"][] = (string)$dispersekey[(count($dispersekey) - 1)];
                                        $output["result"][$justintimecounter][] = $vb;
                                    }
                                } else {
                                    $output["keys"][] =(string)$dispersekey[(count($dispersekey) - 1)];
                                    $output["result"][$keycounter][] = $vv;
                                }
                                
                            }
                        } else {
                            // spit out all items just in case
                            $getall = 1;
                        }
                    }
                }
                
            }
            if ($getall == 1) {
                foreach ((array)$result as $k => $v) { 
                    $dispersekey = explode('"', $k); 
                    $output["keys"] = $dispersekey[0];
                    $output["result"][] = (array)$v;
                }
            }
            $newresultarray = [];
            // delete last 2 items in result array
            $totalkeys = count($output["result"]);
            $del1 = $totalkeys - 1;
            $del2 = $totalkeys - 2;
            unset($output["result"][$del1]);
            unset($output["result"][$del2]);
            $output["keys"] = array_unique($output["keys"]); 
             // foreach ($output["result"] as $kk => $arr) {
             //     foreach ($arr as $k => $v) {
             //         if (isset($output["keys"][$k])) {
             //             $newresultarray[$kk][(string)strtolower($output["keys"][$k])] = $v;
             //         } 
             //     }
             // }
             // $output["result"] = $newresultarray;
            return $output;
        }

        public function checkExchanges() {
            // inactivate exchanges with less than X btc volume
            $marketsID = []; 
            $sql2 = "
            SELECT
                mp.market_id,
                SUM(mp.volume24hour)AS 'mama'
            FROM
                markets_pairs mp
            GROUP BY
                mp.market_id
            HAVING
                mama < 500
            UNION
                SELECT
                    r.id AS 'market_id',
                    '' AS 'mama'
                FROM
                    markets r
                WHERE
                    NOT EXISTS(
                        SELECT
                            1
                        FROM
                            markets_pairs mpr
                        WHERE
                            mpr.market_id = r.id
                    )
            ";
            $query = DB::select($sql2);
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $res) {
                    $marketsID[$res["market_id"]] = $res["market_id"]; 
                } 
            }
            foreach ($marketsID as $k) {
                $sql1 = "UPDATE markets SET active = 0 WHERE id = ?";
                DB::update($sql1, [$k]);
                DB::table('markets_pairs')->where('market_id', $k)->delete();
            }
            DB::table('markets_pairs')->where('active', 0)->delete();
            /*

            // ------- 11/25/2021 --- commented this out, it just wasnt working and i dont know what the fuck i was thinking when i made it. just make it simple. delete the fucking shit. from market_pairs and disable the fucking markets

            // set exchanges to inactive based on last update of price for exchange by x amount of days 
            date_default_timezone_set( 'America/Los_Angeles' );
            $today = date("F d Y H:i:s", time()); 
            $expireDate = strtotime($today . " -1 day");
            $sql = "
                    SELECT
                        market_id,
                        MAX(lastupdate)AS 'lastupdate'
                    FROM
                        markets_pairs
                    WHERE
                        lastupdate > ?
                    GROUP BY
                        market_id
            ";  
            $goodExchanges = [];
            $query = DB::select($sql, [$expireDate]);
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $res) {
                    $goodExchanges[$res["market_id"]] = $res["market_id"]; 
                }
            }
            $goodIds = implode(",", $goodExchanges);
            $sql = "SELECT id FROM markets WHERE id NOT IN (?)";
            $q = DB::select($sql, [$goodIds]);
            if (count($q) > 0) {
                foreach (json_decode(json_encode($q), true) as $res) {
                    $marketsID[$res["id"]] = $res["id"];
                }
            }
            //echo $sql;
            if (count($marketsID) > 0) {
                $ids = implode(",", $marketsID);
                $sql2 = "UPDATE markets SET active = '0' WHERE id IN (?)";
                DB::update($sql2, [$ids]);
            }*/
            return TRUE;
        }

        public function checkMarketPairs() {
            // set inactive to market pairs that have inactive exchanges
            $markets = [];
            $sql = "SELECT id FROM markets WHERE active = '0'";
            $query = DB::select($sql);
            foreach(json_decode(json_encode($query), true) as $res) {
                $markets[] = $res["id"];
            }
            if (count($markets) > 0) {
                $ids = implode(",", $markets);
                $sql2 = "UPDATE markets_pairs SET active = '0' WHERE id IN (?)";
                DB::update($sql2, [$ids]);
            }
            // set inactive to markets pairs that have 0 price and 0 last update
            $sql = "UPDATE markets_pairs SET active = '0' WHERE price = '0' AND lastupdate = '0'";
            DB::update($sql);
            return TRUE;
        }

        private function toHuman($number) {
            return number_format(sprintf("%.8f", $number / 100000000), 2, '.', '');
        }

        public function unsubscribeEmail($email) {
            $sql = "UPDATE users SET subscribed = '0' WHERE email = ?";
            DB::update($sql, [$email]);
            return TRUE;
        }

        public function getHomeStats() {
            $sql = "SELECT total_matches, num_exchanges, num_markets_pairs, avg_profit FROM home_stats ORDER BY id DESC LIMIT 1";
            $query = DB::select($sql);
            return (array)$query[0];
        }

        public function getExchangesByRequest($postData=array()) {
            $output = 0;
            $exchanges = $postData["exchanges"];
            $exchanges = $exchanges;
            $x = [];
            foreach ($exchanges as $id) {
                $x[] = strip_tags((int)$id);
            }
            $sql = "SELECT id FROM markets_pairs WHERE market_id IN (?)";
            $query = DB::select($sql, [implode(",",$x)]);
            $x = null;
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $res) {
                    $userPairs[] = $res["id"];
                }
            } else {
                return $output;
            }
            $sql = "SELECT
                    COUNT(m.id) as 'total'
                FROM
                    matches m 
                LEFT JOIN markets_pairs mp1 ON mp1.id = m.pair1_id
                LEFT JOIN markets_pairs mp2 ON mp2.id = m.pair2_id
                WHERE
                    m.pair1_id IN(?)
                AND m.pair2_id IN(?)
                AND m.finished IS NULL
                GROUP BY
                    m.id
                ORDER BY
                    percent ASC"; 
            $query = DB::select($sql, [implode(", ",$userPairs), implode(", ",$userPairs)]); 
            if (count($query) > 0) {
                $output = count($query);
            }
            return $output;
        }

        public function updateHomePage() {
            $total_matches = $this->getTotalMatches();
            $num_exchanges = $this->getActiveExchangesCount();
            $num_markets_pairs = $this->getTotalMarketPairs();
            $avg_profit = $this->calculateAvgProfit30Day();
            $get_exchanges = $this->getExchanges();
            $sql = "INSERT INTO home_stats (total_matches, num_exchanges, num_markets_pairs, avg_profit, created, markets) VALUES (?, ?, ?, ?, UNIX_TIMESTAMP(), ?)"; 
            DB::insert($sql, [$total_matches, $num_exchanges, $num_markets_pairs, $avg_profit, json_encode($get_exchanges)]);
            return TRUE;
        }

        private function getTotalMatches() {
            $sql = "SELECT COALESCE(COUNT(id),0) as 'total_matches' FROM matches";
            $query = DB::select($sql);
            return $query[0]->total_matches;
        }

        private function getActiveExchangesCount() {
            $sql = "SELECT COALESCE(COUNT(id),0) as 'total_exchanges' FROM markets WHERE active = '1'";
            $query = DB::select($sql);
            return $query[0]->total_exchanges;
        }

        private function getTotalMarketPairs() {
            $sql = "SELECT COALESCE(COUNT(mp.id),0) as 'market_pairs' FROM markets m 
            LEFT JOIN markets_pairs mp ON m.id = mp.market_id 
            WHERE m.active = '1'";
            $query = DB::select($sql);
            return $query[0]->market_pairs;
        }

        public function getExchanges() {
            $markets = [];
            $sql = "SELECT * FROM markets WHERE active = '1' ORDER BY name ASC";
            $query = DB::select($sql);
            if (count($query) > 0) {
                foreach ($query as $res) {
                    $markets[$res->id] = $res->name;
                }
            } else {
                return [];
            }
            return $markets;
        }

        private function calculateAvgProfit30Day() {
            $btcvalue = $this->getBitcoinValue();
            $val = 0;
            if ($btcvalue == 0) { return "?"; }
            $sql = "SELECT AVG(percent) as 'percent' FROM matches";
            $query = DB::select($sql);
            if (count($query) > 0) {
                $percent = round($query[0]->percent, 2);
            } else {
                return "?";
            }
            for ($i=0; $i<=30; $i++) {
                $add = ($percent / 100) * $btcvalue;
                $val += $add;
            }
            return round($val, 2);
        }

        private function getBitcoinValue() {
            $sql = "SELECT cost FROM bitcoin_value ORDER BY id DESC LIMIT 1";
            $query2 = DB::select($sql);
            if (count($query2) > 0) {
                return $query2[0]->cost;
            } else {
                return 0;
            }
        }

        public function getChat($last=null) {
            $output = [];
            $output["error"] = 0;
            $output["chat"] = [];
            if ($last == null) {
                $sql = "SELECT * FROM trollbox ORDER BY id DESC LIMIT 50";
                $query = DB::select($sql);
            } else {
                $sql = "SELECT * FROM trollbox WHERE id > ? ORDER BY id DESC LIMIT 50";
                $query = DB::select($sql, [strip_tags((int)$last)]);
            } 
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $res) {
                    $output["chat"][] = $res;
                }
                rsort($output["chat"]);
            } else {
                $output["error"] = 1;
            }
            return $output;
        }

        public function sendChat($postData=array()) {
            $output["error"] = 0;
            $output["error_message"] = "";
            if (!isset($postData["uid"]) || empty($postData["uid"])) { $output["error"] = 1; $output["error_message"] = "User not authenticated."; }
            if (!isset($postData["message"]) || empty($postData["message"])) { $output["error"] = 1; $output["error_message"] = "Chat cannot be empty";}
            $userData = $this->getUserData();
            if ($userData["admin"] == 1) { 
                $user_type = 1; 
            } elseif ($userData["vip"] == 1) {
                $user_type = 2; 
            } elseif ($userData["paid"] == 1) {
                $user_type = 3;
            } else {
                $output["error"] = 1;
                $output["error_message"] = "Must have active subscription.";
                return $output;
            }
            $handle = $userData["username"];
            if ($userData["uid"] == $postData["uid"]) {
                $sql = "INSERT INTO trollbox (uid, message, created, handle, user_type) VALUES (?, ?, UNIX_TIMESTAMP(), ?, ?)";
                DB::insert($sql, [strip_tags((int)$postData["uid"]), strip_tags($postData["message"]), $handle, $user_type]);
            } else {
                 $output["error"] = 1; $output["error_message"] = "User not authenticated.";
            }
            return $output;
        }

        public function validateEmail($email) {
            $sql = "UPDATE users SET subscribed = '1' WHERE email = ?";
            DB::update($sql, [$email]);
            return TRUE;
        }

        public function getUserExchanges() {
            $userData = $this->getUserData();
            $output = [];
            $sql = "SELECT p.market_id, m.name, count(p.id) FROM markets_pairs p 
                    LEFT JOIN markets m ON p.market_id = m.id AND m.active = '1'
                    WHERE m.active = '1'
                    GROUP BY p.market_id;";
            $query = DB::select($sql);
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $v) {
                    $sql2 = "SELECT 1 FROM users_markets WHERE uid = ? AND market_id = ?";
                    $query2 = DB::select($sql2, [$userData["uid"], $v["market_id"]]);
                    if (count($query2) > 0) {
                        $output[] = array("market_id" => $v["market_id"], "name" => $v["name"], "selected" => TRUE);
                    } else {
                        $output[] = array("market_id" => $v["market_id"], "name" => $v["name"], "selected" => FALSE);
                    }
                }
            }
            return $output;
        }

        public function getMatchData() {
            $userData = $this->getUserData();
            $output = [];
            $userExchangesCall = $this->getUserExchanges();
            $userExchanges = [];
            $userPairs = [];
            foreach ($userExchangesCall as $e) {
                if ($e["selected"] == TRUE) {
                    $userExchanges[] = $e["market_id"];
                }
            } 
            $userExchangesCall = null;
            if (count($userExchanges) == 0) { return $output; }
            $sql = "SELECT id FROM markets_pairs WHERE market_id IN (".implode(",", $userExchanges).")";
            $query = DB::select($sql);
            $userExchanges = null;
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $res) {
                    $userPairs[] = $res["id"];
                }
            } else {
                return $output;
            }
            $sql = "SELECT
                    (
                        SELECT
                            c1.abbr
                        FROM
                            currency c1
                        WHERE
                            c1.id = mp1.currency_id
                    )AS 'currency1',
                    (
                        SELECT
                            c2.abbr
                        FROM
                            currency c2
                        WHERE
                            c2.id = mp2.currency_id
                    )AS 'currency2',
                    (
                        SELECT
                            m1. NAME
                        FROM
                            markets m1
                        WHERE
                            m1.id = mp1.market_id
                    )AS 'market1',
                    (
                        SELECT
                            m2. NAME
                        FROM
                            markets m2
                        WHERE
                            m2.id = mp2.market_id
                    )AS 'market2',
                    (
                        SELECT
                            s1.abbr
                        FROM
                            symbols s1
                        WHERE
                            s1.id = mp1.symbol_id
                    )AS 'symbol1',
                    (
                        SELECT
                            s2.abbr
                        FROM
                            symbols s2
                        WHERE
                            s2.id = mp2.symbol_id
                    )AS 'symbol2',
                    m.started,
                    mp1.price as 'pair1_price',
                    mp2.price as 'pair2_price',
                    COALESCE(ROUND(m.percent,2), 'X') as 'percent',
                    COALESCE(mp1.lastupdate, mp2.lastupdate) AS 'updated',
                    m.id as 'identifier'
                FROM
                    matches m 
                LEFT JOIN markets_pairs mp1 ON mp1.id = m.pair1_id
                LEFT JOIN markets_pairs mp2 ON mp2.id = m.pair2_id
                WHERE
                    m.pair1_id IN (".implode(", ",$userPairs).") 
                AND m.pair2_id IN (".implode(", ",$userPairs).") 
                AND m.finished IS NULL
                GROUP BY
                    m.id
                ORDER BY
                    percent ASC";
                    /*echo $sql;
                    exit();*/
            $query = DB::select($sql); 
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $res) {
                    $output[] = $res;
                }
            }
            return $output;
        }

        public function getPaymentStep() {
            $userData = $this->getUserData();
            /*
                return 2 - awaiting payment confirmation
                return 3 - needs assigned a new order
            */
            if ($this->getUserOrders(true) == FALSE) {
                return 2;
            } else {
                return 3;
            }
        }

        public function setupPayment($postData=array()) {
            if (!isset($postData["type"]) || empty($postData["type"])) {
                return FALSE;
            }
            $userData = $this->getUserData();
            $order = $this->getUserOrders();
            $programCost = $this->getProgramCost();
            if (!isset($programCost[$postData["type"]]) || empty($programCost[$postData["type"]])) { return FALSE; }
            if ($programCost[$postData["type"]] <= 0) {
                return FALSE;
            }
            $lskCost = $programCost[$postData["type"]];
            if ($postData["type"] == "beginner") {
                $usdCost = 30;
                $type = 1;
            } elseif ($postData["type"] == "trader") {
                $usdCost = 50;
                $type = 2;
            } elseif ($postData["type"] == "vip") {
                $usdCost = 2000;
                $type = 3;
            }
            if ($order["expired"] == true) {
                // create a new order
                // assign a cold storage account 
                $sql = "SELECT id, address FROM cold_storage WHERE uid IS NULL LIMIT 1";
                $query = DB::select($sql);
                if (count($query) > 0) {
                    $lskAddress = $query[0]->address;
                    $cold_storage_id = $query[0]->id;
                } else {
                    return FALSE;
                }
                $now = time();
                $sql = "INSERT INTO orders (uid, usd_cost, amount_requested, cold_storage_id, created, type) VALUES (?, ?, ?, ?, ?, ?)";
                DB::insert($sql, [$userData["uid"], $usdCost, $lskCost, $cold_storage_id, $now, $type]);
                $sql = "UPDATE cold_storage SET uid = ? WHERE id = ?";
                DB::update($sql, [$userData["uid"], $cold_storage_id]);
                return TRUE;
            } 

        }

        public function getUserOrders($check=false) {
            $output = [];
            $userData = $this->getUserData();
            $expiretime = strtotime("-12 hours");
            $sql = "SELECT o.*, cs.address FROM orders o 
            LEFT JOIN cold_storage cs ON o.cold_storage_id = cs.id
            WHERE o.uid = ? ORDER BY o.id DESC LIMIT 1";
            $query = DB::select($sql, [$userData["uid"]]);
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $v) {
                    $output = $v;
                    if ($v["created"] > $expiretime) {
                        if ($check == true) {
                            return TRUE;
                        }
                        $output["expired"] = false;
                    } else {
                        if ($check == true) {
                            return FALSE; // needs new order
                        }
                        $output["expired"] = true;
                    }
                }
            } else {
                if ($check == true) {
                    return FALSE; // needs new order
                }
                $output["expired"] = true;
            }
            return $output;
        }

        public function checkPayments() {
            $sql = "SELECT o.*, cs.address FROM orders o 
            LEFT JOIN cold_storage cs ON o.cold_storage_id = cs.id
            WHERE confirmed = 0";
            $query = DB::select($sql);
            if (count($query) > 0) {
                foreach (json_decode(json_encode($query), true) as $res) {
                    // check for payment
                    $checkBalance = $this->getBalance($res["address"]);
                    if (isset($checkBalance["result"][0])) {
                        $balance = $this->toHuman($checkBalance["result"][0]);
                        if ($balance >= $res["amount_requested"]) {
                            // update member to paid
                            if ($res["usd_cost"] == 50) {
                                $vip = 1;
                            } else {
                                $vip = 0;
                            }
                            $sql = "UPDATE orders SET amount_received = ?, tx_id = ?, confirmed = '1' WHERE id = ?";
                            //echo $sql;
                            DB::update($sql, [$balance, $res["address"], $res["id"]]);
                            $sql = "UPDATE users SET paid = '1', vip = ? WHERE id = ?";
                            DB::update($sql, [$vip, $res["uid"]]);
                        } 
                    }
                    
                }
            } else {
                return TRUE;
            }
        }

        public function getBalance($address) {
            try {
                $client = new \Lisk\Client(LISK_SERVER);
                $result = $client->getBalance($address);
                $result = $this->parseLiskResult($result);
                return $result;
            } catch (Throwable $t) {
                return (object)array("result" => null, "success" => 0, "error" => $t->getMessage());
            }
        }


        public function modifyPreferences($postData=array(), $action=null) {
            if (count($postData) == 0 || $action == null) { return FALSE; } 
            $userData = $this->getUserData();
            if ($action == "set_notifications") {

                if (!isset($postData["notifications"])) {
                    $sql = "UPDATE users SET notifications = '0' WHERE id = ".$this->db->escape($userData["uid"]);
                    DB::update($sql, [$userData["uid"]]);
                    return TRUE;
                } else {
                    $sql = "UPDATE users SET notifications = '1' WHERE id = ".$this->db->escape($userData["uid"]);
                    DB::update($sql, [$userData["uid"]]);
                    return TRUE;
                }

            }

            if ($action == "set_threshold") {

                if (isset($postData["threshold"]) || !empty($postData["threshold"])) {
                    $threshold = strip_tags($postData["threshold"]);
                    if (!is_numeric($threshold)) {
                        $threshold = 3;
                    } elseif ($threshold < 3) {
                        $threshold = 3;
                    } elseif ($threshold > 99){
                        $threshold = 99;
                    }
                }
                $sql = "UPDATE users SET threshold = ? WHERE id = ?";
                DB::update($sql, [$threshold, $userData["uid"]]);
                return TRUE;
            }

            if ($action == "set_exchanges") {
                $sql = "DELETE FROM users_markets WHERE uid = ?";
                DB::delete($sql, [$userData["uid"]]);
                if (!isset($postData["exchanges"])) { return TRUE; }
                /*$sql = "SELECT p.market_id, m.name, count(p.id) FROM markets_pairs p 
                    LEFT JOIN markets m ON p.market_id = m.id AND m.active = '1'
                    WHERE p.active = '1'
                    GROUP BY p.market_id;";
                $query = DB::select($sql);
                if (count($query) > 0) {
                    foreach (json_decode(json_encode($query), true) as $v) {*/
                        foreach ($postData["exchanges"] as $x) {
                            //if ($x == $v["market_id"]) {
                                $sql2 = "INSERT INTO users_markets (uid, market_id) VALUES (?, ?)";
                                DB::insert($sql2, [$userData["uid"], $x]);
                            //}
                        }
                    /*}
                }*/
                return TRUE;
            }
        }

        public function getProgramCost() {
            $sql = 'select p.price FROM markets_pairs p
                    LEFT JOIN currency c ON c.id = p.currency_id
                    LEFT JOIN markets m ON m.id = p.market_id 
                    LEFT JOIN symbols s ON s.id = p.symbol_id 
                    WHERE c.abbr = "LSK" AND m.name = "Poloniex" AND s.abbr = "BTC"
                    ORDER BY p.id DESC 
                    LIMIT 1'; 
            $query = DB::select($sql);
            if (count($query) > 0) { 
                $lsk_price = $query[0]->price;
            } else {
                (float)$lsk_price = 0.0021; // cant get accurate lsk price, fuck it - 1/14/2018 (in 2/2020 its $100.9)
            }
            $sql = "SELECT cost FROM bitcoin_value WHERE fiat = 'USD' ORDER BY id DESC LIMIT 1";
            $query = DB::select($sql);
            if (count($query) > 0) {
                $bitcoin_value = $query[0]->cost;
            } else {
                $bitcoin_value = 10000; // cant get accurate bitcoin price, fuck it 
            }
            if ($lsk_price == 0) { (float)$lsk_price = 0.0021; }
            return array("beginner" => (round(((30 / $bitcoin_value) / $lsk_price),2)+0.1), "trader" => (round(((50 / $bitcoin_value) / $lsk_price),2)+0.1), "vip" => (round(((1000 / $bitcoin_value) / $lsk_price),2)+0.1));
        }


        public function getPaidStatus() {
            // firstly check if they are VIP status
            $sql = "SELECT `vip`, `id`, `admin`, `paid` FROM users WHERE email = ? AND verification_key = ?";
            $query = DB::select($sql, [session("email"), session("verification_key")]);
            if (count($query) > 0) {
                $vip = $query[0]->vip;
                $uid = $query[0]->id;
                $admin = $query[0]->admin;
                $paid = $query[0]->paid;
            } else {
                return FALSE;
            }
            if ($paid == 1) { return TRUE; }
            if ($admin == 1) { return TRUE; }
            if ($vip == 1) { return TRUE; }
            // not a VIP, must check if they have placed an order with us
            $sql = "SELECT 1 FROM orders WHERE uid = ? AND confirmed = '1' AND amount_requested = amount_received";
            $query = DB::select($sql, [$uid]);
            if (count($query) > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public function getUserData() {
            $output = [];
            $sql = "SELECT id, email, username, created, vip, COALESCE(lsk_address, '') as 'lsk_address', subscribed, notifications, threshold, paid, admin FROM users WHERE email = ? AND verification_key = ?";
            $query = DB::select($sql, [session("email"), session("verification_key")]);
            if (count($query) > 0) {
                $output["email"] = $query[0]->email;
                $output["created"] = $query[0]->created;
                $output["vip"] = $query[0]->vip;
                $output["paid"] = $query[0]->paid;
                $output["admin"] = $query[0]->admin;
                $output["username"] = $query[0]->username;
                $output["lsk_address"] = $query[0]->lsk_address;
                $output["uid"] = $query[0]->id;
                $output["notifications"] = $query[0]->notifications;
                $output["subscribed"] = $query[0]->subscribed;
                $output["threshold"] = $query[0]->threshold;
                $dayago = strtotime("-1 day");
                $sql = "SELECT ip FROM users_ip_login WHERE uid = ? AND created > ? GROUP BY ip"; 
                $query2 = DB::select($sql, [$query[0]->id, $dayago]);
                if (count($query2) > 0) {
                    foreach (json_decode(json_encode($query2), true) as $v) {
                        $output["ips"][] = $v["ip"];
                    }
                }
            }
            
            return $output;
        }

        public function modifyAccount($postData=array(), $action=null) {
            if (count($postData) == 0 || $action == null) { return FALSE; }
            $output = [];
            $output["error"] = "";
            $output["error_style"] = "display: none;";
            $output["success"] = "";
            $output["success_style"] = "display:none;";
            $userData = $this->getUserData();
            if ($action == "changeemail" || $action == "validateemail") {
               // check if a request has been sent to that email within the last day
                $body = $this->buildValidateEmail($postData["email"]);
                $from = new SendGrid\Email("Insider Crypto", "support@insidercrypto.com");
                $subject = "Validate Your Email Address";
                $to = new SendGrid\Email($userData["username"], $postData["email"]);
                $content = new SendGrid\Content("text/html", $body);
                $mail = new SendGrid\Mail($from, $subject, $to, $content);
                $apiKey = getenv(SENDGRID_API_KEY);
                $sg = new \SendGrid($apiKey);
                $response = $sg->client->mail()->send()->post($mail);
                echo "<pre>";
                var_dump($response);
                echo "</pre>";
                $output["success"] = "Success! We have sent an email to ".$postData["email"]." to validate your email.";
                $output["success_style"] = "";
             } elseif ($action == "changepw") {
                if (empty($postData["password"]) || !isset($postData["password"]) || empty($postData["password2"]) || !isset($postData["password2"])) { 
                    $output["error"] = "You cannot have a blank password.";
                    $output["error_style"] = "";
                }
                if ($postData["password"] == $postData["password2"]) {
                    $salt = $this->generateSalt();
                    $password = md5($salt.$postData["password"]);
                    $sql = "UPDATE users SET password = ? WHERE id = ?";
                    DB::update($sql, [$password, $userData["uid"]]);
                    $output["success"] = "You have successfully changed your password.";
                    $output["success_style"] = "";
                } else {
                    $output["error"] = "The passwords do not match.";
                    $output["error_style"] = "";
                }
            } elseif ($action == "changelskaddress") {
                $sql = "UPDATE users SET lsk_address = ".$this->db->escape($postData["address"])." WHERE id = ".$this->db->escape($userData["uid"]);
                $this->db->query($sql);
                $output["success"] = "Updated your Lisk Address to ".$postData["address"];
                $output["success_style"] = "";
            }
            return $output;
        }


        public function register($postData=null) {
            /*
        error list: 
        2 = no username
        3 = no password
        4 = no password confirm
        6 = no email
        8 = passwords dont match
        9 =  username or email exists already
        */
            $error = 0;
            if (!isset($postData["username"]) || empty($postData["username"])) { return 2;} else { $username = strip_tags(preg_replace("/[^a-zA-Z0-9]+/", "", $postData["username"]));} 
            if (!isset($postData["password"]) || empty($postData["password"])) { return 3;} else { $password = strip_tags($postData["password"]);}
            if (!isset($postData["password2"]) || empty($postData["password2"])) { return 4;} else { $password2 = strip_tags($postData["password2"]);}
            if (!isset($postData["email"]) || empty($postData["email"])) { return 6;} else { $email = strip_tags(filter_var($postData["email"], FILTER_SANITIZE_EMAIL));}
            if ($error > 0) { return $error; }
            $verification_key = $this->generateVerificationKey();
            $salt = $this->generateSalt();
            if ($password !== $password2) { return 8; } else { $password = md5($salt.$password); }
            $now = time();
            $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
            $query = DB::select($sql, [$username, $email]);
            if (count($query) > 0) {
                    return 9;
            } else {
                $sql2 = "INSERT INTO users (username,password,created,verification_key,email) VALUES (?, ?, ?, ?, ?)";
                DB::insert($sql2, [$username, $password, $now, $verification_key, $email]);
                $this->login(array("email" => $email, "password" => $postData["password"]));
                return 1;   
            }
        }


        public function getUserIP() {
		    $ipaddress = '';
		    if (isset($_SERVER['HTTP_CLIENT_IP']))
		        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    else if(isset($_SERVER['HTTP_X_FORWARDED']))
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
		        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		    else if(isset($_SERVER['HTTP_FORWARDED']))
		        $ipaddress = $_SERVER['HTTP_FORWARDED'];
		    else if(isset($_SERVER['REMOTE_ADDR']))
		        $ipaddress = $_SERVER['REMOTE_ADDR'];
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;
	   }

        public function login($postData) {
        	if (!isset($postData["email"])) { return FALSE; }
        	if (!isset($postData["password"])) { return FALSE; }
            $salt = $this->generateSalt();
        	$email = strip_tags($postData["email"]);
        	$password = strip_tags(md5($salt.$postData["password"]));
        	$sql = "SELECT a.* FROM users a 
            WHERE a.email = ? AND a.password = ?";
        	$query = DB::select($sql, [$email, $password]);
        	if (count($query) > 0) {
        		$q = $query[0];
        		session(["email" => $q->email]);
        		session(["verification_key" => $q->verification_key]);
        		session(["admin_id" => $q->id]);
        		session(["loggedin" => 1]);
        		$ip = $this->getUserIP();
        		$sql2 = "UPDATE users SET last_login = ?, ip = ? WHERE id = ?";
        		DB::update($sql2, [time(), $ip, $q->id]);
                $sql3 = "INSERT INTO users_ip_login (uid, ip, created) VALUES (?, ?, ?)";
                DB::insert($sql3, [$q->id, $ip, time()]);
        		return TRUE;
        	} else {
        		return FALSE;
        	}
        }

        public function verifyUser() {
        	if (session("email") && session("verification_key") && session("loggedin")) { 
        		$query =  DB::select("SELECT * FROM users WHERE verification_key = :verification_key AND email = :email", ["verification_key" => session("verification_key"), "email" => session("email")]);
        		if (count($query) > 0) {
        			return TRUE;
        		} else {
        			return FALSE;
        		}
        	} else {
        		return FALSE;
        	}
        }

        public function logout() {
        	session()->forget("email");
        	session()->forget("verification_key");
        	session()->forget("loggedin");
        	return TRUE;
        }

}