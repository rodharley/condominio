<?php
if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'login' :
            $ob = new Usuario();
            if ($ob -> login($_REQUEST['email'], $_REQUEST['senha']))
              header("Location: home-home");
            else
                header("Location:" . MAIN_CONTROLE);
            break;
        case 'recupera' :
             $ob = new Usuario();
            $ob->EnviarSenha($_REQUEST['email']);
            header("Location:" . MAIN_CONTROLE);
            break;
        case 'registro' :
            $ob = new Usuario();
            $ob->conn->connection->autocommit(false);
            if($ob->registrarNovo()){
            $ob->conn->connection->commit();
            header("Location: index-login");
            }else{
            $ob->conn->connection->rollback();
            header("Location: index-registro");
            }
            break;
        case 'ativar' :
            $ob = new Usuario();
            if($ob->ativar())
                header("Location: home-home");
            else
                header("Location: index-login");
            break;
        default :
            break;
    }

}
exit();
