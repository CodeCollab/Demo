<?php declare(strict_types=1);

namespace DemoTest\Unit\Form;

use Demo\Form\Login;

class LoginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Demo\Form\Login::setupFields
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf('CodeCollab\Form\Form', new Login($this->getMock('CodeCollab\CsrfToken\Token')));
    }

    /**
     * @covers \Demo\Form\Login::setupFields
     */
    public function testExtendsCorrectBaseClass()
    {
        $this->assertInstanceOf('CodeCollab\Form\BaseForm', new Login($this->getMock('CodeCollab\CsrfToken\Token')));
    }
}
