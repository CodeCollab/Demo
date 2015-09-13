<?php declare(strict_types=1);

namespace DemoTest\Unit\Form;

use Demo\Form\Logout;

class LogoutTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Demo\Form\Logout::setupFields
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf('CodeCollab\Form\Form', new Logout($this->getMock('CodeCollab\CsrfToken\Token')));
    }

    /**
     * @covers \Demo\Form\Logout::setupFields
     */
    public function testExtendsCorrectBaseClass()
    {
        $this->assertInstanceOf('CodeCollab\Form\BaseForm', new Logout($this->getMock('CodeCollab\CsrfToken\Token')));
    }
}
