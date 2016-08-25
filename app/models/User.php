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
    protected $selected_account_id;

    public function validation()
    {
        $validation = new \Phalcon\Validation();
        $validation->add('email', new \Phalcon\Validation\Validator\Uniqueness());
        $validation->add('email', new \Phalcon\Validation\Validator\Email());

        return $this->validate($validation);
    }

    protected function initialize()
    {
        $this->hasMany(
            'id',
            Account::class,
            'user_id',
            [
                'alias' => 'Account'
            ]
        );

        $this->hasOne('selected_account_id', Account::class, 'id', [
            'alias' => 'SelectedAccount'
        ]);
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

    public function getSelectedAccountId()
    {
        return $this->selected_account_id;
    }
}
