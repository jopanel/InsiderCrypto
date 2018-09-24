<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://github.com/loeken/cryptocompare-api-php-wrapper

class Api extends CI_Controller {

	public function genArb($password=null) { 
		if ($password == "checksum00") {
			$this->load->model('Compare_model');
			$this->Compare_model->generateArbitrageEvents(); 
		}
	}

	public function index()
	{
		echo json_encode(array("success" => 0, "error" => "You haven't tipped overlord supreme 1.337 Lisk (4287319913737945577L)"));
	}
/*
	CRON Job Calls
*/

	public function getAllPriceData($password=""){
		if ($password == API_PASSWORD) {
			$this->load->model('Cryptocompare_api'); 
			$this->Cryptocompare_api->build(); 
		}
	}

	public function checkForPayments() {
		$this->General_model->checkPayments();
	}

	public function updateMatches($password=null) {
		if ($password == API_PASSWORD) {
			ini_set('max_execution_time', 0);
	        set_time_limit(0);
			$this->load->model('Cryptocompare_api'); 
			$this->load->model('Compare_model');
			$followUps = $this->Compare_model->generateFollowUp();
			if ($this->Cryptocompare_api->generatePrices($followUps) == TRUE) {
				$this->Compare_model->generateArbitrageEvents();
				$this->Compare_model->generatePairEvents();
				$this->General_model->checkExchanges();
			}
		}
	} 

	public function maintenance($password=null) {
		$output = [];
		$output["error"] = true;
		if ($password == API_PASSWORD) {
			$this->load->model('General_model');
			$fixexchanges = $this->General_model->checkExchanges();
			$updatehome = $this->General_model->updateHomePage();
			$output["error"] = false;
		}
		echo json_encode($output);
	}
	
/*
	CRON Job Related Functions
*/

	

	

	public function asyncPriceRequest($password=null) {
		if ($password == API_PASSWORD) { 
			if ($this->input->post()) { 
				$this->load->model('Cryptocompare_api');
				$this->Cryptocompare_api->priceDataParse(json_encode($this->input->post()));
			}
		} 
	}

/*
	Internal Functions Below
*/

	public function unsubscribe($email=null) {
		if ($email == null) {
			echo "Sorry there was a problem.";
		} else {
			if ($this->General_model->unsubscribeEmail($email) == TRUE) {
				echo "Successfully unsubscribed.";
			} else {
				echo "Sorry there was a problem.";
			}
		}
	}

	public function validate($email=null) {
		if ($email == null) {
			echo "Sorry there was a problem.";
		} else {
			if ($this->General_model->validateEmail($email) == TRUE) {
				echo "Successfully unsubscribed.";
			} else {
				echo "Sorry there was a problem.";
			}
		}
	}

	public function sendChat() { 
		$output = [];
		$output["error"] = 0;
		$output["error_message"] = "";
		if ($this->General_model->verifyUser() == FALSE) {
			$output["error"] = 1;
			$output["error_message"] = "User not authenticated.";
		} else {
			if (!$this->input->post()) { 
				$output["error"] = 1;
				$output["error_message"] = "Input cannot be empty.";
			} else {
				$postData = $this->input->post();
				$output = $this->General_model->sendChat($postData);
			}
		}
		echo json_encode($output);		
	}

	public function getChat($last=null) {
		$output = [];
		if ($last == null) {
			$return = $this->General_model->getChat();
		} else {
			$return = $this->General_model->getChat($last);
		}
		echo json_encode($return);
	}

	public function getExchangesByRequest() {
		if ($this->input->post()) {
			echo json_encode($this->General_model->getExchangesByRequest($this->input->post()));
		}
		
	}

	public function profits() {

		$people = [];
		(float)$originalcost = 5.0; 
		(float)$profit = 0;
		(float)$fundsgiven = 0;
		(float)$increase = 0.003;
		(float)$profitup = 0.0029;
		(float)$equity = 0.0001;
		$counter = 0;
		for ($i=1; $i<=2; $i++) {
			$counter += 1;
			(float)$initcost = $originalcost;
			$output = [];
			$personcount = 0;
			$people[] = array(
						"person" => $counter,
						"cost" => (float)$initcost,
						"profit" => 0
						);
			(float)$fundsgivenround = 0;
			$personcount = 0;
			(float)$profit += ($initcost * $profitup);
			$addit = 0;
				foreach ($people as $k => $peep) { 
						$personcount += 1;
						if ($k == (count($people) - 1)) {
						} else {
							$addit = 1;
							(float)$gains = ($initcost * $equity);
							(float)$gains = $gains + $peep["profit"];
							$output[] = array( 
							"person" => $peep["person"],
							"cost" => (float)$peep["cost"],
							"profit" => (float)$gains
							);
						(float)$fundsgivenround += ($initcost * $equity);
						}
				} 
				if ($addit == 1) {
					$output[] = array(
						"person" => $counter,
						"cost" => (float)$initcost,
						"profit" => 0
						);
				}
			(float)$originalcostmoneymade = ($initcost - $fundsgivenround);
			(float)$profit += $originalcostmoneymade;
			if (count($people) > 1) { 
				$people = $output; 
			}
			(float)$originalcost = ($initcost + ($initcost * $increase));
		}
		(float)$totalfundsgenerated = 0;
		foreach ($people as $peep) {
				(float)$fundsgiven += $peep["profit"];
			(float)$totalfundsgenerated += $peep["cost"];
		}
		$profit = ($totalfundsgenerated - $fundsgiven);
		echo "funds given: ".$fundsgiven." <br><br> Money Made: ".$profit."<br><br>cost of package now: ".$originalcost."<br><br> total funds generated: ".$totalfundsgenerated;
		$costofmonthly = 30;
		$totalpeople = count($people);
		$numberpurchases = 50;
		$moprofit = 0;
		for ($i=1; $i<=12; $i++) {
			for ($r=1; $r<=$numberpurchases; $r++) {
				$moprofit += ($costofmonthly / 2);
				$gains = (($costofmonthly / 2) / count($people));
				$output = [];
				foreach ($people as $peep) {
					$output[] = array( 
								"person" => $peep["person"],
								"cost" => (float)$peep["cost"],
								"profit" => (float)($peep["profit"] + $gains)
								);
				}
				$people = $output;
			}
		}
		echo "<br><br>total profit of $".$moprofit." after 12 months, with ".$numberpurchases." purchases at $".$costofmonthly." /mo";
		echo "<pre>";
		var_dump($people);
		}





}
