<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/index/registro.html");
$tpl->addFile("INC_LATERAL_DIREITA", "view/includes/lateral_direita.html");
include("includes/montaEmpresa.php");
include("includes/formLogin.php");
include("includes/mensagem.php");

$unidade = new Unidade();
$rs = $unidade->getRows();
foreach ($rs as $key => $uni) {
    $tpl->LABEL_UNIDADE_CAD = $uni->descricao;
    $tpl->block("BLOCK_UNIDADE_CADASTRO");
}
$tpl->show();
