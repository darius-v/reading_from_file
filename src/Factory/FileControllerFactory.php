<?php

namespace App\Factory;

use App\Controller\FileController;
use App\Http\Request;
use App\Parser\ParserDiscovery;
use App\Service\FileUploadService;
use App\Validator\FileValidator;

/**
 * Wires up and returns a fully configured FileController.
 */
class FileControllerFactory
{
    /**
     * @return FileController
     */
    public static function create(): FileController
    {
        $discovery = new ParserDiscovery(__DIR__ . '/../Parser/Format', 'App\\Parser\\Format');
        $factory   = new ParserFactory($discovery);
        $validator = new FileValidator($factory);
        $service   = new FileUploadService($validator, $factory);
        $request   = Request::fromGlobals();

        return new FileController($service, $request);
    }
}
