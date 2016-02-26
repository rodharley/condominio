<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/publicacao/detalhe.html");
$tpl->addFile("INC_LATERAL_DIREITA", "view/includes/lateral_direita.html");
include("includes/montaEmpresa.php");
include("includes/mensagem.php");
$pub = new Publicacao();
$pub->getById($pub->md5_decrypt($_REQUEST['id']));

$tpl->GRUPO = $pub->get_pasta_grupo($pub->grupo);
$tpl->TITULO = $pub->titulo;
$tpl->CONTEUDO = $pub->conteudo;
$tpl->DATA = $pub->getData($pub->data);
$tpl->USER_ITEM = $pub->usuario->nome;
    $tpl->FOTO_ITEM = $pub->usuario->foto;
 
$tpl->LABEL_TITULO = $pub->get_titulo_grupo($pub->grupo);
$tpl->LABEL_ICONE = $pub->get_icone_grupo($pub->grupo);
$tpl->show();