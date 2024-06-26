<?php

use System\Router\Routing;

require_once "../config/app.php";
require_once "../config/database.php";

require_once "../routes/web.php";
require_once "../routes/api.php";

$routing = new Routing();
$routing->run();
