<?php
$menu=4;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/unidade/main.html");
include("includes/config.php");
$usu = new Unidade();
$tpl->HEADER_TITLE = "Lista de Unidades";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="unidade-main"><i class="fa fa-home"> </i> Unidades</a></li>
                                         <li class="active">Listar</li>';
$tpl->show();