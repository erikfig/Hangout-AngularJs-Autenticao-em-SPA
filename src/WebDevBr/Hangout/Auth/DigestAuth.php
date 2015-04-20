<?php

namespace WebDevBr\Hangout\Auth;

/**
 * Classe para autenticação via Digest
 * 
 * @category WebDevBr
 * @package Hangout\Auth
 * @author  Erik Figueiredo <falecom@erikfigueiredo.com.br>
 */
class DigestAuth extends HttpAbstractAuth implements HttpInterfaceAuth
{

	private $realm = 'My Realm';

	/**
	 * Seta os cabeçalhos Digest
	 * 
	 * @return this
	 */
	public function header()
	{
		if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
			header('HTTP/1.1 401 Unauthorized');
	    	header('WWW-Authenticate: Digest realm="'.$this->realm.
	           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($this->realm).'"');
	    }
		
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

		if (empty($this->user['valid_response']))
			return $this;

		if ($this->user['data']['response'] == $this->user['valid_response'])
			$this->loginSuccess = true;

		return $this;

	}

	/**
	 * Armazena os dados de acesso em um array
	 * 
	 * @return this
	 */
	protected function setUserData()
	{
		$user['erik'] = '123';

		if (empty ($_SERVER['PHP_AUTH_DIGEST']))
			return false;
		
		$this->user['data'] = $data = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST']);

		if ($data) {
			$A1 = md5($data['username'] . ':' . $this->realm . ':' . $user[$data['username']]);
			$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
			$this->user['valid_response'] = $valid_response = 
					md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);
		}
	}

	/**
	 * Armazena os dados de acesso em um array
	 * 
	 * @return this
	 */
	private function http_digest_parse($txt)
	{
	    // proteção contra dados incompletos
	    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
	    $data = array();
	    $keys = implode('|', array_keys($needed_parts));

	    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

	    foreach ($matches as $m) {
	        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
	        unset($needed_parts[$m[1]]);
	    }

	    return $needed_parts ? false : $data;
	}
}