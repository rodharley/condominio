<?php
    echo '<option value="">Selecione</option>';
$obUsuario = new Usuario();
if(isset($_REQUEST['idUnidade']) && strlen($_REQUEST['idUnidade']) > 0 ){
 $rs = $obUsuario->recuperaUsuariosPorUnidade($_REQUEST['idUnidade']);
 foreach ($rs as $key => $uni) {
     echo '<option value="'.$uni->id.'">'.$uni->nome.'</option>';
     
 }
}