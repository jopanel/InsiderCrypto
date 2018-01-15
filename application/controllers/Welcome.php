<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		$this->load->view('landing/header');
		$this->load->view('landing/welcome');
		$this->load->view('landing/footer');
	}
}
