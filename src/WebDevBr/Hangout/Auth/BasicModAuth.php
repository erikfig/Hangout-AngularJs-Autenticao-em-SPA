<?php

namespace WebDevBr\Hangout\Auth;

/**
 * Classe para autenticação via Basic
 * 
 * @category WebDevBr
 * @package Hangout\Auth
 * @author  Erik Figueiredo <falecom@erikfigueiredo.com.br>
 */
class BasicModAuth extends HttpAbstractAuth implements HttpInterfaceAuth
{

	/**
	 * Seta os cabeçalhos Basic
	 * 
	 * @return this
	 */
	public function header()
	{
		header('WWW-Authenticate: BasicMod realm="My Realm"');
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
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);

			if (!empty($request->user))
				$this->user['user'] = $request->user;

			if (!empty($request->pw))
				$this->user['pw'] = $request->pw;
		} else {
			$headers = apache_request_headers();
			if ($headers['Authorization']) {
				$token = explode(' ', $headers['Authorization']);
				$user = base64_decode($token[1]);
				$user = explode('|', $user);
				
				if (!empty($user[0]))
				$this->user['user'] = $user[0];

				if (!empty($user[1]))
					$this->user['pw'] = $user[1];
			}
		}
		return $this;
	}

}