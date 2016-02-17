<?php
$menu=4;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/unidade/edit.html");
include("includes/config.php");
$tpl->HEADER_TITLE = "Manutenção de Unidade";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="unidade-main"><i class="fa fa-home"> </i> Unidades</a></li>
                                         <li class="active">Editar</li>';

$objUnidade = new Unidade();


$tpl->LABEL = "Nova Unidade";
$tpl->ACAO = "incluir";
$tpl->id = 0;

if(isset($_REQUEST['id'])){
	$objUnidade->getById($objUnidade->md5_decrypt($_REQUEST['id']));    
	$tpl->nome = $objUnidade->descricao;
    $tpl->LABEL = "Alterar Unidade ".$objUnidade->descricao;
	$tpl->ACAO = "editar";
    $tpl->id =$_REQUEST['id'];
}

$tpl->show();
?>