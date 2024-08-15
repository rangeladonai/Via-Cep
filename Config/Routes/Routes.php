<?php
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

SimpleRouter::get('/', [\ViaCep\Src\Controller\HomeController::class, 'Home']);
SimpleRouter::post('/save/cep/json', [\ViaCep\Src\Controller\ZipCodeController::class, 'SaveCepJsonFile']);

SimpleRouter::start();