<?php
if(!isset($_SESSION['zurc.menu'])){
	//Message::setMensagem(6);
	header("Location:index-home");
	exit();
}

$armenus = explode(",",$_SESSION['zurc.menu']);
if(!in_array($menu, $armenus)){
	Message::setMensagem(7);	
	header("Location:index-home");
	exit();
}
$now = time();
if ($now > $_SESSION['expire']) {    
    session_destroy();  
    session_start();
    //Message::setMensagem(34);    
    header("Location:index-home");

}else{
    $_SESSION['start'] = time(); // Taking now logged in time.
    $_SESSION['expire'] = $_SESSION['start'] + (1800);
    
}
?>