# Torpedus SMS

Esse projeto consiste em uma API simples desenvolvida em PHP que pode ser usada para enviar mensagens _SMS_ utilizando o serviço fornecido pela empresa **Torpedus** (www.torpedus.com.br)

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