<?php declare(strict_types=1);
/**
 * Development environment configuration
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

/**
 * Setup error reporting
 */
ini_set('display_startup_errors', 'On');
ini_set('display_errors', 'On');
error_reporting(-1);

/**
 * Set up the environment type
 *
 * This is a.o. used to determine whether we need to used cached versions of the routes and the public resources
 */
$production = false;
