<?php
class Message

{
	
        
	var $id = NULL;
	var $mensagem;
	var $tipo;
	
	
	
	
	function getMensagem($id){
	$xml = simplexml_load_file(URI."/src/config/messages.xml");
		foreach ($xml->children() as $elemento){			
			
			if($elemento['id'] == $id){			
				$this->id = $id;
				$this->tipo = $elemento['type'];
				$strmsg = $elemento[0];
				if(isset($_SESSION['zurc.param1'])){
					$strmsg = str_replace("{param1}",$_SESSION['zurc.param1'],$strmsg);
					unset($_SESSION['zurc.param1']);
				}
				if(isset($_SESSION['zurc.param2'])){
					$strmsg = str_replace("{param2}",$_SESSION['zurc.param2'],$strmsg);
					unset($_SESSION['zurc.param2']);
				}
				if(isset($_SESSION['zurc.param3'])){
					$strmsg = str_replace("{param3}",$_SESSION['zurc.param3'],$strmsg);
					unset($_SESSION['zurc.param3']);
				}
				$this->mensagem = utf8_decode($strmsg);
			}
		}
	}
	
	function echoMensagem(){
	$this->getMensagem($_SESSION['zurc.mensagem']);
	$strReturn = "";
	$tipo = $this->tipo;
	
	switch($tipo){
		case 'success':
		$strReturn =  '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Sucesso!</b> '.$this->mensagem.'</div>';
		break;
		case 'danger':
		$strReturn =  '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Erro!</b> '.$this->mensagem.'</div>';
		break;
		case 'warning':
		$strReturn =  '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Aviso!</b> '.$this->mensagem.'</div>';
		break;
		default :
		$strReturn =  '<div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>informação!</b> '.$this->mensagem.'</div>';
		break;
	}
	
	return $strReturn;
	}
	
                                    
    public static function setMensagem($id,$param1 = null,$param2= null,$param3= null){
    $_SESSION['zurc.mensagem'] = $id;
    if($param1 != null)
        $_SESSION['zurc.param1'] = $param1;
    if($param2 != null)
        $_SESSION['zurc.param2'] = $param2;
    if($param3 != null)
        $_SESSION['zurc.param3'] = $param3;
}

public static function unSetMensagem(){
     unset($_SESSION['zurc.mensagem']);
     unset($_SESSION['zurc.param1']);
     unset($_SESSION['zurc.param2']);
     unset($_SESSION['zurc.param3']);
}                                
                                    

}
