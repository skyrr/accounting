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

            $user = User::findFirst("email = '$email' AND password = '$password'");
            if ($user) {
                $this->session->set("user_id", $user->getId());
                return $this->response->redirect();
            } else {
                $this->view->setVar("error", "Wrong password or email");
            }
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect("/");
    }
}