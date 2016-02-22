<?php
$menu=6;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/publicacao/edit.html");
include("includes/config.php");
$tpl->HEADER_TITLE = "Manuten��o de Publica��o";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="publicacao-anote-main"><i class="fa fa-home"> </i> Publica��es</a></li>
                                         <li class="active">Publica��o - Editar</li>';

$obj = new Publicacao();

$tpl->GRUPO = $obj->get_pasta_grupo($obj::ID_GRUPO_ANOTE); 
$tpl->LABEL = "Nova Publica��o";
$tpl->ACAO = "incluir";
$tpl->id = 0;
$tpl->DATA = date("d/m/Y");
if(isset($_REQUEST['id'])){
	$obj->getById($obj->md5_decrypt($_REQUEST['id']));    
	$tpl->TITULO = $obj->titulo;
    $tpl->CONTEUDO = $obj->conteudo;
    $tpl->DATA = $obj->getData($obj->data);
    $tpl->LABEL = "Alterar Publica��o ".$obj->titulo;
	$tpl->ACAO = "editar";
    $tpl->id =$_REQUEST['id'];
}

$tpl->show();
?>