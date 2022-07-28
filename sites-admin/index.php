<?php

$identifier = 'websitemaker_d4d66f6a09795043b50a63f0e8e596bfdef1';
$salt = '(hZ7Ee(o6h';
$baseurl = 'https://config.websitemaker.hostnet.nl/cm4all-admin';
$user = 'admin';
$pwhash = '5d92553a0887678e546c10f01a188f6d';
$host = 'theindiafoundation.nl';

if (empty($salt)) {
	trigger_error('unconfigured');
	exit(1);
}
if (empty($pwhash)) {
	trigger_error('unconfigured');
	exit(1);
}

if (!isset($_REQUEST['user']) || !is_string($_REQUEST['user']) || empty($_REQUEST['user']) || $_REQUEST['user'] != $user) {
	trigger_error('unauthorized');
	exit(1);
}

if (!isset($_POST['password']) || !is_string($_POST['password']) || empty($_POST['password'])) {
	trigger_error('unauthorized');
	exit(1);
}

$cmphash = md5($salt.$_POST['password']);
if ($cmphash != $pwhash) {
	trigger_error('unauthorized');
	exit(1);
}


$url = $baseurl . '/createLogin?identifier=' . $identifier . '&appParam.externalToken=' . $host;
$response = file_get_contents($url);
if (!is_string($response) || empty($response)) {
	trigger_error('failure');
	exit(1);
}
if (!preg_match("/^M I;OK;;\s+V ([^ ]+)$/",$response,$matches)) {
	trigger_error('failure');
	exit(1);
}
$loginurl = urldecode($matches[1]);

header('Location: '.$loginurl);
echo "goto ".$loginurl;
