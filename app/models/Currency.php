<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 26.08.16
 * Time: 15:57
 */
class Currency extends \Phalcon\Mvc\Model
{
    const USD_RATE = 25;
    const EUR_RATE = 28;
    protected $id;
    protected $name;

    public function initialize()
    {
        $this->hasMany('id', Account::class, 'currency_id');
    }



    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}