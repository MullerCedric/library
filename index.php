<?php
require 'configs/config.php';
require 'vendor/autoload.php';
require './router.php';
require 'views/layout.php';

$_SESSION['error'] = [];
unset( $_SESSION['error'] );
$_SESSION['warning'] = [];
unset( $_SESSION['warning'] );
$_SESSION['success'] = [];
unset( $_SESSION['success'] );
