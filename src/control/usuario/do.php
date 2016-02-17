<?php
$menu=3;
include("includes/lock.php");
//INSTACIA CLASSES
$obj = new Usuario();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
        $obj->conn->connection->autocommit(false);
		$obj->Salvar();
        $obj->conn->connection->commit();
        header("Location:usuario-main");
		break;
     case 'meus' :
        $obj->conn->connection->autocommit(false);
        $obj->AlterarMeusDados();
        $obj->conn->connection->commit();
        header("Location:usuario-meusDados");
        break;
     case 'incluir' :
        $obj->conn->connection->autocommit(false);
        $obj->Salvar();
        $obj->conn->connection->commit();
        header("Location:usuario-main");
        break;
     case 'excluir' :
         $obj->conn->connection->autocommit(false);
        $obj->Excluir($_REQUEST['id']);
        $obj->conn->connection->commit();
        header("Location:usuario-main");
        break;  	
}
}

?>