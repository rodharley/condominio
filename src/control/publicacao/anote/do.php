<?php
$menu=6;
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
        header("Location:publicacao-anote-main");
		break;
     case 'incluir' :
        $obj->conn->connection->autocommit(false);
        $obj->Incluir($obj::ID_GRUPO_ANOTE);
        $obj->conn->connection->commit();
        header("Location:publicacao-anote-main");
        break;
     case 'excluir' :
         $obj->conn->connection->autocommit(false);
        $obj->Excluir($_REQUEST['id']);
        $obj->conn->connection->commit();
        header("Location:publicacao-anote-main");
        break;  	
}
}

?>