<?php
if(isset($_SESSION['zurc.mensagem'])){
	$msg = new Message();
	$tpl->MENSAGEM = $msg->echoMensagem($_SESSION['zurc.mensagem']);
	Message::unSetMensagem();
}
?>