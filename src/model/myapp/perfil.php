<?php

class Perfil extends Dao{
	const TABELA = 'inv_perfil';  
    const SINDICO = 1;
          
	var $id = NULL;
	var $descricao;
	var $empresa = Null;
	public function recuperaTotal(){
		$rs = $this->DAO_ExecutarQuery("select count(id) as total from ".$this::TABELA." where idEmpresa = ".EMPRESA);	
		return $this->DAO_Result($rs,"total",0);
	}
	
	public function alterar(){
		$oAcesso = new Permissao();
        $idperfil = $this->md5_decrypt($_POST['id']);
		$this->getById($idperfil);
		$this->descricao = $_POST['descricao'];
		$this->save();
		$oAcesso->limparAcessos($idperfil);
		foreach ($_REQUEST['menus'] as $key => $valor){
		$oAc = new Permissao();
		$m = new Menu();
		$m->id = $valor;
		$oAc->menu = $m;
		$oAc->perfil = $this;
		$oAc->save();	
		}
		$_SESSION['zurc.mensagem'] = 15;
	}
	
	public function incluir(){
		$this->descricao = $_POST['descricao'];
        $this->empresa = new Empresa(EMPRESA);
		$this->save();
		foreach ($_REQUEST['menus'] as $key => $valor){
		$oAc = new Permissao();
		$m = new Menu();
		$m->id = $valor;
		$oAc->menu = $m;
		$oAc->perfil = $this;
		$oAc->save();	
		}
		$_SESSION['zurc.mensagem'] = 16;	
	}
	
	public function excluir(){
		$oAcesso = new Permissao();
		$idU = 	$this->md5_Decrypt($_REQUEST['id']);
		$olc = new usuario();
		$qtc = $olc->getNumRows(array("perfil"=>" = ".$idU));
		if($qtc == 0){
			$oAcesso->limparAcessos($idU);
			$this->delete($idU);
			$_SESSION['zurc.mensagem'] = 18;
		}else{
			$_SESSION['zurc.mensagem'] = 17;
		}	
	}
}
?>