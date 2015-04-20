<?php

namespace WebDevBr\Hangout\Auth;

/**
 * Classe para autenticação via Basic
 * 
 * @category WebDevBr
 * @package Hangout\Auth
 * @author  Erik Figueiredo <falecom@erikfigueiredo.com.br>
 */
class BasicAuth extends HttpAbstractAuth implements HttpInterfaceAuth
{

	/**
	 * Seta os cabeçalhos Basic
	 * 
	 * @return this
	 */
	public function header()
	{
		header('WWW-Authenticate: Basic realm="My Realm"');
		header('HTTP/1.0 401 Unauthorized');
		
		return $this;
	}

	/**
	 * Executa a verificação de autenticação
	 * 
	 * @return this
	 */
	public function checkAuth()
	{
		$this->setUserData();

		if (!isset($this->user['user']) and !isset($this->user['pw']))
			return $this;

		if ($this->user['user'] == 'erik' and $this->user['pw'] == '123')
				$this->loginSuccess = true;

		return $this;

	}

	/**
	 * Armazena os dados enviados pelo usuário em um array
	 * 
	 * @return this
	 */
	protected function setUserData()
	{
		if (!empty($_SERVER['PHP_AUTH_USER']))
			$this->user['user'] = $_SERVER['PHP_AUTH_USER'];

		if (!empty($_SERVER['PHP_AUTH_PW']))
			$this->user['pw'] = $_SERVER['PHP_AUTH_PW'];
		return $this;
	}

}