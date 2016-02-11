<?php
if(isset($_SESSION['zurc.menu'])){
$tpl->LOGIN_NAME = $_SESSION['zurc.userNome'];
    $tpl->LOGIN_IMG = $_SESSION['zurc.userFoto'];
    $tpl->LOGIN_PERFIL = $_SESSION['zurc.userPerfil'];
}
?>