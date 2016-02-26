<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/index/ativar.html");
$tpl->addFile("INC_LATERAL_DIREITA", "view/includes/lateral_direita.html");
include("includes/montaEmpresa.php");
include("includes/formLogin.php");
include("includes/mensagem.php");

$user = new Usuario();
if(isset($_REQUEST['id'])){
$idUser = $user->md5_decrypt($_REQUEST['id']);
    
$user->getById($idUser);    
    if($user->id == null){
        Message::setMensagem(1);
        header("Location:index-home");
        exit();
    }else{
        if($user->ativo == "0"){
                $tpl->idrash = $_REQUEST['id'];
                $tpl->email = $user->email;
        }else{
           Message::setMensagem(11);
            header("Location:index-home");
            exit();
        
        }
    }
}else{
    Message::setMensagem(1);
        header("Location:index-home");
        exit();
}
$tpl->show();

