<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compare_model extends CI_Model {

	public function generateArbitrageEvents() {
		/*
			1. Generate Data
			2. Sort based off currency
			3. Calculate % match pairs
			4. Save above 3%
		*/
		$sql = "SELECT p.price, m.currency_id, m.market_id, p.lastupdate FROM markets_pairs m 
				LEFT JOIN price_chart p ON m.currency_id = p.currency_id AND m.market_id = p.market_id 
				WHERE m.active = '1' 
				GROUP BY m.market_id, m.currency_id
				order by MAX(p.created) DESC";
				
	}

	public function generatePairEvents() {

	}

	public function generateFollowUp() {

	}

}