<?php
$nome       = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
$email      = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$telefone   = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
$loja       = filter_input(INPUT_POST, "loja", FILTER_SANITIZE_STRING);

require_once('./PHPMailer/class.phpmailer.php');

$Email = new PHPMailer();
$Email->SetLanguage("br");
$Email->IsSMTP(); // Habilita o SMTP 
$Email->CharSet = "UTF-8";
$Email->SMTPSecure = "ssl";
$Email->SMTPAuth = true; //Ativa e-mail autenticado
$Email->Host = 'casteloforte.com.br'; // Servidor de envio # verificar qual o host correto com a hospedagem as vezes fica como smtp.
$Email->Port = '465'; // Porta de envio
$Email->Username = 'mkt@casteloforte.com.br'; //e-mail que será autenticado
$Email->Password = 'a1b2c3d4'; // senha do email
// ativa o envio de e-mails em HTML, se false, desativa.
$Email->IsHTML(true);
// email do remetente da mensagem
$Email->From = utf8_decode($email);
// nome do remetente do email
$Email->FromName = $nome;
// Endereço de destino do email, ou seja, pra onde você quer que a mensagem do formulário vá?

if ($loja == "samambaia") {
    $Email->AddAddress("sonho@casteloforte.com.br");
    $Email->AddAddress("bosco@casteloforte.com.br");    
} elseif ($loja == "recanto") {
       $Email->AddAddress("meusonho@casteloforte.com.br"); // E-mail do destinatário
    $Email->AddAddress("bosco@casteloforte.com.br");
} else {
    $Email->AddAddress("inovepublicidadedf@gmail.com");
    $Email->AddAddress("meusonhovip@casteloforte.com.br"); // E-mail do destinatário
    $Email->AddAddress("bosco@casteloforte.com.br");
}
$Email->Subject = "Designer de Interiores:";
$Email->Body .= "<br /><br />
        <strong>Traga suas idéias. Idealizaremos seus sonhos<strong> <br><br>
        <strong>Nome:</strong> $nome<br /><br />
        <strong>E-mail:</strong> $email<br /><br />
        <strong>Telefone:</strong> $telefone<br /><br />
        <strong>Cidade:</strong> $loja<br /><br />";
// verifica se está tudo ok com oa parametros acima, se nao, avisa do erro. Se sim, envia.

if (!$Email->Send()) {
    echo "<p>A mensagem não foi enviada. </p>";
//    echo "Erro: " . $Email->ErrorInfo;
} else {
    echo "<script>alert('Mensagem enviada com sucesso!');</script>";
    echo "<script>window.location = 'https://www.casteloforte.com.br'</script>";
   
}
