<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 18.08.16
 * Time: 11:24
 */
class Transaction extends \Phalcon\Mvc\Model
{
    protected $id;
    protected $category_id;
    protected $account_id;
    protected $amount;
    protected $comment;
    protected $created_at;

    protected function initialize()
    {
        $this->belongsTo('category_id', Category::class, 'id');
        $this->belongsTo('account_id', Account::class, 'id');
    }

    public function beforeValidationOnCreate()
    {
        $this->created_at = date("Y-m-d H:i:s");
        $session = \Phalcon\Di::getDefault()->get('session');
        $this->user_id = $session->get("user_id");
    }

    public function validation()
    {
        $validation = new \Phalcon\Validation();
        $validation->add('amount', new \Phalcon\Validation\Validator\Numericality());

        return $this->validate($validation);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getAccountId()
    {
        return $this->account_id;
    }

    public function getAmountDigit()
    {
        if ($this->isIncome()) {
            return "+" . $this->amount;
        } else {
            return $this->amount;
        }
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function isIncome()
    {
        return ($this->amount > 0) ? true : false;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}