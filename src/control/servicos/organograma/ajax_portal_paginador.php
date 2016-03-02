<?php
//INSTACIA CLASSES
$obj = new Documento();
$grupo = $obj::ID_GRUPO_ORGANOGRAMA;

$tpl = new Template("view/servicos/portal_list.html");
$tpl->GRUPO = $obj->get_pasta_grupo($grupo);
//$tpl->GRUPO = $obj->get_pasta_grupo($grupo);
$pesquisa = "";
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->recuperaTotal($pesquisa,$grupo);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->listar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa,$grupo);
if (count($alist) > 0) {
foreach($alist as $key => $publicacao){
	    
    $tpl->DATA_ITEM = $obj->getData($publicacao->data);
    $tpl->TITULO_ITEM = $publicacao->titulo;
    $tpl->NOME_DOCUMENTO = $publicacao->arquivo;    
	$tpl->block("BLOCK_ITEM");
	
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

