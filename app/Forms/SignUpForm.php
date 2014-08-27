<?php

namespace App\Forms;

use App\Library\Form\Base\BaseForm;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class SignUpForm extends BaseForm
{

    public function initialize()
    {
        $this
                ->setTitle('SignUp Form')
                ->setDescription('Create new user.')
                ->setAttribute('autocomplete', 'off');

        $content = $this->addContentFieldSet()
                ->addText('fullname',               'Fullname', null, null, [], ['autocomplete' => 'off', 'placeholder' => 'Your fullname'])
                ->addText('email',                  'Email',    null, null, [], ['autocomplete' => 'off', 'placeholder' => 'Email'])
                ->addPassword('password',           'Password', null, [], ['autocomplete' => 'off'])
                ->addPassword('confirm_password',   'Confirm password', null, [], ['autocomplete' => 'off']);

        $this->addFooterFieldSet()
                ->addButton('create')
                ->addButtonLink('cancel', 'Cancel', ['for' => 'index']);

        $this->_setValidation($content);
    }

    protected function _setValidation($content)
    {
        $content->getValidation()
                ->add('fullname',   new StringLength(['min' => 2]))
                ->add('email',      new Email())
                ->add('password',   new StringLength(['min' => 6]))
                ->add('confirm_password', new StringLength(['min' => 6]))
                ->add('confirm_password', new Confirmation(['message' => 'Password doesn\'t match confirmation', 'with' => 'password']));

        $content
                ->setRequired('fullname')
                ->setRequired('email')
                ->setRequired('password')
                ->setRequired('confirm_password');

        $this
                ->addFilter('email', self::FILTER_EMAIL)
                ->addFilter('password', self::FILTER_STRING)
                ->addFilter('confirm_password', self::FILTER_STRING);
    }
}
