<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.iso-8859-1', 'portuguese');
header('Content-Type: text/html; charset=iso-8859-1');
//setando a funcao de tratamento de erros geral
function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler('handleError',E_ALL);
try{
require_once("src/config/constants.php");
require_once "zurc.php";
$zurc = new Zurc();
$zurc->loadClass();
$zurc->start();
$zurc->controllers();
$zurc->end();

}catch(Exception $e){
    echo $e->getMessage();
    echo "br/>".$_SERVER['DOCUMENT_ROOT'];
   /* $tpl = new Template("view/templates/blank_bootstrap_lteadmin.html");
    $tpl->addFile("CONTENT", "view/padrao/erro.html");
    $tpl->error_code = $e->getCode();
    $tpl->error_message = $e->getMessage();
    $tpl->show();
*/
}
?>