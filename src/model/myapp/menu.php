<?php
class Menu extends Dao {
    const TABELA = 'inv_menu';
	var $nome;
	var $url;
	var $menuPai = NULL;
	var $ordem;
	var $subMenus;
	var $icone;

public function recuperaMenus($superior = null,$validos){
	if($superior != null)
		$sql = "select * from ".$this::TABELA." where idMenuPai = $superior and id in($validos) order by ordem";
	else
		$sql = "select * from ".$this::TABELA." where idMenuPai is null and id in($validos) order by ordem";
	return $this->getSQL($sql);				
	}


public function recuperaMenusCompletos($idMenuPai = 0){
	if($idMenuPai != null)
		$sql = "select * from ".$this::TABELA." where idMenuPai = $idMenuPai order by ordem";
	else
		$sql = "select * from ".$this::TABELA." where idMenuPai is null order by ordem";
	return $this->getSQL($sql);				
	}

}
?>