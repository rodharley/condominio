<?php
$menu=2;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/perfil/edit.html");
include("includes/config.php");
$tpl->HEADER_TITLE = "Manutenção de Perfil";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="perfil-main"><i class="fa fa-users"> </i> Perfil</a></li>
                                         <li class="active">Editar</li>';
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------

$obj = new Perfil();
$objPermissao = new Permissao();
$objMenu = new Menu();

$tpl->LABEL = "Incluir Perfil";
$tpl->ACAO = "incluir";
$tpl->id = 0;
$arrayMenusSelecionados = array();


if(isset($_REQUEST['id'])){
    $tpl->LABEL = "Editar Perfil";
    $tpl->ACAO = "editar";
    $tpl->id = $_REQUEST['id'];
    $obj->getById($obj->md5_decrypt($_REQUEST['id']));
    $tpl->nome = $obj->descricao;
    
    $listaPermissaos = $objPermissao->recuperaMenuAcessos($obj->id);
    
    foreach($listaPermissaos as $key => $m){
    	$arrayMenusSelecionados[] = $m->menu->id;
    }
}


$menus = $objMenu->recuperaMenusCompletos(0);
 foreach($menus as $key => $m){
 	$tpl->DESC_MENU = $m->nome;
	$tpl->IDMENU = $m->id;
	if(in_array($m->id, $arrayMenusSelecionados))
		$tpl->CHECKMENU = 'checked="checked"';
	$submenus = $objMenu->recuperaMenusCompletos($m->id);
 	foreach($submenus as $key2 => $sm){
		$tpl->DESC_SUBMENU_MENU = $sm->nome;
		$tpl->IDSUBMENU = $sm->id;
		if(in_array($sm->id, $arrayMenusSelecionados))
		$tpl->CHECKSUBMENU = 'checked="checked"';
		$tpl->block("BLOCK_SUB_ITEM");
		$tpl->clear('CHECKSUBMENU');
	}
 	$tpl->block("BLOCK_ITEM");
	$tpl->clear('CHECKMENU');
 }


$tpl->show();
?>