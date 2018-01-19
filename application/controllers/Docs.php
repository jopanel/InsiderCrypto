<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Docs extends CI_Controller {

	public function privacy() {
		$head["navbartoggle"] = "";
		$this->load->view('main/header', $head);
		$this->load->view('main/docsheader');
		$this->load->view('main/privacy');
		$this->load->view('main/footer');
	}

	public function terms() {
		$head["navbartoggle"] = "";
		$this->load->view('main/header', $head);
		$this->load->view('main/docsheader');
		$this->load->view('main/terms');
		$this->load->view('main/footer');

	}

	public function faq() {
		$head["navbartoggle"] = "";
		$this->load->view('main/header', $head);
		$this->load->view('main/docsheader');
		$this->load->view('main/faq');
		$this->load->view('main/footer');

	}

}