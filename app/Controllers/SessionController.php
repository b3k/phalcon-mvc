<?php

namespace App\Controllers;

use App\Forms\LoginForm;
use App\Forms\SignUpForm;
use App\Forms\ForgotPasswordForm;
use App\Auth\Exception as AuthException;
use App\Model\User;

/**
 * Controller used handle non-authenticated session actions like login/logout, user signup, and forgotten passwords
 */
class SessionController extends ControllerBase
{

    public function indexAction()
    {
        
    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $Form = new SignUpForm();

        try {

            if ($this->isPost()) {

                if ($Form->isValid($this->getPost()) != false) {

                    $User = new User();
                    $User->setUserFirstname($this->getPost('name', '', 'striptags'));
                    $User->setUserEmail($this->getPost('email'));
                    $User->setUserPassword($this->getSecurity()->hash($this->getPost('password')));
                    $User->setUserActive(true);
                    $User->setUserLastname('Test');

                    if ($User->save()) {
                        return $this->forward(array(
                                    'controller' => 'index',
                                    'action' => 'index'
                        ));
                    }
                }
            }
        } catch (\Exception $e) {
            $this->addError($e->getMessage());
        }

        $this->getView()->form = $Form;
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {
        $form = new LoginForm();

        try {

            if (!$this->isPost()) {

                //if ($this->auth->hasRememberMe()) {
                //    return $this->auth->loginWithRememberMe();
                //}
            } else {

                if ($form->isValid($this->getPost()) != false) {
                    $this->auth->check(array(
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'remember' => $this->request->getPost('remember')
                    ));

                    return $this->response->redirect('users');
                }
            }
        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = $form;
    }

    /**
     * Shows the forgot password form
     */
    public function forgotPasswordAction()
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = Users::findFirstByEmail($this->request->getPost('email'));
                if (!$user) {
                    $this->flash->success('There is no account associated to this email');
                } else {

                    $resetPassword = new ResetPasswords();
                    $resetPassword->usersId = $user->id;
                    if ($resetPassword->save()) {
                        $this->flash->success('Success! Please check your messages for an email reset password');
                    } else {
                        foreach ($resetPassword->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    }
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('index');
    }

}
