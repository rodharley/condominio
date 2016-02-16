<?php
//MONTAGEM DO MENU
$menuob = new Menu();
$listaMenu = $menuob->recuperaMenus(null,$_SESSION['zurc.menu']);
foreach ($listaMenu as $key => $menu1) {
	$tpl->CLASS_MENU = "";
	$tpl->MENU_SETA = "";
    $tpl->ACTIVE_MENU = "";
    $tpl->ACTIVE_SUB_MENU = "";	
	if($menu1->url != ""){
		$tpl->DESC_MENU = $menu1->nome;
		$tpl->URL_MENU = $menu1->url;
		$tpl->ICON_MENU = $menu1->icone;
        $tpl->ACTIVE_MENU = $menu1->id == $menu ? "active" : "";		
	}else{
		$tpl->ACTIVE_MENU = $menu1->id == $menu ? "active" : "";    
		$tpl->DESC_MENU = $menu1->nome;
		$tpl->ICON_MENU = $menu1->icone;
		$tpl->CLASS_MENU = "treeview";
		$tpl->MENU_SETA = '<i class="fa fa-angle-left pull-right"></i>';
		$subs = $menuob->recuperaMenus($menu1->id,$_SESSION['zurc.menu']);
        $tpl->ACTIVE_SUB_MENU = "";
		foreach ($subs as $key2 => $submenu) {
			$tpl->DESC_SUBMENU = $submenu->nome;
			$tpl->URL_SUBMENU = $submenu->url;		
            $tpl->ACTIVE_SUB_MENU = $submenu->id == $menu ? "active" : "";
            $tpl->ACTIVE_MENU = $submenu->id == $menu ? "active" : "";
			$tpl->block("BLOCK_SUBMENU");
		}		
		$tpl->block("BLOCK_MENU_DROPDOWN");
	}
	$tpl->block("BLOCK_MENU");
}

?>