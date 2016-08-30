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
    const UAH_RATE = 1;

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

    public function getCoefficientByCurrencyId($currency_id)
    {
        $new_currency = self::findFirst($currency_id)->getName();
        $old_currency = $this->getName();
        if ($old_currency == 'UAH') {
            if ($new_currency == "USD") {
                return self::UAH_RATE/self::USD_RATE;
            } else {
                return self::UAH_RATE/self::EUR_RATE;
            }
        } elseif ($old_currency == 'USD') {
            if ($new_currency == "UAH") {
                return self::USD_RATE/self::UAH_RATE;
            } else {
                return self::USD_RATE/self::EUR_RATE;
            }
        } elseif ($old_currency == 'EUR') {
            if ($new_currency == "UAH") {
                return self::EUR_RATE/self::UAH_RATE;
            } else {
                return self::EUR_RATE/self::USD_RATE;
            }

        }
    }
}