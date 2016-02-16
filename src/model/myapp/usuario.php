<?php
class Usuario extends Dao {
	const TABELA = 'inv_usuario';
	var $perfil = NULL;	
	var $senha;
	var $ativo;
	var $nome;
	var $email;	
	var $foto;
    var $dataCadastro;
    var $empresa = NULL;
	function LogOff() {
		
		//grava a log
		$log = new Log();
		$log->gerarLog("Sair do Sistema");
		unset($_SESSION['zurc.userId']);
		unset($_SESSION['zurc.userNome']);
		unset($_SESSION['zurc.userFoto']);
		unset($_SESSION['zurc.userPerfil']);
		unset($_SESSION['zurc.userPerfilId']);
		unset($_SESSION['zurc.menu']);
        unset($_SESSION['start']);
        unset($_SESSION['expire']);
         session_destroy();
	}

	function recuperaTotal($busca = "",$perfil = "") {
				$sql = "select count(id) as total from ".$this::TABELA." WHERE 1 = 1 ";
		if ($busca != "")
			$sql .= " and (nome like '$busca%')";
        if($perfil != "")
        $sql .= " and (idPerfil = $perfil)";
		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}


	function recuperaTotalPerfil($idPerfil, $busca = "") {
		
				$sql = "select count(id) as total from ".$this::TABELA." WHERE idPerfil = $idPerfil";
		
		if ($busca != "")
			$sql .= " and (nome like '$busca%')";

		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}
	
	function listarUsuariosPerfil($idPerfil, $primeiro = 0, $quantidade = 9999, $busca = "") {

		
				$sql = "select u.* from ".$this::TABELA." u where u.idPerfil = $idPerfil";
		
		if ($busca != "")
			$sql .= " and (nome like '$busca%')";

		$sql .= "  order by nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	function listarUsuarios($primeiro = 0, $quantidade = 9999, $busca = "", $perfil = "") {

				$sql = "select u.* from ".$this::TABELA." u where 1 = 1";
		
		if ($busca != "")
			$sql .= " and (nome like '$busca%')";
        if($perfil != "")
        $sql .= " and (idPerfil = $perfil)";
		$sql .= "  order by nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	
	function login($login, $senha) {
			
		
		
		if ($this ->recuperaPorLogin($login)) {
			    
			if ($this -> ativo == 1) {
				if ($this -> senha == md5($senha)) {
					$_SESSION['zurc.userId'] = $this -> id;
					$_SESSION['zurc.userNome'] = $this ->nome;
					$_SESSION['zurc.userPerfil'] = $this -> perfil -> descricao;
					$_SESSION['zurc.userFoto'] = $this ->foto;
					$_SESSION['zurc.userPerfilId'] = $this -> perfil -> id;		
					$_SESSION['start'] = time(); // Taking now logged in time.
                        // Ending a session in 30 minutes from the starting time.
                    $_SESSION['expire'] = $_SESSION['start'] + (1800);			
					//grava a log
				$log = new Log();
                
				$log->gerarLog("Entrou no Sistema");
					
                    
					//carrega os itens de menu do perfil
					$a = new Permissao();                    
					$lista = $a -> recuperaMenuAcessos($this -> perfil -> id);	
                    			
					$_SESSION['zurc.menu'] = "0";					
					foreach ($lista as $key => $acesso) {					    
						$_SESSION['zurc.menu'] .= "," . $acesso -> menu -> id;
					}
					return true;
				} else {
					
					//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, senha inválida");
					
					Message::setMensagem(2);
					return false;
				}
			} else {
				//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, usuário inativo");
				
				Message::setMensagem(10);
				return false;
			}
		} else {
			//login invalido
			//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, Login inválido");
			
			Message::setMensagem(1);
			return false;
		}

	}

	function EnviarSenha($email) {
		if ($this->recuperaPorLogin($email)) {
			
				$senha = $this -> makePassword(8);
				$this -> senha = md5($senha);         
				$objEmail = new Email();
				if ($objEmail->enviarEmailNovaSenha($this->nome,$this->email,$senha)) {
					$this -> save();
					Message::setMensagem(9);
				} else {
					Message::setMensagem(31);
				}
			

		} else {
			Message::setMensagem(1);
		}
	}


	function recuperaPorLogin($login, $idExclusao = "0") {
	    $sql = "select u.* from ".$this::TABELA." u where email = '$login' and id != $idExclusao";
	    $rs = $this->getSQL($sql);
        if(count($rs) > 0){
	       $this->getById($rs[0]->id);		
			return true;
		}else
			return false;
	}
    
   
    
	function Excluir($id) {
	    $this->getById($this -> md5_decrypt($id));
		if($this -> delete($this->id))
		$_SESSION['zurc.mensagem'] = 8;
        else
        $_SESSION['zurc.mensagem'] = 17;		
		exit();
	}

	function Salvar() {
		if($_REQUEST['id'] != ""){
			$this -> getById($_REQUEST['id']);
			
		}else{
			$this -> ativo = 0;
			$this -> senha = "";
		}
				
		$this->nome = $_REQUEST['nome'];
		$this->email = $_REQUEST['email'];
		$p = new Perfil();
		$p -> id = $_REQUEST['perfil'];
		$this -> perfil = $p;
				
		
		if ($_FILES['foto']['name'] != "") {
			//incluir imagem se ouver
			$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/users/");
			$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/users/");
			$this -> foto = $nomefoto;
		}	
        
		$this -> save();      
		       
        $email = new Email();
        $email->enviarEmailNovoUsuario($this->pessoa->nome,$this->pessoa->email,$this->id);
		$_SESSION['zurc.mensagem'] = 4;		

	}

	


	

	


	function AlterarMeusDados() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		if ($this -> recuperaPorLogin($_REQUEST['email'], $_SESSION['zurc.userId'])) {
			$_SESSION['zurc.mensagem'] = 3;
			
		} else {
			$this -> getById($_SESSION['zurc.userId']);
			$this -> pessoa-> nome = $_REQUEST['nome'];
			$this -> pessoa->cpf = $strCPF;
			$this -> pessoa->email = $_REQUEST['email'];
			$this -> pessoa -> telResidencial = str_replace("_","",$_REQUEST['telefone']);
            $this -> pessoa -> telCelular = str_replace("_","",$_REQUEST['celular']);
			if ($_REQUEST['senha'] != "")
				$this -> senha = md5($_REQUEST['senha']);

			//incluir imagem se ouver
			if ($_FILES['foto']['name'] != "") {
				if ($this -> pessoa -> foto != "pessoa.png")
					$this -> apagaImagem($this -> pessoa ->  foto, "img/pessoas/");
				$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
				$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
				$this ->  pessoa -> foto = $nomefoto;
			}
			
            $this->pessoa->Save();
			$this -> save();
			$_SESSION['zurc.mensagem'] = 5;
			header("Location:admin_home-home");
			exit();
		}
	}

	
    public function apagaPermissoes(){
        $SQL = "delete from fmj_permissao where idUsuario = ".$this->id;
        $this->DAO_ExecutarDelete($SQL);
    }
    
    public function salvaPermissoes($permissoes){
        $arrayP = explode(",", $permissoes);
        foreach ($arrayP as $key => $value) {
            $p = new Permissao();
            $p->usuario = $this;
            $p->academia = new Academia($value);
            $p->save();
        }
    }
    function loginMd5($param1, $param2) {
            
       $login = $this->md5_decrypt($param1);
       $senha = $this->md5_decrypt($param2);
        
        if ($this -> recuperaPorLogin($login)) {
            if ($this -> ativo == 1) {
                if ($this -> senha == $senha) {
                    $_SESSION['zurc.userId'] = $this -> id;
                    $_SESSION['zurc.userNome'] = $this -> nome;
                    $_SESSION['zurc.userPerfil'] = $this -> perfil -> descricao;
                    $_SESSION['zurc.userFoto'] = $this -> foto;
                    $_SESSION['zurc.userPerfilId'] = $this -> perfil -> id;                  
                    //grava a log
                $log = new Log();
                
                $log->gerarLog("Entrou no Sistema através de link de email.");
                    
                    //carrega os itens de menu do perfil
                    $a = new Acesso();
                    $lista = $a -> recuperaMenuAcessos($this -> perfil -> id);
                    $_SESSION['zurc.menu'] = "0";
                    foreach ($lista as $key => $acesso) {
                        $_SESSION['zurc.menu'] .= "," . $acesso -> menu -> id;
                    }
                    return true;
                } else {
                    
                    //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, senha inválida");
                    
                    $_SESSION['zurc.mensagem'] = 2;
                    return false;
                }
            } else {
                //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, usuário inativo");
                
                $_SESSION['zurc.mensagem'] = 12;
                return false;
            }
        } else {
            //login invalido
            //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, Login inválido");
            
            $_SESSION['zurc.mensagem'] = 1;
            return false;
        }

    }

public function registrarNovo(){
    $emp = new Empresa();
    $emp->nomeFantasia = $_REQUEST['empresa'];
    $emp->cnpj = $this->limpaDigitos($_REQUEST['cnpj']);
    $idEmpresa = $emp->save();
    $this->nome = $_REQUEST['nome'];
    $this->ativo = 0;
    $this->senha = "";
    $this->perfil = new Perfil(1);
    $this->empresa = $emp;
    $this->email = $_REQUEST['email'];
    $this->foto = "user.png";
    $this->dataCadastro = date("Y-m-d");
    $this->save();
    $email = new Email();
    if($email->enviarEmailNovoUsuario($this->nome,$this->email,$this->id)){
        Message::setMensagem(14);
        return true;
    }else{    
    Message::setMensagem(31);
    return false;
    }
    
}

public function ativar(){
    if(isset($_POST['id'])){
    $idUser = $this->md5_decrypt($_REQUEST['id']);
    $this->getById($idUser);
    if($this->id != null){
        if($this->ativo == "0"){
            $this->ativo = 1;
            $this->senha = md5($_REQUEST['senha']);
            $this->save();
            Message::setMensagem(12);
            $this->login($this->email, $_POST['senha']);
            return true;
        }else{
        Message::setMensagem(11);
        return false;
        }
    }else{
        Message::setMensagem(1);
        return false;
    }
}else{
    Message::setMensagem(1);
        return false;
}
}

}
?>