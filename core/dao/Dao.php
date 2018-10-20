<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

/**
 * Description of Dao
 *
 * @author Daniele Ambrosino
 */
abstract class Dao
{

  /**
   *
   * @var Database
   */
  protected $db;
  
  protected static $instance;
  
  public static function getInstance()
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }

  protected function __construct(){}

  abstract public function store($object);

  abstract public function get(int $id);

  abstract public function update($object);

  abstract public function delete($object);
  
  abstract protected function constructObject(array $data);
}
