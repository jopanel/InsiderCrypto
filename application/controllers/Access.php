<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {


	public function login()
	{ 
		//$this->load->view('main/header');
		$this->load->view('main/login');
		//$this->load->view('main/footer');
	}

	public function forgot() {
		$this->load->view('main/forgot');
	}

	public function register() {
		$this->load->view('main/register');
	}
}
