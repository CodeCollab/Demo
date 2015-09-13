<?php declare(strict_types=1);

namespace DemoTest\Unit\Presentation\Controller;

use Demo\Presentation\Controller\Error;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    protected $response;

    protected $template;

    public function setUp()
    {
        $this->response = $this->getMock('CodeCollab\Http\Response\Response', [], [], '', false);
        $this->template = $this->getMock('CodeCollab\Template\Html', [], [], '', false);
    }

    /**
     * @covers \Demo\Presentation\Controller\Error::__construct
     * @covers \Demo\Presentation\Controller\Error::notFound
     */
    public function testNotFound()
    {
        $this->response
            ->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo('thetemplate'))
        ;

        $controller = new Error($this->response);

        $this->template
            ->expects($this->once())
            ->method('renderPage')
            ->with($this->equalTo('/error/not-found.phtml'))
            ->willReturn('thetemplate')
        ;

        $this->assertInstanceOf('CodeCollab\Http\Response\Response', $controller->notFound($this->template));
    }

    /**
     * @covers \Demo\Presentation\Controller\Error::__construct
     * @covers \Demo\Presentation\Controller\Error::methodNotAllowed
     */
    public function testMethodNotAllowed()
    {
        $this->response
            ->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo('thetemplate'))
        ;

        $controller = new Error($this->response);

        $this->template
            ->expects($this->once())
            ->method('renderPage')
            ->with($this->equalTo('/error/generic.phtml'))
            ->willReturn('thetemplate')
        ;

        $this->assertInstanceOf('CodeCollab\Http\Response\Response', $controller->methodNotAllowed($this->template));
    }
}
