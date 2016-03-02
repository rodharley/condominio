<?php
$menu=10;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/servicos/edit.html");
include("includes/config.php");
$tpl->HEADER_TITLE = "Manutenção de Documento";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="servicos-convencao-main"><i class="fa fa-file"> </i> Documentos</a></li>
                                         <li class="active">Documento - Editar</li>';

$obj = new Documento();

$tpl->GRUPO = $obj->get_pasta_grupo($obj::ID_GRUPO_CONVENCAO); 
$tpl->LABEL = "Novo Documento";
$tpl->ACAO = "incluir";
$tpl->id = 0;
$tpl->DATA = date("d/m/Y");
$tpl->REQUIRED_FILE = 'required';
if(isset($_REQUEST['id'])){
	$obj->getById($obj->md5_decrypt($_REQUEST['id']));    
	$tpl->TITULO = $obj->titulo;
    $tpl->DOCUMENTO = $obj->arquivo;
    $tpl->DATA = $obj->getData($obj->data);
    $tpl->LABEL = "Alterar Documento ".$obj->titulo;
	$tpl->ACAO = "editar";
	$tpl->REQUIRED_FILE = '';
    $tpl->id =$_REQUEST['id'];
}

$tpl->show();
?>