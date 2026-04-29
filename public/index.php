<?php

require __DIR__ . '/../autoload.php';

use App\Controller\FileController;
use App\Factory\ParserFactory;
use App\Http\Request;
use App\Parser\ParserDiscovery;
use App\Validator\FileValidator;

$discovery = new ParserDiscovery(__DIR__ . '/../src/Parser', 'App\\Parser');
$factory   = new ParserFactory($discovery);
$validator = new FileValidator($factory);
$request   = Request::fromGlobals();

$controller = new FileController($factory, $validator, $request);
$controller->index();
