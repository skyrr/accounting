<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 18.08.16
 * Time: 11:33
 */
class AccountController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        if (!$this->session->has("user_id")) {
            return $this->dispatcher->forward(["controller" => "user", "action" => "login"]);
        }

        $user_id = $this->session->get("user_id");
        $user = User::findFirst($user_id);
        $this->view->setVar('user', $user);

        $transactions = $user->getTransaction(["order" => "created_at DESC", "limit" => 5]);
        $this->view->transactions = $transactions;


    }


}