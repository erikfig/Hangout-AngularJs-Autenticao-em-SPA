<?php

namespace WebDevBr\Hangout\Auth;

/**
 * Métodos comuns as classes de autenticação
 * 
 * @category WebDevBr
 * @package Hangout\Auth
 * @author  Erik Figueiredo <falecom@erikfigueiredo.com.br>
 */
abstract class HttpAbstractAuth
{

	public $user, $loginSuccess = false;

	/**
	 * Seta o cabeçalho de acesso de acesso não autorizado
	 * 
	 * @return this
	 */
	public function forbidden()
	{
		header('HTTP/1.0 401 Unauthorized');
		return $this;
	}

	/**
	 * Retorna o resultado da verificação de autenticação
	 * 
	 * @return boolean
	 */
	public function getLoginSuccess()
	{
		return $this->loginSuccess;
	}

	abstract protected function setUserData();

}