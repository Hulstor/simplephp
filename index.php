<?php

/**
 * PHP Version 7.2
 *
 * Front Controller
 */

use Utilities\Context;
use Utilities\Site;

require __DIR__ . '/vendor/autoload.php';
session_start();

try {

    Site::configure();


    $pageRequest = Site::getPageRequest();


    if (!class_exists($pageRequest)) {
        throw new \Exception("Página no encontrada o clase inválida: {$pageRequest}", 404);
    }


    $instance = new $pageRequest();
    $instance->run();
    exit;
} catch (\Controllers\PrivateNoAuthException $ex) {

    $instance = new \Controllers\NoAuth();
    $instance->run();
    exit;
} catch (\Controllers\PrivateNoLoggedException $ex) {

    $redirTo = urlencode(Context::getContextByKey("request_uri"));
    Site::redirectTo("index.php?page=sec.login&redirto=" . $redirTo);
    exit;
} catch (\Exception $ex) {

    Site::logError($ex, ($ex->getCode() >= 400 && $ex->getCode() < 600) ? $ex->getCode() : 500);
    $instance = new \Controllers\Error();
    $instance->run();
    exit;
} catch (\Error $ex) {
    // Errores fatales/engine
    Site::logError($ex, 500);
    $instance = new \Controllers\Error();
    $instance->run();
    exit;
}
