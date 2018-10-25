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

  protected function __construct()
  {
    $this->db = Factory::createDatabase();
  }

  abstract public function store($object);

  abstract public function get(int $id);

  abstract public function update($object);

  abstract public function delete($object);

  abstract protected function constructObject(array $data);
}
