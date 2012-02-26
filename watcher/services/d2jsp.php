<?php

	require_once("extra/curl.php");

	class D2TradeTools_D2JSP_Service {
		public function __construct($params) {
			$this->key = $params['key'];
			$this->user_id = $params['user_id'];
			$this->cookie = $params['cookie'];
		}

		public function login($username, $password) {
			// not implemented, set the cookie/user_id/key
		}

		public function set_notes($notes) {
			$session = new curl();

			$m1 = new curl_request();
			$m1->set_url("http://forums.d2jsp.org/user.php");
			$m1->set_referer("http://forums.d2jsp.org/user.php");
			$m1->set_post("c=12&i=" . $this->user_id . "&v=&k=" . $this->key . "&secO=2&Post=" . urlencode($notes));
			$m1->set_option(CURLOPT_COOKIE, $this->cookie);
			
			$r1 = $session->run($m1);

			// confirm correct return information
			if(!in_array($r1->status_code, array(200, 302)))
				throw new Exception("Could not retrieve the D2JSP profile page.");
		}
	}