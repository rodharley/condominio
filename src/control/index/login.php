<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/home/home.html");
include("includes/mensagem.php");
$tpl->show();
