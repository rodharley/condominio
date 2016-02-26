<?php
$menu = 6;
//INSTACIA CLASSES
$obj = new Publicacao();
$grupo = $obj::ID_GRUPO_COLABORE;

$tpl = new Template("view/publicacao/portal_list.html");

//$tpl->GRUPO = $obj->get_pasta_grupo($grupo);

$pesquisa = "";
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->recuperaTotal($pesquisa,$grupo);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->listar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa,$grupo);
if (count($alist) > 0) {
foreach($alist as $key => $publicacao){
	 $tpl->ID_PUB = $obj->md5_encrypt($publicacao->id);   
    $tpl->DATA_ITEM = $obj->getData($publicacao->data);
    $tpl->TITULO_ITEM = $publicacao->titulo;
    $tpl->USER_ITEM = $publicacao->usuario->nome;
    $tpl->FOTO_ITEM = $publicacao->usuario->foto;
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

