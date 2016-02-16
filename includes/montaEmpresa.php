<?php
//MONTAGEM DO MENU
if(EMPRESA != ""){
    $objEmpresa = new Empresa();
    $objEmpresa->getById(EMPRESA);
    $tpl->EMPRESA_NOME = $objEmpresa->nomeFantasia;
    $tpl->EMPRESA_LOGO = $objEmpresa->logomarca;
    $tpl->EMPRESA_ENDERECO = $objEmpresa->endereco;    
}