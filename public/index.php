<?php

require __DIR__ . '/../autoload.php';

use App\Controller\FileController;
use App\Factory\ParserFactory;
use App\Parser\ParserDiscovery;
use App\Validator\FileValidator;

$discovery = new ParserDiscovery(__DIR__ . '/../src/Parser', 'App\\Parser');
$factory   = new ParserFactory($discovery->discover());
$validator = new FileValidator($factory);

$controller = new FileController($factory, $validator);
$controller->index();
