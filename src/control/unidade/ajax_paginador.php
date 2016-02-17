<?php
$menu = 3;
//INSTACIA CLASSES
$obj = new Unidade();


$tpl = new Template("view/unidade/list.html");
$pesquisa = isset($_REQUEST['pesquisa']) ? $_REQUEST['pesquisa'] : "";
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->recuperaTotal($pesquisa);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->listar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa);
if (count($alist) > 0) {
foreach($alist as $key => $objario){
	$tpl->nome = $objario->descricao;
	$tpl->ID_HASH = $obj->md5_encrypt($objario->id);
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

