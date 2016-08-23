<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 18.08.16
 * Time: 11:30
 */
class TransactionController extends \Phalcon\Mvc\Controller
{
    protected $user;

    public function beforeExecuteRoute()
    {
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
        $transactions = $this->user->getTransaction(["order" => "created_at DESC"]);
        $this->view->transactions = $transactions;
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

        $this->view->transaction = $transaction;
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