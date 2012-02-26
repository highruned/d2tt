<?php

	error_reporting(E_ALL);

	require_once("signature.php");

	$singature = new D2TradeTools_Signature();

	$singature->show(array(
		'name' => 'DAEMN',
		'log' => '../watcher/logs/items.txt'
	));