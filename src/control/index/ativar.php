<?php
$tpl = new Template("view/templates/login_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/login/ativar.html");
include("includes/mensagem.php");
$user = new Usuario();
if(isset($_REQUEST['id'])){
$idUser = $user->md5_decrypt($_REQUEST['id']);
    
$user->getById($idUser);    
    if($user->id == null){
        Message::setMensagem(1);
        header("Location:index-login");
        exit();
    }else{
        if($user->ativo == "0"){
                $tpl->idrash = $_REQUEST['id'];
                $tpl->email = $user->email;
        }else{
           Message::setMensagem(11);
            header("Location:index-login");
            exit();
        
        }
    }
}else{
    Message::setMensagem(1);
        header("Location:index-login");
        exit();
}
$tpl->show();

