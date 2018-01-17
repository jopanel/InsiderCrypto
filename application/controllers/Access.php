<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {


	public function login()
	{ 

		$data["error"] = 0;
		if ($this->input->post()){ 
			if ($this->session->userdata("loginattempts")) { 
				$postData = $this->input->post();
				$loginattempts = $this->session->userdata("loginattempts");
				if ($loginattempts > 4) { 
					$data["style"] = "";
					$data["error"] = 1;
					$this->load->view('main/login', $data);
				 } else {
				 	$auth = $this->General_model->login($postData);
					if ($auth == true) {
						redirect(base_url(), "auto");
					} else {
						$data["style"] = "";
						$data["error"] = 2;
						$this->load->view('main/login', $data);
					}
				 } 
			} else { 
				$this->session->set_userdata("loginattempts", 0);
				$postData = $this->input->post();
				$auth = $this->General_model->login($postData);
				if ($auth == true) {
					redirect(base_url(), "auto");
				} else {
					$data["style"] = "";
					$data["error"] = 2;
					$this->load->view('main/login', $data);
				}
			} 
		} else {
			$data["style"] = "display:none;";
			$this->load->view('main/login', $data);
		}
		 
	}

	public function forgot() {
		$this->load->view('main/forgot');
	}

	public function register() {
		$this->load->view('main/register');
	}
}
