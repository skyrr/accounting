<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 18.08.16
 * Time: 11:33
 */
class AccountController extends \Phalcon\Mvc\Controller
{
    protected $user;
    protected $account;
    protected $user_id;

    public function beforeExecuteRoute()
    {
        $user_id = $this->session->get("user_id");
        $this->user_id = $user_id;
        $this->user = User::findFirst($user_id);
        $this->view->setVar('user', $this->user);
    }

    public function indexAction()
    {
        $this->assets->addJs('assets/plugins/jquery-sparkline/jquery-sparkline.js');
        $this->assets->addJs('assets/js/charts.js');
        $this->assets->addInlineJs('jQuery(document).ready(function($) {
                               $(".clickable-row").click(function() {
                               window.document.location = $(this).data("href");});});');

        if (!$this->session->has("user_id")) {
            return $this->dispatcher->forward(["controller" => "user", "action" => "login"]);
        }

        $user_id = $this->session->get("user_id");
        $user = User::findFirst($user_id);
        $this->view->setVar('user', $user);

        $selected_account_id = $user->getSelectedAccountId();
        if (!$selected_account_id) {
            $accounts = $user->getAccount();
            if (!$accounts) {
                return $this->response->redirect("/account/look");
            }
            $selectedAccount = $accounts->offsetGet(0);

        }

        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            //$user = new User($data);
            $success = $user->update($data);
            if ($success) {
                return $this->response->redirect();
            } else {
                $messages = $user->getMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        if (empty($selectedAccount)) {
            $selectedAccount = $user->getSelectedAccount();
        }

        $transactions = $selectedAccount->getTransaction(["order" => "created_at DESC", "limit" => 5]);
        $this->view->transactions = $transactions;

        $result = $selectedAccount->getOutcomeGroupedByCategory();

        $amounts = array_column($result, 0);
        $amounts_string = implode(', ', $amounts);

        $this->view->selectedAccount = $selectedAccount;
        $this->view->amounts_string = $amounts_string;
    }

    public function createAction()
    {


        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $account = new Account($data);
            $success = $account->create();
            if ($success) {
                return $this->response->redirect();
            } else {
                $messages = $account->getMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        //$this->view->user_id = $user_id;
    }

    public function editAction()
    {
        $id = $this->dispatcher->getParam('id');
        $account = Account::findFirst($id);
        if (!$account) {
            return $this->dispatcher->forward(["controller" => "exception", "action" => "notFound"]);
        }

        if ($this->request->isPost()){
            $data = $this->request->getPost();
            $success = $account->update($data);
            if (!$success) {
                $messages = $account->getMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        $this->view->account = $account;
    }

    public function removeAction()
    {

    }

    public function showAction()
    {
        $user_id = $this->session->get("user_id");
        $user = User::findFirst($user_id);
        $this->view->setVar('user', $user);

        $accounts = $user->getAccount();
        $this->view->accounts = $accounts;
    }
}
