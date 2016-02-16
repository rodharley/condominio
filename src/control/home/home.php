<?php
$menu=0;
include("includes/lock.php");
$tpl = new Template("view/templates/default_bootstrap_lteadmin.html");
$tpl->addFile("CONTENT", "view/home/home.html");
include("includes/config.php");
$tpl->show();
