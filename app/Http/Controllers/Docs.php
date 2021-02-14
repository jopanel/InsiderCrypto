<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Api;


class Docs extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

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