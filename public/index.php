<?php

require __DIR__ . '/../autoload.php';

use App\Controller\FileController;

$controller = new FileController();
$controller->index();
