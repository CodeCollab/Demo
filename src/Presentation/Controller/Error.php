<?php declare(strict_types=1);
/**
 * Error controller
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
use CodeCollab\Template\Html;

/**
 * Error controller
 *
 * @category   Demo
 * @package    Presentation
 * @subpackage Controller
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Error
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
     * Renders the not found page
     *
     * @param \CodeCollab\Presentation\Template\Html $template A HTML template renderer
     *
     * @return \Symfony\Component\HttpFoundation\Response The HTTP response
     */
    public function notFound(Html $template)
    {
        $this->response->setContent($template->renderPage('/home/index.phtml'));

        $this->response->setStatusCode(StatusCode::OK);

        return $this->response;
    }
}
