<?php
/*BASE DA DADOS MYSQL */
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'condominio');


 
 /* PARAMENTROS DE DESENVOLVEDOR */
define('DESENVOLVIMENTO', true);//MOSTRA ERROS COMPLETOS
define('BD', true); //recria tabelas no banco de dados;

/*VARIAVEIS DE CONFIGURAÇÃO DOS DIRETORIOS DO SISTEMA */
define("PASTA","condominio");
define('URI',$_SERVER['DOCUMENT_ROOT'].PASTA);
define('URL','http://'.$_SERVER['HTTP_HOST'].'/'.PASTA);
define("MAIN_CONTROLE","home-home");

/* EMAIL DE REMENTENTE DO SISTEMA */
define('REMETENTE','Rodrigo Cruz<rodrigo@azcontrol.com.br>');   