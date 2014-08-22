<?php

namespace App\Forms;

use App\Library\Form\Base\BaseForm;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;

class SignUpForm extends BaseForm
{

    public function initialize()
    {
        $this
                ->setTitle('SignUp Form')
                ->setDescription('Create new user.')
                ->setAttribute('autocomplete', 'off');

        $content = $this->addContentFieldSet()
                ->addText('fullname', null, null, null, [], ['autocomplete' => 'off'])
                ->addPassword('password', null, null, [], ['autocomplete' => 'off'])
                ->addPassword('confirm_password', null, null, [], ['autocomplete' => 'off'])
                ->addText('email', null, null, null, [], ['autocomplete' => 'off']);

        $this->addFooterFieldSet()
                ->addButton('create')
                ->addButtonLink('cancel', 'Cancel', ['for' => 'admin-users']);

        $this->_setValidation($content);
    }

    protected function _setValidation($content)
    {
        $content->getValidation()
                ->add('fullname', new StringLength(['min' => 2]))
                ->add('email', new Email())
                ->add('password', new StringLength(['min' => 6]))
                ->add('confirm_password', new StringLength(['min' => 6]));

        $content
                ->setRequired('fullname')
                ->setRequired('email')
                ->setRequired('password')
                ->setRequired('confirm_password');

        $this
                ->addFilter('password', self::FILTER_STRING)
                ->addFilter('confirm_password', self::FILTER_STRING);
    }

    /* public function initialize($entity = null, $options = null)
      {
      $name = new Text('name');
      $name->setLabel('Name');
      $name->addValidators(array(
      new PresenceOf(array(
      'message' => 'The name is required'
      ))
      ));
      $this->add($name);

      // Email
      $email = new Text('email');
      $email->setLabel('E-Mail');
      $email->addValidators(array(
      new PresenceOf(array(
      'message' => 'The e-mail is required'
      )),
      new Email(array(
      'message' => 'The e-mail is not valid'
      ))
      ));

      $this->add($email);
      // Password
      $password = new Password('password');
      $password->setLabel('Password');
      $password->addValidators(array(
      new PresenceOf(array(
      'message' => 'The password is required'
      )),
      new StringLength(array(
      'min' => 8,
      'messageMinimum' => 'Password is too short. Minimum 8 characters'
      )),
      new Confirmation(array(
      'message' => 'Password doesn\'t match confirmation',
      'with' => 'confirmPassword'
      ))
      ));

      $this->add($password);

      // Confirm Password
      $confirmPassword = new Password('confirmPassword');
      $confirmPassword->setLabel('Confirm Password');
      $confirmPassword->addValidators(array(
      new PresenceOf(array(
      'message' => 'The confirmation password is required'
      ))
      ));

      $this->add($confirmPassword);
      // Remember
      $terms = new Check('terms', array(
      'value' => 'yes'
      ));
      $terms->setLabel('Accept terms and conditions');

      $terms->addValidator(new Identical(array(
      'value' => 'yes',
      'message' => 'Terms and conditions must be accepted'
      )));
      $this->add($terms);

      // CSRF
      $csrf = new Hidden('csrf');

      $csrf->addValidator(new Identical(array(
      'value' => $this->security->getSessionToken(),
      'message' => 'CSRF validation failed'
      )));

      $this->add($csrf);

      // Sign Up
      $this->add(new Submit('Sign Up', array(
      'class' => 'btn btn-success'
      )));
      } */
}
