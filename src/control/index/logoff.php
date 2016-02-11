<?php
$ob = new Usuario();
$ob->LogOff();
header("Location:".MAIN_CONTROLE);
exit();