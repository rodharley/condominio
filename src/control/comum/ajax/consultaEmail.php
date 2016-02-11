<?php
$obUsuario = new Usuario();
    $login = $_REQUEST['email'];
    $id = isset($_REQUEST['idUser']) ? $_REQUEST['idUser'] : "0";
    $tipo = $_REQUEST['tipo'];
    $obUsuario->recuperaPorLogin($login,$id);
    if($obUsuario->id != null)
    echo json_encode ($tipo==0?false:true); //Return the JSON Array
    else
    echo json_encode ($tipo==0?true:false); //Return the JSON Array