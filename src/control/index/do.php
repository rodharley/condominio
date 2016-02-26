<?php
if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'login' :
            $ob = new Usuario();
            if ($ob -> login($_REQUEST['login-usuario'], $_REQUEST['login-senha']))
              header("Location: home-home");
            else
                header("Location:" . MAIN_CONTROLE);
            break;
        case 'recupera' :
             $ob = new Usuario();
             $ob->conn->connection->autocommit(false);
            $ob->EnviarSenha($_REQUEST['email']);
            $ob->conn->connection->commit();
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
                header("Location: index-home");
            break;
        default :
            break;
    }

}
exit();
