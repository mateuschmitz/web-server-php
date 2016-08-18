<?php

/**
 * @author Mateus Schmitz <matteuschmitz@gmail.com>
 */

date_default_timezone_set('America/Sao_paulo');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', 'www');

require_once("src" . DS . "Server.php");

(new Server)->startServer();