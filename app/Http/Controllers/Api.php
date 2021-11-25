<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Api_model;
use App\Models\Cryptocompareapi;
use App\Models\Compare;
use App\Models\General;

class Api extends Controller
{
    protected $request;
    protected $Compare_model;
    protected $Cryptocompareapi_model;
    protected $General_model;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->Cryptocompareapi_model = new Cryptocompareapi();
        $this->Compare_model = new Compare();
        $this->General_model = new General();
    }

    public function index()
    {
        echo json_encode(array("success" => 0, "error" => "You haven't tipped overlord supreme 1.337 Lisk (4287319913737945577L)"));
    }
/*
    CRON Job Calls
*/

    public function getAllPriceData(){  
        $this->Cryptocompareapi_model->build();  
    }

    public function checkForPayments() {
        $this->General_model->checkPayments();
    }

    public function updateMatches() {
        ini_set('max_execution_time', 0);
        set_time_limit(0); 
        $this->Cryptocompareapi_model->build();
        $followUps = $this->Compare_model->generateFollowUp();
        if ($this->Cryptocompareapi_model->generatePrices($followUps) == TRUE) {
            $this->Compare_model->generateArbitrageEvents();
            $this->Compare_model->generatePairEvents();
        }
    } 
    public function testmatchdata() {
        $this->Compare_model->generateArbitrageEvents();
        //$this->Compare_model->generatePairEvents();
    }

    public function maintenance() {
        $output = [];
        $output["error"] = true;
        $this->General_model->checkExchanges(); 
        $this->General_model->updateHomePage();
        $this->General_model->checkMarketPairs();
        $output["error"] = false;
        echo json_encode($output);
    }

    public function fix() {
        $this->load->model('Cryptocompare_api'); 
        $this->load->model('Compare_model');
        $this->Compare_model->generatePairEvents();
    }
    
/*
    CRON Job Related Functions
*/

    public function asyncPriceRequest(Request $request) { 
        if ($request->post()) {  
            $this->Cryptocompareapi_model->priceDataParse(json_encode($request->post()));
        } 
    }

/*
    Internal Functions Below
*/

    public function unsubscribe($email=null) {
        if ($email == null) {
            echo "Sorry there was a problem.";
        } else {
            if ($this->General_model->unsubscribeEmail($email) == TRUE) {
                echo "Successfully unsubscribed.";
            } else {
                echo "Sorry there was a problem.";
            }
        }
    }

    public function validater($email=null) {
        if ($email == null) {
            echo "Sorry there was a problem.";
        } else {
            if ($this->General_model->validateEmail($email) == TRUE) {
                echo "Successfully unsubscribed.";
            } else {
                echo "Sorry there was a problem.";
            }
        }
    }

    public function sendChat() { 
        $output = [];
        $output["error"] = 0;
        $output["error_message"] = "";
        if ($this->General_model->verifyUser() == FALSE) {
            $output["error"] = 1;
            $output["error_message"] = "User not authenticated.";
        } else {
            if (!$this->input->post()) { 
                $output["error"] = 1;
                $output["error_message"] = "Input cannot be empty.";
            } else {
                $postData = $this->input->post();
                $output = $this->General_model->sendChat($postData);
            }
        }
        echo json_encode($output);      
    }

    public function getChat($last=null) {
        $output = [];
        if ($last == null) {
            $return = $this->General_model->getChat();
        } else {
            $return = $this->General_model->getChat($last);
        }
        echo json_encode($return);
    }

    public function getExchangesByRequest() {
        if ($this->input->post()) {
            echo json_encode($this->General_model->getExchangesByRequest($this->input->post()));
        }
        
    }

    public function testStripe($password=null) {
        if ($password == API_PASSWORD) { 
            if ($this->input->post()) { 
                $this->load->model('Stripe_model');
                $this->Stripe_model->test();
            }
        } 
    }

}