<?php

class Publicacao extends Dao{
	const TABELA = 'inv_publicacao';  
    const ID_GRUPO_ANOTE = 1;
    const ID_GRUPO_PARTICIPE = 2;
    const ID_GRUPO_COLABORE = 3;
          
	var $id = NULL;
	var $titulo;
    var $conteudo;
    var $data;
    var $grupo;
	var $usuario = NULL;
    var $empresa = NULL;
    
	
    public function listaHome($grupo){
        $sql = "select u.* from ".$this::TABELA." u where idEmpresa = ".EMPRESA." and grupo = ".$grupo;
        $sql .= "  order by data desc limit 0, 3";
        return $this -> getSQL($sql);
    }
    
    public function get_pasta_grupo($id){
        switch ($id) {
            case $this::ID_GRUPO_ANOTE:
                return 'anote';
                break;
            case $this::ID_GRUPO_PARTICIPE:
                return 'participe';
                break;
            case $this::ID_GRUPO_COLABORE:
                return 'colabore';
                break;
            
            default:
                
                break;
        }
    }
    
    
    
	 function recuperaTotal($busca = "",$grupo="1") {
                $sql = "select count(id) as total from ".$this::TABELA." WHERE idEmpresa = ".EMPRESA." and grupo = ".$grupo;
        if ($busca != "")
            $sql .= " and (titulo like '$busca%')";
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }
    
    function listar($primeiro = 0, $quantidade = 9999, $busca = "",$grupo="1") {

                $sql = "select u.* from ".$this::TABELA." u where idEmpresa = ".EMPRESA." and grupo = ".$grupo;
        
        if ($busca != "")
            $sql .= " and (titulo like '$busca%')";
        $sql .= "  order by data desc limit $primeiro, $quantidade";
        return $this -> getSQL($sql);

    }
    
    
	public function alterar(){
		
        $idPub = $this->md5_decrypt($_POST['id']);
		$this->getById($idPub);
        $this->conteudo = $_POST['texto'];
        $this->data  =$this->setData($_POST['data']);
        $this->usuario = new Usuario($_SESSION['zurc.userId']);
        $this->save();
        $_SESSION['zurc.mensagem'] = 24;
		
	}
	
	public function incluir($grupo){
		$this->titulo = $_POST['descricao'];
        $this->empresa = new Empresa(EMPRESA);
        $this->usuario = new Usuario($_SESSION['zurc.userId']);
        $this->grupo = $grupo;
        $this->conteudo = $_POST['texto'];
        $this->data  =$this->setData($_POST['data']);
        
		$this->save();
		$_SESSION['zurc.mensagem'] = 23;	
	}
	
	public function excluir(){		
		$idU = 	$this->md5_Decrypt($_REQUEST['id']);
		if($this->delete($idU)){
			$_SESSION['zurc.mensagem'] = 25;
		}else{
			$_SESSION['zurc.mensagem'] = 26;
		}	
	}
}
?>