<?php return array (
  0 => 
  array (
    'GET' => 
    array (
      '/not-found' => 
      array (
        0 => 'Demo\\Presentation\\Controller\\Error',
        1 => 'notFound',
      ),
      '/method-not-allowed' => 
      array (
        0 => 'Demo\\Presentation\\Controller\\Error',
        1 => 'methodNotAllowed',
      ),
      '/' => 
      array (
        0 => 'Demo\\Presentation\\Controller\\User',
        1 => 'login',
      ),
      '/cookie-login' => 
      array (
        0 => 'Demo\\Presentation\\Controller\\User',
        1 => 'doCookieLogin',
      ),
    ),
    'POST' => 
    array (
      '/' => 
      array (
        0 => 'Demo\\Presentation\\Controller\\User',
        1 => 'doLogin',
      ),
    ),
  ),
  1 => 
  array (
  ),
);