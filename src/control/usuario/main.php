<?php
$menu=3;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/usuario/main.html");
include("includes/config.php");
$tpl->HEADER_TITLE = "Lista de Usuários";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="perfil-main"><i class="fa fa-users"> </i> Usuários</a></li>
                                         <li class="active">Listar</li>';
$usu = new Usuario();
$perfil = new Perfil();
$rsPerfil = $perfil->getRows();
foreach ($rsPerfil as $key => $value) {
   
    $tpl->ID_PERFIL = $value->id;
    $tpl->DESC_PERFIL = $value->descricao;    
    $tpl->block("ITEM_PERFIL");
   
}


$tpl->show();