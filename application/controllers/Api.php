<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://github.com/loeken/cryptocompare-api-php-wrapper

class Api extends CI_Controller {

	public function index()
	{
		echo json_encode(array("success" => 0, "error" => "You haven't successfuly tipped overlord supreme 1.337 Lisk (4287319913737945577L)"));
	}

	public function update($type=null, $password="") {
		$this->load->model('Cryptocompare_api'); 
		$this->Cryptocompare_api->build();  
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

}
