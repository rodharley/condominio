<?php
class Acesso extends Dao{
    const TABELA = 'inv_permissao';
	var $menu = NULL;
	var $perfil = NULL;
	
	
	function limparAcessos($idPerfil){
	$sql = "delete from ".$this::TABELA." where idPerfil = ".$idPerfil;
	$this->DAO_ExecutarQuery($sql);
	return true; 	
	}
	
	public function recuperaMenuAcessos($idPerfil){
	$sql = "select * from ".$this::TABELA." where idPerfil = ".$idPerfil;    
	return $this->getSQL($sql);		
		
	}
	
}
?>