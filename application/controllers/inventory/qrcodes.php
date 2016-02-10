<?php
class Qrcodes extends CI_Controller {

    public function __construct(){
		parent::__construct();
		require_once(APPPATH.'third_party/qr-code-gen/qrcode.php');
	}

	function draw($text = "1111111111111"){
		$qr = new qrcode();

		$qr->text($text);
        header('Content-Type: image/png');
		readfile($qr->get_link());

   	}

}
