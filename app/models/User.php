<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 18.08.16
 * Time: 11:15
 */
class User extends \Phalcon\Mvc\Model
{
    protected $id;
    protected $name;
    protected $email;
    protected $password;

    protected function initialize()
    {
        $this->hasMany(
            'id',
            Transaction::class,
            'user_id'
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getBalance()
    {
        return Transaction::sum([
            "user_id = '$this->id'",
            'column' => 'amount'
        ]);
    }

    public function getBalanceMonth()
    {
        return Transaction::sum([
            "user_id = '$this->id' AND YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())" ,
            'column' => 'amount'
        ]);
    }

    public function getBalanceToday()
    {
        return Transaction::sum([
            "user_id = '$this->id' AND DATE(created_at) = CURDATE()",
            'column' => 'amount'
        ]);
    }
}