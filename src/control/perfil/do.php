<?php
$menu=2;
include("includes/lock.php");
//INSTACIA CLASSES
$perfil = new Perfil();
//ACOES
if(isset($_REQUEST['acao'])){
switch ($_REQUEST['acao']){
	case 'editar' :
        $perfil->conn->connection->autocommit(false);
		$perfil->Alterar();
        $perfil->conn->connection->commit();
        header("Location:perfil-main");
		break;
     case 'incluir' :
        $perfil->conn->connection->autocommit(false);
        $perfil->Incluir();
        $perfil->conn->connection->commit();
        header("Location:perfil-main");
        break;
     case 'excluir' :
         $perfil->conn->connection->autocommit(false);
        $perfil->Excluir($_REQUEST['id']);
        $perfil->conn->connection->commit();
        header("Location:perfil-main");
        break;  	
}
}

?>