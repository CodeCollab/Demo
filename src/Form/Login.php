<?php declare(strict_types=1);
/**
 * Login form
 *
 * PHP version 7.0
 *
 * @category   Demo
 * @package    Form
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://pieterhordijk.com>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace Demo\Form;

use CodeCollab\Form\BaseForm;
use CodeCollab\Form\Field\Csrf as CsrfField;
use CodeCollab\Form\Field\Text as TextField;
use CodeCollab\Form\Field\Password as PasswordField;
use CodeCollab\Form\Field\Checkbox as CheckboxField;
use CodeCollab\Form\Validation\Required as RequiredValidator;
use CodeCollab\Form\Validation\Match as MatchValidator;

/**
 * Login form
 *
 * @category   Demo
 * @package    Form
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Login extends BaseForm
{
    /**
     * Sets up the fields of the form
     */
    protected function setupFields()
    {
        $this->addField(new CsrfField('csrfToken', [
            new RequiredValidator(),
            new MatchValidator(base64_encode($this->csrfToken->get())),
        ], base64_encode($this->csrfToken->get())));

        $this->addField(new TextField('username', [
            new RequiredValidator(),
        ]));

        $this->addField(new PasswordField('password', [
            new RequiredValidator(),
        ]));

        $this->addField(new CheckboxField('rememberme', [new MatchValidator('1')], '1'));
    }
}
