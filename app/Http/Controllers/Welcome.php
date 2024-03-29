<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Api;


class Welcome extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

	public function index()
	{
		$data["programcost"] = $this->General_model->getProgramCost();
		if ($this->General_model->verifyUser() == FALSE) {
			$data["stats"] = $this->General_model->getHomeStats(); 
			$data["markets"] = $this->General_model->getExchanges();
			$this->load->view('landing/header');
			$this->load->view('landing/welcome', $data);
			$this->load->view('landing/footer');
		} else {
			$head["navbartoggle"] = "sidenav-toggled";
			$data["paidstatus"] = $this->General_model->getPaidStatus();
			$data["userData"] = $this->General_model->getUserData();
			$data["chatlog"] = $this->General_model->getChat();
			$data["matchData"] = $this->General_model->getMatchData(); 
			$this->load->view('main/header', $head);
			$this->load->view('main/dashboard', $data);
			$this->load->view('main/footer');
		}
	}
}