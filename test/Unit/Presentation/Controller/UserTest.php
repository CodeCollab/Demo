<?php declare(strict_types=1);

namespace DemoTest\Unit\Presentation\Controller;

use Demo\Presentation\Controller\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    protected $response;

    protected $template;

    public function setUp()
    {
        $this->response = $this->getMock('CodeCollab\Http\Response\Response', [], [], '', false);
        $this->template = $this->getMock('CodeCollab\Template\Html', [], [], '', false);
    }

    /**
     * @covers \Demo\Presentation\Controller\User::__construct
     * @covers \Demo\Presentation\Controller\User::login
     */
    public function testLoginWithoutCookieAndWithoutValidatedForm()
    {
        $this->response
            ->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo('thetemplate'))
        ;

        $controller = new User($this->response);

        $this->template
            ->expects($this->once())
            ->method('renderPage')
            ->with(
                $this->equalTo('/user/login.phtml'),
                $this->logicalAnd(
                    $this->isType('array'),
                    $this->arrayHasKey('form'),
                    $this->containsOnlyInstancesOf('Demo\Form\Login')
                )
            )
            ->willReturn('thetemplate')
        ;

        $form = $this->getMock('Demo\Form\Login', [], [], '', false);

        $form
            ->expects($this->once())
            ->method('isValidated')
            ->willReturn(false)
        ;

        $request = $this->getMock('CodeCollab\Http\Request\Request', [], [], '', false);

        $request
            ->expects($this->once())
            ->method('cookie')
            ->with($this->equalTo('rememberme'))
            ->willReturn('notenabled')
        ;

        $this->assertInstanceOf('CodeCollab\Http\Response\Response', $controller->login($this->template, $form, $request));
    }

    /**
     * @covers \Demo\Presentation\Controller\User::__construct
     * @covers \Demo\Presentation\Controller\User::login
     */
    public function testLoginWithCookieAndWithoutValidatedForm()
    {
        $this->response
            ->expects($this->once())
            ->method('setStatusCode')
            ->with($this->equalTo(302))
        ;

        $this->response
            ->expects($this->once())
            ->method('addHeader')
            ->with($this->equalTo('Location'), $this->equalTo('http://example.com/cookie-login'))
        ;

        $controller = new User($this->response);

        $form = $this->getMock('Demo\Form\Login', [], [], '', false);

        $request = $this->getMock('CodeCollab\Http\Request\Request', [], [], '', false);

        $request
            ->expects($this->once())
            ->method('cookie')
            ->with($this->equalTo('rememberme'))
            ->willReturn('enabled')
        ;

        $request
            ->expects($this->once())
            ->method('getBaseUrl')
            ->willReturn('http://example.com')
        ;

        $this->assertInstanceOf('CodeCollab\Http\Response\Response', $controller->login($this->template, $form, $request));
    }

    /**
     * @covers \Demo\Presentation\Controller\User::__construct
     * @covers \Demo\Presentation\Controller\User::login
     */
    public function testLoginWithoutCookieAndWithValidatedForm()
    {
        $this->response
            ->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo('thetemplate'))
        ;

        $this->response
            ->expects($this->once())
            ->method('setStatusCode')
            ->with($this->equalTo(401))
        ;

        $controller = new User($this->response);

        $this->template
            ->expects($this->once())
            ->method('renderPage')
            ->with(
                $this->equalTo('/user/login.phtml'),
                $this->logicalAnd(
                    $this->isType('array'),
                    $this->arrayHasKey('form'),
                    $this->containsOnlyInstancesOf('Demo\Form\Login')
                )
            )
            ->willReturn('thetemplate')
        ;

        $form = $this->getMock('Demo\Form\Login', [], [], '', false);

        $form
            ->expects($this->once())
            ->method('isValidated')
            ->willReturn(true)
        ;

        $request = $this->getMock('CodeCollab\Http\Request\Request', [], [], '', false);

        $request
            ->expects($this->once())
            ->method('cookie')
            ->with($this->equalTo('rememberme'))
            ->willReturn('notenabled')
        ;

        $this->assertInstanceOf('CodeCollab\Http\Response\Response', $controller->login($this->template, $form, $request));
    }
}
