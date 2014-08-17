<?php

/*
| exemplo de utilizacao da classe
| rod@wgo.com.br
| WGO Telecom
 */

include 'TorpedusSMS.php';

$username = '9013'; // ID da conta cadastrada no site da Torpedus
$password = 'torp3dus'; // senha cadastrada no site da Torpedus

$destinatario = '556481251119'; // numero do celular deve incluir o prefixo 55 e o DDD
$mensagem = 'Mensagem de teste usando a solucao da Torpedus SMS'; // a mensagem deve possuir tamanho maximo de 304 caracteres e pode ou nao ter acentuação

$torpedus = new TorpedusSMS($username, $password);

try {
	$torpedus->send_sms($destinatario, $mensagem); // se a conta cadastrada na Torpedus tiver crédito, então a mensagem será enviada ao celular do destinatário
} catch(Exception $e) {	
	echo $e->getMessage();
}
