<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {


	public function index()
	{
				if ($this->input->post()) {

				}
				$data["paymentstep"] = $this->General_model->getPaymentStep();
				$data["paidstatus"] = $this->General_model->getPaidStatus();
				$head["navbartoggle"] = "";
				$this->load->view('main/header', $head);
				$this->load->view('main/payments',$data);
				$this->load->view('main/footer');
	}


}
