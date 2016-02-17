<?php
$menu=4;
include("includes/lock.php");
//INSTACIA CLASSES
$obj = new Unidade();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
        $obj->conn->connection->autocommit(false);
		$obj->Alterar();
        $obj->conn->connection->commit();
        header("Location:unidade-main");
		break;
     case 'incluir' :
        $obj->conn->connection->autocommit(false);
        $obj->Incluir();
        $obj->conn->connection->commit();
        header("Location:unidade-main");
        break;
     case 'excluir' :
         $obj->conn->connection->autocommit(false);
        $obj->Excluir($_REQUEST['id']);
        $obj->conn->connection->commit();
        header("Location:unidade-main");
        break;  	
}
}

?>