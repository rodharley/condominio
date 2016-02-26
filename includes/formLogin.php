<?php
$unidade = new Unidade();
$rs = $unidade->getRows();
foreach ($rs as $key => $uni) {
    $tpl->ID_UNIDADE = $uni->id;
    $tpl->LABEL_UNIDADE = $uni->descricao;
    $tpl->block("BLOCK_UNIDADE");
}