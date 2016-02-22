<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/index/home.html");
$tpl->addFile("INC_LATERAL_DIREITA", "view/includes/lateral_direita.html");
include("includes/montaEmpresa.php");
include("includes/mensagem.php");

//ANOTACOES
$objPub = new Publicacao();
$rs = $objPub->listaHome($objPub::ID_GRUPO_ANOTE);
foreach ($rs as $key => $anote) {
    $tpl->DATA_ITEM = $objPub->getData($anote->data);
    $tpl->TITULO_ITEM = $anote->titulo;
    $tpl->USER_ITEM = $anote->usuario->nome;
    $tpl->FOTO_ITEM = $anote->usuario->foto;
	$tpl->block("BLOCK_ITEM_ANOTE");
}

$rs = $objPub->listaHome($objPub::ID_GRUPO_PARTICIPE);
foreach ($rs as $key => $anote) {
    $tpl->DATA_ITEM = $objPub->getData($anote->data);
    $tpl->TITULO_ITEM = $anote->titulo;
    $tpl->USER_ITEM = $anote->usuario->nome;
    $tpl->FOTO_ITEM = $anote->usuario->foto;
    $tpl->block("BLOCK_ITEM_PARTICIPE");
}

$rs = $objPub->listaHome($objPub::ID_GRUPO_COLABORE);
foreach ($rs as $key => $anote) {
    $tpl->DATA_ITEM = $objPub->getData($anote->data);
    $tpl->TITULO_ITEM = $anote->titulo;
    $tpl->USER_ITEM = $anote->usuario->nome;
    $tpl->FOTO_ITEM = $anote->usuario->foto;
    $tpl->block("BLOCK_ITEM_COLABORE");
}
$tpl->show();
