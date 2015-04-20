<?php

require 'vendor/autoload.php';

/**
 * Você só precisa trocar o nome a classe para usar o método escolhido de autenticação
 * DigestAuth: Digest Access
 * BasicAuth: Basic Access
 */

$auth = new WebDevBr\Hangout\Auth\DigestAuth;

echo "Acesso proibido";
$auth->forbidden();
