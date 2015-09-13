<?php declare(strict_types=1);
/**
 * User controller
 *
 * PHP version 7.0
 *
 * @category   Demo
 * @package    Presentation
 * @subpackage Controller
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://pieterhordijk.com>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace Demo\Presentation\Controller;

use CodeCollab\Http\Response\Response;
use CodeCollab\Http\Response\StatusCode;
use CodeCollab\Http\Request\Request;
use CodeCollab\Template\Html;
use Demo\Form\Login as LoginForm;
use Demo\Form\Logout as LogoutForm;
use CodeCollab\Authentication\Authentication;

/**
 * User controller
 *
 * @category   Demo
 * @package    Presentation
 * @subpackage Controller
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class User
{
    /**
     * @var \CodeCollab\Http\Response\Response Response object
     */
    private $response;

    /**
     * Creates instance
     *
     * @param \CodeCollab\Http\Response\Response $response Response object
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Renders the login page
     *
     * @param \CodeCollab\Template\Html        $template A HTML template renderer
     * @param \Demo\Form\Login                 $form     The login form
     * @param \CodeCollab\Http\Request\Request $request  The request object
     *
     * @return \Symfony\Component\HttpFoundation\Response The HTTP response
     */
    public function login(Html $template, LoginForm $form, Request $request): Response
    {
        if ($request->cookie('rememberme') === 'enabled') {
            $this->response->setStatusCode(StatusCode::FOUND);
            $this->response->addHeader('Location', $request->getBaseUrl() . '/cookie-login');

            return $this->response;
        }

        $this->response->setContent($template->renderPage('/user/login.phtml', [
            'form' => $form,
        ]));

        if ($form->isValidated()) {
            $this->response->setStatusCode(StatusCode::UNAUTHORIZED);
        }

        return $this->response;
    }

    /**
     * Handles the login form
     *
     * @param \CodeCollab\Template\Html                 $template A HTML template renderer
     * @param \Demo\Form\Login                          $form     The login form
     * @param \CodeCollab\Http\Request\Request          $request  The request object
     * @param \CodeCollab\Authentication\Authentication $user     The authentication object
     *
     * @return \Symfony\Component\HttpFoundation\Response The HTTP response
     */
    public function doLogin(Html $template, LoginForm $form, Request $request, Authentication $user): Response
    {
        $form->bindRequest($request);

        // Hardcoded user info. Normally this would be retrieved from the database.
        // This contains a user with username + password of demo + demo.
        $userInfo = [
            'username' => 'demo',
            'name'     => 'Demo Demo',
            'hash'     => '$2y$14$hPOMx1/RiQHriUVLgst0mOiZj1CyE7ziXk9LNf3UgZxsNuST.xnpe',
        ];

        if (!$form->isValid() || !$user->logIn($form['password']->getValue(), $userInfo['hash'], $userInfo)) {
            return $this->login($template, $form, $request);
        }

        if ($form['rememberme']->getValue()) {
            $this->response->addCookie('rememberme', 'enabled', (new \DateTime())->add(new \DateInterval('P30D')));
        }

        $this->response->setStatusCode(StatusCode::FOUND);
        $this->response->addHeader('Location', $request->getBaseUrl());

        return $this->response;
    }

    /**
     * Handles the cookie login
     *
     * @param \CodeCollab\Http\Request\Request          $request  The request object
     * @param \CodeCollab\Authentication\Authentication $user     The authentication object
     *
     * @return \Symfony\Component\HttpFoundation\Response The HTTP response
     */
    public function doCookieLogin(Request $request, Authentication $user): Response
    {
        // Hardcoded user info. Normally this would be retrieved from the database.
        // This contains a user with username + password of demo + demo.
        $userInfo = [
            'username' => 'demo',
            'name'     => 'Demo Demo',
            'hash'     => '$2y$14$hPOMx1/RiQHriUVLgst0mOiZj1CyE7ziXk9LNf3UgZxsNuST.xnpe',
        ];

        if ($request->cookie('rememberme') !== 'enabled' || !$user->logInRememberMe($userInfo)) {
            $this->response->addCookie('rememberme', '', (new \DateTime())->sub(new \DateInterval('P30D')));
        } else {
            $this->response->addCookie('rememberme', '', (new \DateTime())->add(new \DateInterval('P30D')));
        }

        $this->response->setStatusCode(StatusCode::FOUND);
        $this->response->addHeader('Location', $request->getBaseUrl());

        return $this->response;
    }

    /**
     * Handles the logout form
     *
     * @param \Demo\Form\Logout                         $form    The logout form
     * @param \CodeCollab\Http\Request\Request          $request The request object
     * @param \CodeCollab\Authentication\Authentication $user    The authentication object
     *
     * @return \Symfony\Component\HttpFoundation\Response The HTTP response
     */
    public function doLogout(LogoutForm $form, Request $request, Authentication $user): Response
    {
        $form->bindRequest($request);

        if ($form->isValid()) {
            $user->logOut();

            $this->response->addCookie('rememberme', '', (new \DateTime())->sub(new \DateInterval('P30D')));
        }

        $this->response->setStatusCode(StatusCode::FOUND);
        $this->response->addHeader('Location', $request->getBaseUrl());

        return $this->response;
    }
}
