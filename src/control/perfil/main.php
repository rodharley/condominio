<?php
$menu=2;
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
include("includes/lock.php");
$tpl->addFile("CONTENT", "view/perfil/list.html");
include("includes/montaEmpresa.php");
include("includes/montaMenu.php");
include("includes/mensagem.php");

//INSTACIA CLASSES
$perfil = new Perfil();

//CONFIGURA O BREADCRUMB




$alist = $perfil->getRows();
$tpl->QUANTIDADE = count($alist);
foreach($alist as $key => $perfilario){
	$tpl->disabled = "";    
	$tpl->nome = $perfilario->descricao;
	$tpl->ID_HASH = $perfil->md5_encrypt($perfilario->id);
    if($perfilario->id == Perfil::SINDICO)
    $tpl->disabled = "disabled";
	$tpl->block("BLOCK_ITEM_LISTA");
}

$tpl->show();
?>