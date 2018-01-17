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
		 /*
        error list: 
        2 = no username
        3 = no password
        4 = no password confirm
        6 = no email
        8 = passwords dont match
        9 =  username or email exists already
        */
        $data["style"] = "display:none;";
        $data["error"] = "";
        $data["displayValues"] = array(
        	"username" => "",
        	"email" => ""
        );
        if ($this->input->post()) {
        	$postData = $this->input->post();
        	$callback = $this->General_model->register($postData);
        	if ($callback == 1) {
        		$this->load->view('main/register_success');
        	} else {
        		if ($callback == 2) {
	        		$data["style"] = "";
	        		$data["error"] = "No username provided.";
	        		$data["displayValues"] = $postData;
	        	}
	        	if ($callback == 3) {
	        		$data["style"] = "";
	        		$data["error"] = "No password provided.";
	        		$data["displayValues"] = $postData;
	        	}
	        	if ($callback == 4) {
	        		$data["style"] = "";
	        		$data["error"] = "No confirmation password provided.";
	        		$data["displayValues"] = $postData;
	        	}
	        	if ($callback == 6) {
	        		$data["style"] = "";
	        		$data["error"] = "No email provided.";
	        		$data["displayValues"] = $postData;
	        	}
	        	if ($callback == 8) {
	        		$data["style"] = "";
	        		$data["error"] = "Passwords do not match.";
	        		$data["displayValues"] = $postData;
	        	}
	        	if ($callback == 9) {
	        		$data["style"] = "";
	        		$data["error"] = "Username or email exists already.";
	        		$data["displayValues"] = $postData;
	        	}
	        	$this->load->view('main/register', $data);
        	} 
        } else {
        	$this->load->view('main/register', $data);
        }
		
	}
}
