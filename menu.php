<?php

if($_SESSION['stfcat'] == 1 ){
	include('menu_admin.php');
}elseif ($_SESSION['stfcat'] == 2) {
	include('menu_mngr.php');
}else{
	include('menu_front.php');
} ?>
