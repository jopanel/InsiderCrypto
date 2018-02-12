<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {


	public function index()
	{
			if ($this->General_model->verifyUser() == FALSE) {
				$data["programcost"] = $this->General_model->getProgramCost();
				$this->load->view('landing/header');
				$this->load->view('landing/welcome', $data);
				$this->load->view('landing/footer');
			} else {
				if ($this->input->post()) {

				}
				$data["paymentstep"] = $this->General_model->getPaymentStep();
				$data["paidstatus"] = $this->General_model->getPaidStatus();
				$data["order"] = $this->General_model->getUserOrders();
				$data["programcost"] = $this->General_model->getProgramCost();
				$head["navbartoggle"] = "";
				$this->load->view('main/header', $head);
				$this->load->view('main/payments',$data);
				$this->load->view('main/footer');
			}
	}


}
