<?php
header('Content-type: text/html; charset=utf-8');
define('SERVIDOR', 'pitayadecoracoes@gmail.com');
define('DESTINO', 'contato@pitayadecoracoes.com.br');
define('EMPRESA', 'Pitaya Decorações');

if (isset($_POST['nome'])){
    $nome    = (isset($_POST['nome']))? $_POST['nome']: '';
    $email   = (isset($_POST['email']))? $_POST['email']: '';
    $local   = (isset($_POST['local']))? $_POST['local']: '';
    $telefone   = (isset($_POST['telefone']))? $_POST['telefone']: '';
    $cidade   = (isset($_POST['cidade']))? $_POST['cidade']: '';
    $tipo   = (isset($_POST['tipo']))? $_POST['tipo']: '';
    $msg     = (isset($_POST['mensagem']))? $_POST['mensagem']: '';

    if (empty($nome) ||
        empty($email) ||
        empty($local) ||
        empty($telefone) ||
        empty($cidade) ||
        empty($tipo) ||
        empty($msg)){
         $array  = array('erro' => 2, 'mensagem' => 'Preencher os campos obrigatórios(*)!');
         echo json_encode($array);
    }else{

        if (empty($assunto)):
           $assunto = "Contato enviado pelo site " . EMPRESA;
        endif;

        $mensagem = "Contato enviado pelo site ".EMPRESA."\n";
        $mensagem .= "**********************************************************\n";
        $mensagem .= "Nome do Contato: ".$nome."\n";
        $mensagem .= "E-mail do Contato: ".$email."\n";
        $mensagem .= "Local do evento: ".$local."\n";
        $mensagem .= "Telefone para contato: ".$telefone."\n";
        $mensagem .= "Cidade do evento: ".$cidade."\n";
        $mensagem .= "Tipo do evento: ".$tipo."\n";
        $mensagem .= "**********************************************************\n";
        $mensagem .= "Mensagem: \n".$msg."\n";

        $retorno = EnviaEmail(DESTINO, $email, $assunto, $mensagem);

       if ($retorno){
           $array  = array('erro' => 0, 'mensagem' => 'Mensagem enviada com sucesso!');
           echo json_encode($array);
        }else{
           $array  = array('erro' => 1, 'mensagem' => 'Infelizmente houve um erro ao enviar sua mensagem!');
           echo json_encode($array);
        }
    }
}

function EnviaEmail($para, $from, $assunto, $mensagem){
    $para = DESTINO;
    $headers = "From: ".SERVIDOR."\n";
    $headers .= "Reply-To: $para\n";
    $headers .= "Subject: $assunto\n";
    $headers .= "Return-Path: ".SERVIDOR."\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "X-Priority: 3\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\n";

    $retorno = mail($para, $assunto, nl2br($mensagem), $headers);
    return $retorno;
}

?>
