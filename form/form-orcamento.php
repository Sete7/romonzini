<?php

$captcha = $_POST['g-recaptcha-response'];

if ($captcha != ''):
    $secreto = '6LdebFoUAAAAAAFy6g_dFaCL9VEOL-MG4jU2nmAG';
    $ip = $_SERVER['REMOTE_ADDR'];
    $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreto&response=$captcha&remoteid=$ip");
    $resposta = json_decode($var, true);

    if ($resposta['success']):

        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
        $cidade = filter_input(INPUT_POST, "cidade", FILTER_SANITIZE_STRING);
        $mensagem = filter_input(INPUT_POST, "mensagem", FILTER_SANITIZE_SPECIAL_CHARS);

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
//        $Email->AddAddress("telmoricardorosa@gmail.com"); // para quem será enviada a mensagem
        $Email->AddAddress("mkt@casteloforte.com.br"); // para quem será enviada a mensagem
        $Email->AddAddress("bosco@casteloforte.com.br"); // para quem será enviada a mensagem
        $Email->AddAddress("mkt.casteloforte@gmail.com"); // para quem será enviada a mensagem

        $Email->Subject = "Orçamento:";
        $Email->Body .= "<br /><br />
        <strong>Maiores informações do seu Orçamento<strong> <br><br>
        <strong>Nome:</strong> $nome<br /><br />
        <strong>E-mail:</strong> $email<br /><br />
        <strong>Telefone:</strong> $telefone<br /><br />
        <strong>Cidade:</strong> $cidade<br /><br />
        <strong>Mensagem:</strong> $mensagem<br /><br />";

        // verifica se está tudo ok com oa parametros acima, se nao, avisa do erro. Se sim, envia.

        if (!$Email->Send()) {
            echo "<p>A mensagem não foi enviada. </p>";
            //    echo "Erro: " . $Email->ErrorInfo;
        } else {
            echo "<script>alert('Mensagem enviada com sucesso!');</script>";
            echo "<script>window.location = 'https://www.casteloforte.com.br'</script>";
        }
    endif;
else:
    echo "<script>alert('Mensagem enviada com sucesso!');</script>";
    echo "<script>window.location = 'https://www.casteloforte.com.br/orcamento'</script>";
     
endif;


