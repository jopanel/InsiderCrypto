<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://github.com/loeken/cryptocompare-api-php-wrapper

class Api extends CI_Controller {

	private function genArb() { 
			$this->load->model('Compare_model');
			$this->Compare_model->generateArbitrageEvents(); 
	}

	public function index()
	{
		echo json_encode(array("success" => 0, "error" => "You haven't successfuly tipped overlord supreme 1.337 Lisk (4287319913737945577L)"));
	}

	public function update($type=null, $password="") {
		$this->load->model('Cryptocompare_api'); 
		$this->Cryptocompare_api->build();
		$this->genArb();
	}

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
