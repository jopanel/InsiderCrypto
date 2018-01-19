<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://github.com/loeken/cryptocompare-api-php-wrapper

class Logout extends CI_Controller {

	public function index()
	{
		$this->General_model->logout();
		redirect(base_url(), "auto");
	}

}
