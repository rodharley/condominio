<?php
$menu = 10;
//INSTACIA CLASSES
$obj = new Documento();
$grupo = $obj::ID_GRUPO_CONVENCAO;

$tpl = new Template("view/servicos/list.html");

$tpl->GRUPO = $obj->get_pasta_grupo($grupo);
$user = $_SESSION['zurc.userPerfilId'] != Perfil::SINDICO ? $_SESSION['zurc.userId'] : "";
$pesquisa = isset($_REQUEST['pesquisa']) ? $_REQUEST['pesquisa'] : "";
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : "1";
$totalPesquisa = $obj->recuperaTotal($pesquisa,$grupo,$user);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->listar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa,$grupo,$user);
if (count($alist) > 0) {
foreach($alist as $key => $publicacao){
	$tpl->nome = $publicacao->titulo;
    $tpl->data = $obj->getData($publicacao->data);
	$tpl->ID_HASH = $obj->md5_encrypt($publicacao->id);
	$tpl->block("BLOCK_ITEM_LISTA");
	
}
}
$tpl->paginar_class = 'paginar';
$tpl->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$tpl->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$tpl->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$tpl->PAGINA = $pagina;
if($configPaginacao['totalPaginas'] > 1){
$tpl->block("BLOCK_PAGINACAO");
}
$tpl->show();

exit();
?>

