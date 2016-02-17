<?php
$menu = 3;
//INSTACIA CLASSES
$usu = new Usuario();
$perfil = new Perfil();
//verificar se perfil selecionado
$tpl = new Template("view/usuario/list.html");
$pesquisa = isset($_REQUEST['pesquisa']) ? $_REQUEST['pesquisa'] : "";
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$idperfil = isset($_REQUEST['perfil']) ? $_REQUEST['perfil'] : "";
$totalPesquisa = $usu->recuperaTotal($pesquisa,$idperfil);
$configPaginacao = $usu->paginar($totalPesquisa,$pagina);
$alist = $usu->listarUsuarios($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa,$idperfil);
if (count($alist) > 0) {
foreach($alist as $key => $usuario){
	$tpl->nome = $usuario->nome;
	$tpl->perfil = $usuario->perfil->descricao;
	$tpl->situacao = $usuario->ativo == 1 ? "Ativo" : "Inativo";
	$tpl->ID_HASH = $usu->md5_encrypt($usuario->id);
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

