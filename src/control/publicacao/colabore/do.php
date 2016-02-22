<?php
$menu=7;
include("includes/lock.php");
//INSTACIA CLASSES
$obj = new Publicacao();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
        $obj->conn->connection->autocommit(false);
		$obj->Alterar();
        $obj->conn->connection->commit();
        header("Location:publicacao-colabore-main");
		break;
     case 'incluir' :
        $obj->conn->connection->autocommit(false);
        $obj->Incluir($obj::ID_GRUPO_COLABORE);
        $obj->conn->connection->commit();
        header("Location:publicacao-colabore-main");
        break;
     case 'excluir' :
         $obj->conn->connection->autocommit(false);
        $obj->Excluir($_REQUEST['id']);
        $obj->conn->connection->commit();
        header("Location:publicacao-colabore-main");
        break;  	
}
}

?>