<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		$cryptocompareApi = new Cryptocompare\CryptocompareApi();
		$cryptocomparePrice = new Cryptocompare\Price();
		$cryptocompareCoin = new Cryptocompare\Coin();
		$cryptocompareMarket = new Cryptocompare\Market();
		$data["coinslist"] = $cryptocompareCoin->getList();
		$data["getmarkets"] = $cryptocompareMarket->getList(false);
		//$data["price"] = $cryptocomparePrice->getGenerateAvg("1", "LSK", "BTC", "Binance",false);
		$data["price"] = $cryptocomparePrice->getMultiPriceFull("1", array("CLAM","GNO","RDD","XVC","NOBL","CHA","VTC","XEM","XDN","NSR","NMC","STORJ","BITS","MMC","VRC","CGA","BLK","PTS","POT","XMY","CNMT","BCY","GRC","LBC","UIS","DSH","SC","VIA","PIGGY","QTL","XDP","XCR","XC","NXTI","HUC","EXE","SBD","FLDC","OPAL","BITUSD","ZRX","QBK","BLOCK","CINNI","EXP","NBT","URO","OMNI","BTS","FLT","DOGE","FRAC","ARCH","XPB","XPM","ADN","MRS","GMC","SSD","EMC2","GEMZ","GAP","WOLF","FIBRE","FCT","MSC","PRC","BTM","NAV"), array("BTC","USD","ETH","XMR"),"Poloniex", false);
		$this->load->view('welcome_message', $data);
	}
}
