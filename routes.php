<?php declare(strict_types=1);
/**
 * Routes definitions of the project
 *
 * This file contains all the (SEO friendly) URLs of the project
 *
 * PHP version 7.0
 *
 * @category   Demo
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://pieterhordijk.com>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace Demo;

$router
    ->get('/not-found', ['Demo\Presentation\Controller\Error', 'notFound'])
    ->get('/method-not-allowed', ['Demo\Presentation\Controller\Error', 'methodNotAllowed'])
;

if (!$user->isLoggedIn()) {
    $router
        ->get('/', ['Demo\Presentation\Controller\Index', 'index'])
    ;
}
