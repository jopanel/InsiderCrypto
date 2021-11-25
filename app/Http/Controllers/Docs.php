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
		return view('main.header', $head) . view('main.docsheader') . view('main.privacy') . view('main.footer');
	}

	public function terms() {
		$head["navbartoggle"] = "";
		return view('main.header', $head) . view('main.docsheader') . view('main.terms') . view('main.footer');

	}

	public function faq() {
		$head["navbartoggle"] = "";
		return view('main.header', $head) . view('main.docsheader') . view('main.faq') . view('main.footer');
	}

}