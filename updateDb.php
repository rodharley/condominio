<?php
try {
require_once("src/config/constants.php");
require_once "zurc.php";
//include("includes/lock.php");
$zurc = new Zurc();
$zurc->loadClass();
$tpl = new Template("view/templates/blank_bootstrap_lteadmin.html");
if(isset($_REQUEST['tabela']) && count($_REQUEST['tabela'] > 0)){    
$zurc->updateDb();
Message::setMensagem(35);
}
include_once("includes/mensagem.php");
$tpl->addFile("CONTENT", "view/architecture/updateDb.html");
$xml = simplexml_load_file(URI."/src/config/dao.xml");        
        foreach ($xml->class as $class) {
            $tpl->nome_tabela = $class['name'];
            $tpl->block("block_tabela");
        }            
$tpl->show();

}catch(Exception $e){
echo $e->getCode()."-".$e->getMessage();
} 