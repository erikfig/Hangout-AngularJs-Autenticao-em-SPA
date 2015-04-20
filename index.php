<?php

 header("Access-Control-Allow-Origin: *");

require 'vendor/autoload.php';

/**
 * Você só precisa trocar o nome a classe para usar o método escolhido de autenticação
 * DigestAuth: Digest Access
 * BasicAuth: Basic Access
 */

$auth = new WebDevBr\Hangout\Auth\BasicModAuth;

if ($auth->checkAuth()->getLoginSuccess()) {
	$eu = [
	'nome'=>'Erik Figueiredo',
	'idade'=>29
	];
	echo json_encode($eu);
	exit;
}

$auth->header();
echo 'Você não acessou';