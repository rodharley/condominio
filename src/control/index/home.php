<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/index/home.html");
include("includes/montaEmpresa.php");
include("includes/mensagem.php");
$tpl->show();