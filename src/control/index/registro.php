<?php
$tpl = new Template("view/templates/login_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/login/registro.html");
include("includes/mensagem.php");
$tpl->show();
