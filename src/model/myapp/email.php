<?php
class Email extends Dao{
	const ASSINATURA = "Atenciosamente,<br/>Suporte invent<br/><a href='#url#'><img src='#url#/img/logo.png' width='120'/></a>";			
	var $assunto;
	var $conteudo;
	var $tipo;
	
	
	
function enviarEmailRedefinirSenha($nome, $email,$idUsuario){
		$mensagem = "Sr(a). $nome, sua senha foi redefinida. Clique <a href='".URL. "/admin_usuario-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para gerar uma nova senha.";
		$tplEmail = new Template("templates/padrao/email.html");
		$tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);
		$tplEmail -> MENSAGEM = $mensagem;
		return $this -> mail_html($email, REMETENTE, "invent - Redefinição de Senha", $tplEmail -> showString());
}

function enviarEmailNovoUsuario($nome, $email,$idUsuario){
        $mensagem = "Sr(a). $nome, você foi cadastrado como usuário ivent. Clique <a href='".URL ."/index-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para ativar seu usuário.";
        $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);
        $tplEmail -> MENSAGEM = $mensagem;
        return $this -> mail_html($email, REMETENTE, "invent - Cadastramento no Sistema", $tplEmail -> showString());
}

function enviarEmailNovaSenha($nome, $email,$senha){
        $mensagem = "Sr(a). $nome, sua nova senha para acesso é:<strong>$senha</strong>";
        $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);        
        $tplEmail -> MENSAGEM = $mensagem;        
        return $this -> mail_html($email, REMETENTE, "invent - Nova Senha", $tplEmail -> showString());
}



}
?>