<?php
$menu=0;
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
include("includes/lock.php");
$tpl->addFile("CONTENT", "view/home/home.html");
include("includes/montaEmpresa.php");
include("includes/montaMenu.php");
include("includes/mensagem.php");
$tpl->show();
