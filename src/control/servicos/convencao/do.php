<?php
$menu=10;
include("includes/lock.php");
//INSTACIA CLASSES
$obj = new Documento();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
        $obj->conn->connection->autocommit(false);
		$obj->Alterar();
        $obj->conn->connection->commit();
        
		break;
     case 'incluir' :
        $obj->conn->connection->autocommit(false);
        $obj->Incluir($obj::ID_GRUPO_CONVENCAO);
        $obj->conn->connection->commit();
        
        break;
     case 'excluir' :
         $obj->conn->connection->autocommit(false);
        $obj->Excluir($_REQUEST['id']);
        $obj->conn->connection->commit();
        
        break;  	
}
header("Location:servicos-convencao-main");
}

?>