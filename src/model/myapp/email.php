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


function enviarEmailSolicitacaoCadastro($nome,$unidade,$email){
    $emp = new Empresa();    
    $emp->getById(EMPRESA);
      $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);        
        $tplEmail -> MENSAGEM = "Dados do usu�rio solicitante: <br/>Nome: ".$nome."<br/>Unidade: ".$unidade." <br/>Email: ".$email;        
        return $this -> mail_html($emp->emailcontato, REMETENTE, "Condominium - Solicita��o de Cadastramento", $tplEmail -> showString());
}
	
function enviarEmailRedefinirSenha($nome, $email,$idUsuario){
		 $emp = new Empresa();
        $emp->getById(EMPRESA);    
		$mensagem = "Sr(a). $nome, sua senha foi redefinida. Clique <a href='".URL. "/index-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para gerar uma nova senha.";
		$tplEmail = new Template("view/padrao/email.html");
		$tplEmail -> ASSINATURA = str_replace("#url#",URL,str_replace("#nome#",$_SESSION['zurc.userNome'],str_replace("#logomarca#",$emp->logomarca,Email::ASSINATURA)));
		$tplEmail -> MENSAGEM = $mensagem;
		return $this -> mail_html($email, REMETENTE, "Condominium - Redefini��o de Senha", $tplEmail -> showString());
}

function enviarEmailNovoUsuario($nome, $email,$idUsuario){
        $emp = new Empresa();
        $emp->getById(EMPRESA);
        $mensagem = "Sr(a). $nome, voc� foi cadastrado como usu�rio. Clique <a href='".URL."/index-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para ativar seu usu�rio.";
        $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,str_replace("#nome#",$_SESSION['zurc.userNome'],str_replace("#logomarca#",$emp->logomarca,Email::ASSINATURA)));
        $tplEmail -> MENSAGEM = $mensagem;
        return $this -> mail_html($email, REMETENTE, "Condominium - Cadastramento no Sistema", $tplEmail -> showString());
}

function enviarEmailNovaSenha($nome, $email,$senha){
         $emp = new Empresa();
        $emp->getById(EMPRESA);    
        $mensagem = "Sr(a). $nome, sua nova senha para acesso �:<strong>$senha</strong>";
        $tplEmail = new Template("view/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,str_replace("#nome#","Condom�nio",str_replace("#logomarca#",$emp->logomarca,Email::ASSINATURA)));        
        $tplEmail -> MENSAGEM = $mensagem;        
        return $this -> mail_html($email, REMETENTE, "Condominium - Nova Senha", $tplEmail -> showString());
}



}
?>