<?php
require 'configs/config.php';
require 'vendor/autoload.php';
require './router.php';
/* vérifier si api ou page pour savoir si l'on inclu le layout ou si on echo juste le json */
require 'views/layout.php';