<?php

	error_reporting(E_ALL);

	require_once("watcher.php");
	require_once("services/d2jsp.php");

	$watcher = new D2TradeTools_Watcher();

	$d2jsp = new D2TradeTools_D2JSP_Service(array(
		'cookie' => 'COOKIE_KEY',
		'user_id' => 'USER_ID_HERE',
		'key' => 'KEY_HERE'
	));

	$watcher->watch(array(
		'logs' => array(
			'logs/bot1.txt'
		),
		'services' => array(
			$d2jsp
		)
	));