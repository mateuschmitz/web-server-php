<?php

date_default_timezone_set('America/Sao_paulo');

define('DS', DIRECTORY_SEPARATOR);

require_once("src" . DS . "Server.php");

(new Server)->startServer();