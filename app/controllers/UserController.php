<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 18.08.16
 * Time: 11:28
 */
class UserController extends \Phalcon\Mvc\Controller
{
    public function loginAction()
    {
        $this->assets->addJs("assets/plugins/jquery-validation/js/jquery.validate.min.js")
            ->addJs("assets/js/login.js");

        if ($this->request->isPost()) {
            $email = $this->request->getPost("email");
            $password = $this->request->getPost("password");

            $user = User::findFirst("email = '$email'");
            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    $this->session->set("user_id", $user->getId());
                    return $this->response->redirect();
                }
            } else {
                //$this->security->hash(rand());
                $this->view->setVar("error", "Wrong password or email");
            }
        }
    }

    public function logoutAction()
    {
        if ($this->session->has("user_id")) {
            $this->session->destroy();
        }

        return $this->response->redirect();
    }

    public function signInAction()
    {
        if ($this->session->has("user_id")) {
            return $this->response->redirect();
        }
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $data['password'] = $this->security->hash($this->request->getPost('password'));

            $user = new User();

            $success = $user->create($data);
            if ($success) {
                $this->session->set("user_id", $user->getId());
                return $this->response->redirect("/account/show");
            } else {
                $messages = $user->getMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }
    }
}