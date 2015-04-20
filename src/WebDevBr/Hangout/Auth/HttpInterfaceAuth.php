<?php

namespace WebDevBr\Hangout\Auth;

/**
 * Métodos comuns as classes de autenticação devem implementar
 * 
 * @category WebDevBr
 * @package Hangout\Auth
 * @author  Erik Figueiredo <falecom@erikfigueiredo.com.br>
 */
interface HttpInterfaceAuth
{
	public function header();
	public function checkAuth();
}