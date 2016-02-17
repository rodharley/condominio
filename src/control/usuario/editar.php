<?php
$menu=3;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/usuario/edit.html");
include("includes/config.php");
$tpl->HEADER_TITLE = "Manutenção de Usuário";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="perfil-main"><i class="fa fa-users"> </i> Usuário</a></li>
                                         <li class="active">Editar</li>';

$usu = new Usuario();
$unidade = new Unidade();
$perfil = new Perfil();


$tpl->LABEL = "Novo Usuário";
$tpl->ACAO = "incluir";
$tpl->id = 0;
$tpl->checksim = "checked='checked'";
$tpl->checknao = "";
$tpl->IMG_USER = "<img src='img/users/user.png' class='file-preview-image' alt='imagem do usuário' title='imagem do usuário'>";
$idUnidadeUsu = 0;
$idPerfilUsu = 0;

if(isset($_REQUEST['id'])){
	$usu->getById($usu->md5_decrypt($_REQUEST['id']));    
	$tpl->nome = $usu->nome;
    $tpl->email = $usu->email;
	$tpl->senha = "";
	$tpl->id = $_REQUEST['id'];
	$idPerfilUsu = $usu->perfil->id;
	if($usu->unidade != null)
	   $idUnidadeUsu = $usu->unidade->id;
	$tpl->IMG_USER = "img/users/".$usu->foto;
	$tpl->LABEL = "Alterar Usuário ".$usu->nome;
	$tpl->ACAO = "editar";
    if($usu->ativo == "0"){
	$tpl->checknao = "checked='checked'";
	$tpl->checksim = "";
	}
    

	if(strlen($usu->foto) > 0){
		$tpl->IMG_USER = "<img src='img/users/".$usu->foto."' class='file-preview-image' alt='imagem do usuário' title='imagem do usuário''>";		
	}
    
}

$rsPerfil = $perfil->getRows(0,999,array("id"=>"asc"),array("empresa"=>"=".EMPRESA));
 foreach($rsPerfil as $key => $p){
 	$tpl->idItem = $p->id;
	$tpl->labelItem = $p->descricao;
	if($p->id == $idPerfilUsu)
		$tpl->checkItem = "selected";
	else
		$tpl->checkItem = "";
	$tpl->block("BLOCK_ITEM");
 }
$rsUnidade = $unidade->getRows(0,999,array("descricao"=>"asc"),array("empresa"=>"=".EMPRESA));
 foreach($rsUnidade as $key => $p){
    $tpl->idItem = $p->id;
    $tpl->labelItem = $p->descricao;
    if($p->id == $idUnidadeUsu)
        $tpl->checkItem = "selected";
    else
        $tpl->checkItem = "";
    $tpl->block("BLOCK_ITEM_UNIDADE");
 }


$tpl->show();
?>