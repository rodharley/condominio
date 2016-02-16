<?php
$menu=2;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/perfil/list.html");
include("includes/config.php");

//INSTACIA CLASSES
$perfil = new Perfil();

//CONFIGURA O BREADCRUMB




$alist = $perfil->getRows(0,9999,array(),array("empresa"=>"=".EMPRESA));
$tpl->QUANTIDADE = count($alist);
foreach($alist as $key => $perfilario){
	$tpl->disabled = "";    
	$tpl->nome = $perfilario->descricao;
	$tpl->ID_HASH = $perfil->md5_encrypt($perfilario->id);
    $tpl->block("BLOCK_ITEM_LISTA");
}

$tpl->show();
?>