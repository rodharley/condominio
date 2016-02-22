<?php
class Email extends Dao{
	const ASSINATURA = "Atenciosamente,<br/>#nome#<br/><a href='#url#'><img src='#url#/img/clients/#logomarca#' width='120'/></a>";			
	var $assunto;
	var $conteudo;
	var $tipo;
	

function enviarEmailPortal($email,$mensagem){
    $emp = new Empresa();    
    $emp->getById(EMPRESA);
      $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);        
        $tplEmail -> MENSAGEM = $email."<br/>".$mensagem;        
        return $this -> mail_html($emp->emailcontato, REMETENTE, "Condominium - Email do portal", $tplEmail -> showString());
}
	
	
function enviarEmailRedefinirSenha($nome, $email,$idUsuario){
		 $emp = new Empresa();
        $emp->getById(EMPRESA);    
		$mensagem = "Sr(a). $nome, sua senha foi redefinida. Clique <a href='".URL. "/index-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para gerar uma nova senha.";
		$tplEmail = new Template("view/padrao/email.html");
		$tplEmail -> ASSINATURA = str_replace("#url#",URL,str_replace("#nome#",$_SESSION['zurc.userNome'],str_replace("#logomarca#",$emp->logomarca,Email::ASSINATURA)));
		$tplEmail -> MENSAGEM = $mensagem;
		return $this -> mail_html($email, REMETENTE, "Condomínio - Redefinição de Senha", $tplEmail -> showString());
}

function enviarEmailNovoUsuario($nome, $email,$idUsuario){
        $emp = new Empresa();
        $emp->getById(EMPRESA);
        $mensagem = "Sr(a). $nome, você foi cadastrado como usuário. Clique <a href='".URL."/index-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para ativar seu usuário.";
        $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,str_replace("#nome#",$_SESSION['zurc.userNome'],str_replace("#logomarca#",$emp->logomarca,Email::ASSINATURA)));
        $tplEmail -> MENSAGEM = $mensagem;
        return $this -> mail_html($email, REMETENTE, "Condomínio - Cadastramento no Sistema", $tplEmail -> showString());
}

function enviarEmailNovaSenha($nome, $email,$senha){
         $emp = new Empresa();
        $emp->getById(EMPRESA);    
        $mensagem = "Sr(a). $nome, sua nova senha para acesso é:<strong>$senha</strong>";
        $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,str_replace("#nome#","Condomínio",str_replace("#logomarca#",$emp->logomarca,Email::ASSINATURA)));        
        $tplEmail -> MENSAGEM = $mensagem;        
        return $this -> mail_html($email, REMETENTE, "Condomínio - Nova Senha", $tplEmail -> showString());
}



}
?>