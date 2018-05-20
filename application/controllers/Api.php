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
	CRON Job Related Functions
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
			}
		}
	} 

	public function asyncPriceRequest($password=null) {
		if ($password == API_PASSWORD) {
			if ($this->input->post()) {
				$this->load->model('Cryptocompare_api');
				$this->Cryptocompare_api->priceDataParse($this->input->post());
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


}
