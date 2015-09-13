<?php declare(strict_types=1);

namespace DemoTest\Unit\Presentation\Template;

use Demo\Presentation\Template\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    protected $minifier;

    public function setUp()
    {
        $this->minifier = $this->getMock('Minifine\Minifine', [], [], '', false);
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $template = new Html(
            '/page.phtml',
            $this->getMock('CodeCollab\Theme\Loader'),
            $this->minifier,
            $this->getMock('CodeCollab\I18n\Translator'),
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertInstanceOf('CodeCollab\Template\Renderer', $template);
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     */
    public function testExtendsLibrary()
    {
        $template = new Html(
            '/page.phtml',
            $this->getMock('CodeCollab\Theme\Loader'),
            $this->minifier,
            $this->getMock('CodeCollab\I18n\Translator'),
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertInstanceOf('CodeCollab\Template\Html', $template);
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     * @covers \Demo\Presentation\Template\Html::render
     */
    public function testRenderWithoutData()
    {
        $theme = $this->getMock('CodeCollab\Theme\Loader');

        $theme
            ->expects($this->once())
            ->method('load')
            ->with($this->equalTo('thetemplate'))
            ->willReturn(TEST_DATA_DIR . '/content.phtml')
        ;

        $template = new Html(
            '/page.phtml',
            $theme,
            $this->minifier,
            $this->getMock('CodeCollab\I18n\Translator'),
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertSame('CONTENT', $template->render('thetemplate'));
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     * @covers \Demo\Presentation\Template\Html::render
     */
    public function testRenderWithData()
    {
        $theme = $this->getMock('CodeCollab\Theme\Loader');

        $theme
            ->expects($this->once())
            ->method('load')
            ->with($this->equalTo('thetemplate'))
            ->willReturn(TEST_DATA_DIR . '/variables.phtml')
        ;

        $template = new Html(
            '/page.phtml',
            $theme,
            $this->minifier,
            $this->getMock('CodeCollab\I18n\Translator'),
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertSame('VAR1VAR2', $template->render('thetemplate', ['var1' => 'VAR1', 'var2' => 'VAR2']));
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     * @covers \Demo\Presentation\Template\Html::renderPage
     */
    public function testRenderPageWithoutData()
    {
        $theme = $this->getMock('CodeCollab\Theme\Loader');

        $theme
            ->expects($this->at(0))
            ->method('load')
            ->with($this->equalTo('thetemplate'))
            ->willReturn(TEST_DATA_DIR . '/content.phtml')
        ;

        $theme
            ->expects($this->at(1))
            ->method('load')
            ->with($this->equalTo('/page.phtml'))
            ->willReturn(TEST_DATA_DIR . '/page.phtml')
        ;

        $template = new Html(
            '/page.phtml',
            $theme,
            $this->minifier,
            $this->getMock('CodeCollab\I18n\Translator'),
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertSame('STARTCONTENTEND', $template->renderPage('thetemplate'));
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     * @covers \Demo\Presentation\Template\Html::renderPage
     */
    public function testRenderPageWithData()
    {
        $theme = $this->getMock('CodeCollab\Theme\Loader');

        $theme
            ->expects($this->at(0))
            ->method('load')
            ->with($this->equalTo('thetemplate'))
            ->willReturn(TEST_DATA_DIR . '/variables.phtml')
        ;

        $theme
            ->expects($this->at(1))
            ->method('load')
            ->with($this->equalTo('/page.phtml'))
            ->willReturn(TEST_DATA_DIR . '/page.phtml')
        ;

        $template = new Html(
            '/page.phtml',
            $theme,
            $this->minifier,
            $this->getMock('CodeCollab\I18n\Translator'),
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertSame('STARTVAR1VAR2END', $template->renderPage('thetemplate', ['var1' => 'VAR1', 'var2' => 'VAR2']));
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     * @covers \Demo\Presentation\Template\Html::translate
     */
    public function testTranslateWithoutData()
    {
        $translator = $this->getMock('CodeCollab\I18n\Translator');

        $translator
            ->expects($this->once())
            ->method('translate')
            ->with($this->equalTo('myKey'), $this->equalTo([]))
            ->willReturn('translatedstring')
        ;

        $theme = $this->getMock('CodeCollab\Theme\Loader');

        $theme
            ->expects($this->at(0))
            ->method('load')
            ->with($this->equalTo('thetemplate'))
            ->willReturn(TEST_DATA_DIR . '/translation-without-variables.phtml')
        ;

        $template = new Html(
            '/page.phtml',
            $theme,
            $this->minifier,
            $translator,
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertSame('translatedstring', $template->render('thetemplate'));
    }

    /**
     * @covers \Demo\Presentation\Template\Html::__construct
     * @covers \Demo\Presentation\Template\Html::translate
     */
    public function testTranslateWithData()
    {
        $translator = $this->getMock('CodeCollab\I18n\Translator');

        $translator
            ->expects($this->once())
            ->method('translate')
            ->with($this->equalTo('myKey'), $this->equalTo(['foo', 'bar']))
            ->willReturn('translatedstring')
        ;

        $theme = $this->getMock('CodeCollab\Theme\Loader');

        $theme
            ->expects($this->at(0))
            ->method('load')
            ->with($this->equalTo('thetemplate'))
            ->willReturn(TEST_DATA_DIR . '/translation-with-variables.phtml')
        ;

        $template = new Html(
            '/page.phtml',
            $theme,
            $this->minifier,
            $translator,
            $this->getMock('CodeCollab\Authentication\Authentication'),
            $this->getMock('CodeCollab\CsrfToken\Token')
        );

        $this->assertSame('translatedstring', $template->render('thetemplate'));
    }

    /**
     * Translates a given key
     *
     * @param string $key  The key to translate
     * @param array  $data The data to use to fill in dynamic parts of the translations
     *
     * @return string The translated string
     */
    protected function translate(string $key, array $data = []): string
    {
        return $this->translator->translate($key, $data);
    }
}
