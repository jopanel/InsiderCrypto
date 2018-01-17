<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		if ($this->General_model->verifyUser() == FALSE) {
			$data["programcost"] = $this->General_model->getProgramCost();
			$this->load->view('landing/header');
			$this->load->view('landing/welcome', $data);
			$this->load->view('landing/footer');
		}
		
	}
}
