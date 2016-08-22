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
    protected $user_id;
    protected $amount;
    protected $comment;
    protected $created_at;

    public function beforeValidationOnCreate()
    {
        $this->created_at = date("Y-m-d H:i:s");
        $session = \Phalcon\Di::getDefault()->get('session');
        $this->user_id = $session->get("user_id");
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getAmountDigit()
    {
        return $this->amount;
    }

    public function getAmount()
    {
        if ($this->isIncome()) {
            return "+" . $this->amount;
        } else {
            return $this->amount;
        }
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


}