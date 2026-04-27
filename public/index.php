<?php

require __DIR__ . '/../autoload.php';

use App\Controller\FileController;
use App\Factory\ParserFactory;

$parsers = require __DIR__ . '/../config/parsers.php';

$controller = new FileController(new ParserFactory($parsers));
$controller->index();
