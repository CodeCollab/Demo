<?php declare(strict_types=1);

namespace DemoTest\Unit\Storage;

use Demo\Storage\TokenSession;

//use CodeCollab\CsrfToken\Storage\Storage;
//use CodeCollab\Http\Session\Session;

class TokenSessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Demo\Storage\TokenSession::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf(
            'CodeCollab\CsrfToken\Storage\Storage',
            new TokenSession($this->getMock('CodeCollab\Http\Session\Session'))
        );
    }

    /**
     * @covers \Demo\Storage\TokenSession::__construct
     * @covers \Demo\Storage\TokenSession::exists
     */
    public function testExistsWhenDoesntExist()
    {
        $session = $this->getMock('CodeCollab\Http\Session\Session');

        $session
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('myKey'))
            ->willReturn(false)
        ;

        $this->assertFalse((new TokenSession($session))->exists('myKey'));
    }

    /**
     * @covers \Demo\Storage\TokenSession::__construct
     * @covers \Demo\Storage\TokenSession::exists
     */
    public function testExistsWhenItDoesExist()
    {
        $session = $this->getMock('CodeCollab\Http\Session\Session');

        $session
            ->expects($this->once())
            ->method('exists')
            ->with($this->equalTo('myKey'))
            ->willReturn(true)
        ;

        $this->assertTrue((new TokenSession($session))->exists('myKey'));
    }

    /**
     * @covers \Demo\Storage\TokenSession::__construct
     * @covers \Demo\Storage\TokenSession::get
     */
    public function testGet()
    {
        $session = $this->getMock('CodeCollab\Http\Session\Session');

        $session
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('myKey'))
            ->willReturn('myValue')
        ;

        $this->assertSame('myValue', (new TokenSession($session))->get('myKey'));
    }

    /**
     * @covers \Demo\Storage\TokenSession::__construct
     * @covers \Demo\Storage\TokenSession::set
     */
    public function testSet()
    {
        $session = $this->getMock('CodeCollab\Http\Session\Session');

        $session
            ->expects($this->once())
            ->method('set')
            ->with($this->equalTo('myKey'), $this->equalTo('myValue'))
        ;

        $this->assertNull((new TokenSession($session))->set('myKey', 'myValue'));
    }
}
