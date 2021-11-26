<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Api;
use App\Models\General;


class Control extends Controller
{
    protected $request;
    protected $General_model;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->General_model = new General();
    }

	public function index()
	{  


		$data["programcost"] = $this->General_model->getProgramCost();
		if ($this->General_model->verifyUser() == FALSE) {
			$data["stats"] = $this->General_model->getHomeStats(); 
			$data["markets"] = $this->General_model->getExchanges();
			return view('landing.header') . view('landing.welcome', $data) . view('landing.footer');
		} else {
			$head["navbartoggle"] = "sidenav-toggled";
			$data["paidstatus"] = $this->General_model->getPaidStatus();
			$data["userData"] = $this->General_model->getUserData();
			$data["chatlog"] = $this->General_model->getChat();
			$data["matchData"] = $this->General_model->getMatchData(); 
			return view('main.header', $head) . view('main.dashboard', $data) . view('main.footer');
		}

	}

	public function account(Request $request) {
		if ($this->General_model->verifyUser() == FALSE) {
			redirect(url('/'));
		} else {
				$data["error"] = "";
				$data["error_style"] = "display: none;";
				$data["success"] = "";
				$data["success_style"] = "display:none;";
				if ($request->post()) {
					$postData = $request->post();
					$result = $this->General_model->modifyAccount($postData, $postData["action"]);
					$data["error"] = $result["error"];
					$data["error_style"] = $result["error_style"];
					$data["success_style"] = $result["success_style"];
					$data["success"] = $result["success"];
				}
				$head["navbartoggle"] = "";
				if ($this->General_model->getPaidStatus() == TRUE) {
					$data["paidstatus"] = TRUE;
				} else {
					$data["paidstatus"] = FALSE;
				}
				$data["userdata"] = $this->General_model->getUserData();
				return view('main.header', $head) . view('main.account_settings', $data) . view('main.footer');
		}
	}

	public function preferences(Request $request) {
		if ($this->General_model->verifyUser() == FALSE) {
			redirect(url('/'));
		} else {
				$data["success"] = "";
				$data["success_style"] = "display: none;";
				if ($request->post()) {
					$postData = $request->post();
					if ($this->General_model->modifyPreferences($postData, $postData["action"]) == TRUE) {
						$data["success"] = "Success! Your preferences have been updated.";
						$data["success_style"] = "";
					}
				}
				$data["paidstatus"] = $this->General_model->getPaidStatus();
				$data["exchanges"] = $this->General_model->getUserExchanges();
				$data["userdata"] = $this->General_model->getUserData();
				$head["navbartoggle"] = "";
				return view('main.header', $head) . view('main.account_preferences', $data) . view('main.footer');
		}
	}
}