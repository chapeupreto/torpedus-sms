# Torpedus SMS

Esse projeto consiste em uma API simples desenvolvida em PHP que pode ser usada para enviar mensagens _SMS_ utilizando o serviço fornecido pela empresa **Torpedus** (www.torpedus.com.br)

# Motivação

Atualmente a empresa [Torpedus](www.torpedus.com.br) não possui uma API própria em PHP para enviar as mensagens via SMS. O método que eles utilizam até então é fazer chamadas ao _webservices_ deles usando a URL com os parâmetros dos dados de _usuário_, _senha_, _telefone do destinatário_ e a _mensagem_ via requisição _HTTP GET_ (exemplo: _http://torpedus.com.br/sms/index.php?app=webservices&u=LOGIN&p=SENHA&ta=pv&to=55dddCELULAR&msg=mensagem+ou+variaveis+sempre+sem+acentos_)

Essa prática, apesar de funcionar, possui algumas desvantagens, como por exemplo, dependendo do ambiente onde for utilizada, os dados de acesso (i.e., _usuário_ e _senha_) poderão ficar expostos, comprometendo assim a segurança dessas informações.

Pensando assim, surgiu a necessidade de se criar essa API em PHP justamente para encapsular essas informações a fim de prover uma maior segurança, bem como fornecer uma interface para fácil de integração com outros sistemas.

# Requisitos


- PHP 5+
- Biblioteca cURL

# Utilização

Primeiramente, depois de baixar o arquivo `TorpedusSMS.php`, basta incluir o mesmo na sua aplicação:

```php
include 'TorpedusSMS.php';
```

Feito isso, basta _instanciar_ a classe usando o nome de usuário e a senha da sua conta cadastrada na _Torpedus_:

```php
$username = '9083'; // ID da conta cadastrada no site da Torpedus
$password = 'torp3dus'; // senha cadastrada no site da Torpedus

$torpedus = new TorpedusSMS($username, $password);
```

Por fim, basta executar o método `send_sms()` do objeto instanciado passando como argumentos o número do telefone do destinatário e a mensagem desejada:

```php
// se a conta cadastrada na Torpedus tiver crédito, então a mensagem será enviada ao celular do destinatário
$torpedus->send_sms($destinatario, $mensagem); 
```

Para tratamento de erros/exceções, pode-se fazer essa chamada dentro de um bloco `try/catch` conforme mostrado a seguir:

```php
try {
    $torpedus->send_sms($destinatario, $mensagem);
} catch(Exception $e) { 
    echo $e->getMessage();
}
```

# Observações

- O número do celular do destinatário deve obedecer ao seguinte formato: _55DDDTelefone_

**Exemplo:** `556481129090`

- Não é necessário remover a acentuação da mensagem a ser disparada via SMS. A API já realiza esse tratamento! :)

-  O tamanho máximo da mensagem a ser enviada deve ser de 304 caracteres.

# Aplicações

O uso de SMS está sendo cada vez mais utilizado no mundo corporativo e possui uma variedade de aplicações, sendo algumas destas listadas a seguir:

- Cobrança bancária avisando das parcelas a vencer ou já vencidas
- Campanhas de marketing
- Monitoramento e alertas de sistemas conectados à Internet

# Licença

Essa API é open-source e utiliza a licença [MIT](http://opensource.org/licenses/MIT "MIT license")
