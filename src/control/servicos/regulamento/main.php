<?php
$menu=11;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/servicos/main.html");
include("includes/config.php");
$pub = new Documento();
$tpl->GRUPO = $pub->get_pasta_grupo($pub::ID_GRUPO_REGULAMENTO); 
$tpl->HEADER_TITLE = "Lista de Documentos";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="servicos-regulamento-main"><i class="fa fa-file"> </i> Documentos</a></li>
                                         <li class="active">Documentos - Listar</li>';
$tpl->show();