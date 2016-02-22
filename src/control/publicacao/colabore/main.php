<?php
$menu=7;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/publicacao/main.html");
include("includes/config.php");
$pub = new Publicacao();
$tpl->GRUPO = $pub->get_pasta_grupo($pub::ID_GRUPO_COLABORE); 
$tpl->HEADER_TITLE = "Lista de Publicações";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="publicacao-anote-main"><i class="fa fa-home"> </i> Publicações</a></li>
                                         <li class="active">Publicação - Listar</li>';
$tpl->show();