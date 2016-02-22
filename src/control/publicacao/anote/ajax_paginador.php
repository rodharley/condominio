<?php
$menu = 6;
//INSTACIA CLASSES
$obj = new Publicacao();
$grupo = $obj::ID_GRUPO_ANOTE;

$tpl = new Template("view/publicacao/list.html");

$tpl->GRUPO = $obj->get_pasta_grupo($grupo);

$pesquisa = isset($_REQUEST['pesquisa']) ? $_REQUEST['pesquisa'] : "";
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->recuperaTotal($pesquisa,$grupo);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->listar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa,$grupo);
if (count($alist) > 0) {
foreach($alist as $key => $publicacao){
	$tpl->nome = $publicacao->titulo;
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

