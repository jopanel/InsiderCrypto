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
    protected $General;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->General = new General();
    }

	public function index()
	{  
		if ($this->General->verifyUser() == FALSE) {
			$data["data"]["programcost"] = $this->General->getProgramCost();
			$data["stats"] = $this->General->getHomeStats(); 
			$data["markets"] = $this->General->getExchanges();
			$data["page"] = "landing.welcome";
		    return view('landing.header', $data) . view('landing.welcome', $data) . view('landing.footer', $data);  
		} else {
			if ($this->General->getPaidStatus() == TRUE) {
				// paid and verified member
				$head["navbartoggle"] = "sidenav-toggled";
				view('main/header', $head);
				return view('main/history');
				return view('main/footer');

			} else {
				// unpaid membership
				$head["navbartoggle"] = "";
				return view('main/header', $head);
				return view('main/unpaid-dashboard');
				return view('main/footer');
			}
		}
	}

	public function account() {
		if ($this->General_model->verifyUser() == FALSE) {
			redirect(base_url(), "auto");
		} else {
				$data["error"] = "";
				$data["error_style"] = "display: none;";
				$data["success"] = "";
				$data["success_style"] = "display:none;";
				if ($this->input->post()) {
					$postData = $this->input->post();
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
				$this->load->view('main/header', $head);
				$this->load->view('main/account_settings', $data);
				$this->load->view('main/footer');
		}
	}

	public function preferences() {
		if ($this->General_model->verifyUser() == FALSE) {
			redirect(base_url(), "auto");
		} else {
				$data["success"] = "";
				$data["success_style"] = "display: none;";
				if ($this->input->post()) {
					$postData = $this->input->post();
					if ($this->General_model->modifyPreferences($postData, $postData["action"]) == TRUE) {
						$data["success"] = "Success! Your preferences have been updated.";
						$data["success_style"] = "";
					}
				}
				$data["paidstatus"] = $this->General_model->getPaidStatus();
				$data["exchanges"] = $this->General_model->getUserExchanges();
				$data["userdata"] = $this->General_model->getUserData();
				$head["navbartoggle"] = "";
				$this->load->view('main/header', $head);
				$this->load->view('main/account_preferences', $data);
				$this->load->view('main/footer');
		}
	}
}