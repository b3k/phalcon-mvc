<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;

class LoginForm extends Form
{

    public function initialize()
    {

        $this
                ->setTitle('Login')
                ->setDescription('Use you email or username to login.')
                ->setAttribute('class', 'form_login');

        $content = $this->addContentFieldSet()
                ->addText('login')
                ->addPassword('password')
                ->addCheckbox('remember', 'Remember me', 'Remember me for 7 days', 'yes', false);

        $this->addFooterFieldSet()
                ->addButton('enter', 'Signin', true, null, null, ['class' => 'btn btn-success'])
                ->addButtonLink('register', 'Register account', ['for' => 'homepage']);
        
        $this->_setValidation($content);
    }

    protected function _setValidation($content)
    {
        $content->getValidation()
                ->add('email', new Email())
                ->add('password', new StringLength(['min' => 6]));

        $content
                ->setRequired('login')
                ->setRequired('password');

        $this
                ->addFilter('email', self::FILTER_EMAIL)
                ->addFilter('password', self::FILTER_STRING);
    }

}
