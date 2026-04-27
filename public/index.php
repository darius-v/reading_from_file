<?php

require __DIR__ . '/../autoload.php';

use App\Controller\FileController;
use App\Factory\ParserFactory;
use App\Validator\FileValidator;

$parsers   = require __DIR__ . '/../config/parsers.php';
$factory   = new ParserFactory($parsers);
$validator = new FileValidator($factory);

$controller = new FileController($factory, $validator);
$controller->index();
