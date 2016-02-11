<?php
$tpl = new Template("view/templates/login_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/login/recuperarSenha.html");
include("includes/mensagem.php");
$tpl->show();
