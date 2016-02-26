<?php
$tpl = new Template("view/templates/blank_page.html");
$tpl->addFile("CONTENT", "view/publicacao/posts.html");
$tpl->addFile("INC_LATERAL_DIREITA", "view/includes/lateral_direita.html");
include("includes/montaEmpresa.php");
include("includes/mensagem.php");
$pub = new Publicacao();
$tpl->GRUPO = $pub->get_pasta_grupo($pub::ID_GRUPO_ANOTE); 
$tpl->LABEL_TITULO = $pub->get_titulo_grupo($pub::ID_GRUPO_ANOTE);
$tpl->LABEL_ICONE = $pub->get_Icone_grupo($pub::ID_GRUPO_ANOTE);
$tpl->show();