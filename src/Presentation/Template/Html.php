<?php declare(strict_types=1);
/**
 * HTML page template renderer
 *
 * PHP version 7.0
 *
 * @category   Demo
 * @package    Presentation
 * @subpackage Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace Demo\Presentation\Template;

use CodeCollab\Template\Html as BaseTemplate;
use CodeCollab\Theme\Theme;

/**
 * HTML page template renderer
 *
 * @category   Demo
 * @package    Presentation
 * @subpackage Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Html extends BaseTemplate
{
    private $theme;

    /**
     * Creates instance
     *
     * @param string $basePage The base (skeleton) page template
     */
    public function __construct(string $basePage, Theme $theme)
    {
        parent::__construct($basePage);

        $this->theme = $theme;
    }

    /**
     * Renders a template
     *
     * @param string $template The template to render
     * @param array  $data     The template variables
     *
     * @return string The rendered template
     */
    public function render(string $template, array $data = []): string
    {
        return parent::render($this->theme->load($template), $data);
    }

    /**
     * Renders a page
     *
     * @param string $template The template to render
     * @param array  $data     The template variables
     *
     * @return string The rendered page
     */
    public function renderPage(string $template, array $data = []): string
    {
        $content = $this->render($template, $data);

        $output = '';

        try {
            ob_start();

            require $this->theme->load($this->basePage);
        } finally {
            $output = ob_get_clean();
        }

        return $output;
    }
}
