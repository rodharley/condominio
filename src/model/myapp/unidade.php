<?php

class Unidade extends Dao{
	const TABELA = 'inv_unidade';  
    var $id = NULL;
	var $descricao;	
    var $empresa;
	
    
    function recuperaTotal($busca = "") {
                $sql = "select count(id) as total from ".$this::TABELA." WHERE idEmpresa = ".EMPRESA;
        if ($busca != "")
            $sql .= " and (descricao like '$busca%')";
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }
    
    function listar($primeiro = 0, $quantidade = 9999, $busca = "") {

                $sql = "select u.* from ".$this::TABELA." u where idEmpresa = ".EMPRESA;
        
        if ($busca != "")
            $sql .= " and (descricao like '$busca%')";
        $sql .= "  order by descricao limit $primeiro, $quantidade";
        return $this -> getSQL($sql);

    }
    
    public function Alterar(){
        $id = $this->md5_decrypt($_POST['id']);
        $this->getById($id);
        $this->descricao = $_POST['descricao'];
        $this->save();
        
        $_SESSION['zurc.mensagem'] = 19;
    }
    
    public function incluir(){
        $this->descricao = $_POST['descricao'];
        $this->empresa = new Empresa(EMPRESA);
        $this->save();
        $_SESSION['zurc.mensagem'] = 20;    
    }
    
    public function excluir(){
        $id =  $this->md5_Decrypt($_REQUEST['id']);
        $olc = new usuario();
        $qtc = $olc->getNumRows(array("unidade"=>" = ".$id));
        if($qtc == 0){
            $this->delete($id);
            $_SESSION['zurc.mensagem'] = 22;
        }else{
            $_SESSION['zurc.mensagem'] = 21;
        }   
    }
}
?>