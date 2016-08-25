<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 18.08.16
 * Time: 11:30
 */
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class TransactionController extends \Phalcon\Mvc\Controller
{
    protected $user;
    protected $account;

    public function beforeExecuteRoute()
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
        $this->user = User::findFirst($user_id);
        $this->view->setVar('user', $this->user);
    }
    /**
     * @route /transactions
     */
    public function indexAction()
    {
        $account = $this->user->getSelectedAccount();
        $transactions = $account->getTransaction(["order" => "created_at DESC"]);
        $this->view->transactions = $transactions;
        $this->view->account = $account;

        $currentPage = (int) $_GET["page"];
        $paginator = new PaginatorModel(["data" => $transactions, "limit" => 5, "page" => $currentPage]);

        $page = $paginator->getPaginate();
        $this->view->page = $page;
    }

    /**
     * @route /transactions/create
     */
    public function createAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $transaction = new Transaction($data);
            $success = $transaction->create();
            if ($success) {
                return $this->response->redirect();
            } else {
                $messages = $transaction->getMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }
        $this->view->categories = Category::find();
    }

    /**
     * @route /transactions/{id}
     */
    public function editAction()
    {
        $id = $this->dispatcher->getParam('id');
        $transaction = Transaction::findFirst($id);
        if (!$transaction) {
            return $this->dispatcher->forward(['controller' => 'exception', 'action' => 'notFound']);
        }

        if ($this->request->isPost()){
            $data = $this->request->getPost();
            $success = $transaction->update($data);
            if (!$success) {
                $messages = $transaction->getMessages();
                if ($messages) {
                    foreach ($messages as $message) {
                        $this->flash->error($message);
                    }
                }
            }
        }

        $this->view->categories = Category::find();
        $this->view->transaction = $transaction;

        $accounts = $this->user->getAccount();
        $this->view->accounts = $accounts;
    }

    /**
     * @route /transactions/{id}/remove
     */
    public function removeAction()
    {
        $id = $this->dispatcher->getParam('id');
        $transaction = Transaction::findFirst($id);
        if (!$transaction) {
            return $this->dispatcher->forward(['controller' => 'exception', 'action' => 'notFound']);
        }

        $transaction->delete();
        return $this->response->redirect("/transactions");
    }
}