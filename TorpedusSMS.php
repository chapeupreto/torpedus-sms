<?php

/*
 * classe de envio de SMS usando a solucao da Torpedus (www.torpedus.com.br)
 *
 * Desenvolvido por rod@wgo.com.br
 * 15/08/2014
 * WGO Telecom
 *
 */

class TorpedusSMS {

	/**
	 * Usuario da conta torpedus
	 *
	 * @var string
	 */

	protected $username;

	/**
	 * Senha da conta torpedus
	 *
	 * @var string
	 */

	protected $password;

	/**
	 * Endereco/URL principal de acesso ao webservice da torpedus
	 *
	 * @var string
	 */

	protected $endereco;

	/**
	 * Endereco/URL final com os parametros GET para disparar o SMS
	 *
	 * @var string
	 */

	protected $url = '';

	/**
	 * curl handler para a requisicao
	 *
	 * @var resource
	 */

	protected $curl = null;

	/**
	 * tamanho maximo para a mensagem a ser enviada via SMS
	 *
	 * @var int
	 */

	const TAMANHO_MAXIMO_MENSAGEM = 304;

	public function __construct($username, $password, $endereco = 'http://torpedus.com.br/sms/index.php?') {
		$this->username = $username;
		$this->password = $password;
		$this->endereco = $endereco;

		$this->curl = curl_init();
	}

	/**
	 * envia uma mensagem via SMS ao telefone celular do destinatario
	 * @param  string $destinatario telefone do destinatario
	 * @param  string $mensagem		mensagem a ser enviada
	 * @throws Exception dispara excecao caso a mensagem a ser enviada possua tamanho superior a TAMANHO_MAXIMO_MENSAGEM
	 * @return  bool              true caso a mensagem seja disparada
	 */
	public function send_sms($destinatario, $mensagem) {
		if(strlen($mensagem) > self::TAMANHO_MAXIMO_MENSAGEM) {
			throw new Exception('Tamanho da mensagem nao pode ultrapassar '.self::TAMANHO_MAXIMO_MENSAGEM.' caracteres.');
		}

		return $this->exec($destinatario, $mensagem);
	}

	private function buildUrl($destinatario, $mensagem) {
		$query = array(
					'app' => 'webservices',
					'u' => $this->username,
					'p' => $this->password,
					'ta' => 'pv',
					'to' => $destinatario,
					'msg' => $mensagem,
				);

		$this->url = $this->endereco.http_build_query($query);
	}

	private function buildCurlOptions() {
		$options = array(
					CURLOPT_URL => $this->url,
					CURLOPT_RETURNTRANSFER => true,
				);
		
		return $options;
	}
	
	private function exec($destinatario, $mensagem) {
		$this->buildUrl($destinatario, $mensagem);
		$options = $this->buildCurlOptions();
		
		curl_setopt_array($this->curl, $options);
		$response = curl_exec($this->curl);

		// verifica se houve erro ao executar curl
		if($errno = curl_errno($this->curl)) {
			throw new Exception(sprintf('curl error %d: %s', $errno, curl_error($this->curl)));
		}
		
		// execucao curl ok, verifica se a requisicao http tambem retorna OK
		if(($httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE)) != '200') {
			throw new Exception(sprintf('Response code of requested resource is %d and it *must* be 200', $httpCode));
		}
		
		return true;
	}

	public function __destruct() {
		curl_close($this->curl);
	}	

} // TorpedusSMS
