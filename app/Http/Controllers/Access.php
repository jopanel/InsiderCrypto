<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Api;
use App\Models\General;


class Access extends Controller
{
    protected $request;
    protected $General_model;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->General_model = new General();
    }

	public function login(Request $request)
	{ 

		$data["error"] = 0;
		if ($request->post()){ 
			if (session("loginattempts")) {  
				$postData = $request->post();
				$loginattempts = session("loginattempts");
				if ($loginattempts > 4) { 
					$data["style"] = "";
					$data["error"] = 1;
					return view('landing.login', $data);
				 } else {
				 	$auth = $this->General_model->login($postData);
					if ($auth == true) {
						return redirect(url('/'));
					} else {
						$data["style"] = "";
						$data["error"] = 2;
						return view('landing.login', $data);
					}
				 } 
			} else { 
				session(["loginattempts" => 0]);
				$postData = $request->post();
				$auth = $this->General_model->login($postData);
				echo $auth;
				if ($auth == true) {
					return redirect(url('/'));
				} else {
					$data["style"] = "";
					$data["error"] = 2;
					return view('landing.login', $data);
				}
			} 
		} else {
			$data["style"] = "display:none;";
			return view('landing.login', $data);
		}
		 
	}

	public function forgot() {
		return view('landing.forgot');
	}

	public function register(Request $request) {
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
        if ($request->post()) {
        	$postData = $request->post();
        	$callback = $this->General_model->register($postData);
        	if ($callback == 1) {
        		redirect(url('/')); // register success
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
	        	return view('landing.register', $data);
        	} 
        } else {
        	return view('landing.register', $data);
        }
		
	}
}