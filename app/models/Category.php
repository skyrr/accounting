<?php
/**
 * Created by PhpStorm.
 * User: volodymyr
 * Date: 23.08.16
 * Time: 10:27
 */
class Category extends \Phalcon\Mvc\Model
{
    protected $id;
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
