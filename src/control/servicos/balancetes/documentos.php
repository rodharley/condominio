<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/servicos/documentos.html");
$tpl->addFile("INC_LATERAL_DIREITA", "view/includes/lateral_direita.html");
include("includes/montaEmpresa.php");
include("includes/formLogin.php");
include("includes/mensagem.php");
$pub = new Documento();
$tpl->GRUPO = $pub->get_pasta_grupo($pub::ID_GRUPO_BALANCETES); 
$tpl->LABEL_TITULO = $pub->get_titulo_grupo($pub::ID_GRUPO_BALANCETES);
$tpl->LABEL_ICONE = 'icone-anote';
$tpl->show();