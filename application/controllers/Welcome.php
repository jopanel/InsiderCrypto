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
		} else {
			if ($this->General_model->getPaidStatus() == TRUE) {
				// paid and verified member
				$head["navbartoggle"] = "sidenav-toggled";
				$this->load->view('main/header', $head);
				$this->load->view('main/dashboard');
				$this->load->view('main/footer');

			} else {
				// unpaid membership
				$head["navbartoggle"] = "";
				$this->load->view('main/header', $head);
				$this->load->view('main/unpaid-dashboard');
				$this->load->view('main/footer');
			}
		}
		
	}
}
