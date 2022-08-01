<?php 

require 'config.php';

$_SESSION['token'] = '';
header('Location: '.$base.'/home.php');
exit;
