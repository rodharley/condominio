<?php
$menu=0;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/usuario/meusdados.html");
include("includes/config.php");
$tpl->HEADER_TITLE = "Gerenciar Meus Dados";
$tpl->HEADER_BREAD_CRUMB = '<li><a href="home-home"><i class="fa fa-home"> </i> Home</a></li>
                                         <li class="active">Meus Dados</li>';

$usu = new Usuario();
$unidade = new Unidade();
$perfil = new Perfil();


$tpl->LABEL = "Editar Meus Dados";
$tpl->ACAO = "meus";
$tpl->IMG_USER = "<img src='img/users/user.png' class='file-preview-image' alt='imagem do usuário' title='imagem do usuário'>";
$usu->getById($_SESSION['zurc.userId']);    
	$tpl->nome = $usu->nome;
    $tpl->email = $usu->email;
	$tpl->senha = "";
    $tpl->ID_RASH = $usu->md5_encrypt($usu->id);
	$tpl->IMG_USER = "img/users/".$usu->foto;
		if(strlen($usu->foto) > 0){
		$tpl->IMG_USER = "<img src='img/users/".$usu->foto."' class='file-preview-image' alt='imagem do usuário' title='imagem do usuário''>";		
	}

$tpl->show();
?>