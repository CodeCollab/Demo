<?php declare(strict_types=1);
/**
 * Environment configuration switcher
 *
 * When switching environments create a new config file in the format of init.{env}.php and load it here
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

require_once __DIR__ . '/init.development.php';
