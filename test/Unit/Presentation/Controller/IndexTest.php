<?php declare(strict_types=1);

namespace DemoTest\Unit\Presentation\Controller;

use Demo\Presentation\Controller\Index;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    protected $response;

    protected $template;

    public function setUp()
    {
        $this->response = $this->getMock('CodeCollab\Http\Response\Response', [], [], '', false);
        $this->template = $this->getMock('CodeCollab\Template\Html', [], [], '', false);
    }

    /**
     * @covers \Demo\Presentation\Controller\Index::__construct
     * @covers \Demo\Presentation\Controller\Index::index
     */
    public function testIndex()
    {
        $this->response
            ->expects($this->once())
            ->method('setContent')
            ->with($this->equalTo('thetemplate'))
        ;

        $controller = new Index($this->response);

        $this->template
            ->expects($this->once())
            ->method('renderPage')
            ->with($this->equalTo('/home/index.phtml'))
            ->willReturn('thetemplate')
        ;

        $this->assertInstanceOf('CodeCollab\Http\Response\Response', $controller->index($this->template));
    }
}
