<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../vendor/autoload.php');

/**
 * Description of UserDao
 *
 * @author Daniele Ambrosino
 */
abstract class UserDao extends Dao
{

  public static $instantiatedUsers = [];
  protected static $instance;

  public static function getInstance()
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }

  /**
   * 
   * @param User $user
   */
  public function delete($user)
  {
    $query = "DELETE FROM Users WHERE id = ?";
    $values = [$user->getId()];
    $this->db->query($query, $values);
  }

  public function get(int $id): User
  {
    if ( isset(static::$instantiatedUsers[$id]) )
    {
      return static::$instantiatedUsers[$id];
    }
    $query = "SELECT * FROM Users WHERE id = ?";
    $values = [$id];
    $data = $this->db->query($query, $values);
    if ( empty($data) )
    {
      throw new ResourceNotFoundException();
    }
    $user = $this->constructObject($data);
    static::$instantiatedUsers[$id] = $user;
    return static::$instantiatedUsers[$id];
  }

  /**
   * 
   * @param User $user
   */
  public function store($user)
  {
    $query = "INSERT INTO Users (id, firstName, lastName, username) VALUES (?, ?, ?, ?)";
    $values = [$user->getId(), $user->getFirstName(), $user->getLastName(), $user->getUsername()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param User $user
   */
  public function update($user)
  {
    $query = "UPDATE Users SET firstName = ?, lastName = ?, username = ? WHERE id = ?";
    $values = [$user->getFirstName(), $user->getLastName(), $user->getUsername(), $user->getId()];
    $this->db->query($query, $values);
  }

  public function getMe(): User
  {
    $query = "SELECT * FROM Users WHERE id = ?";
    $values = [TELEGRAM_BOT_ID];
    $data = $this->db->query($query, $values);
    return $this->constructObject($data);
  }

  protected function constructObject(array $data)
  {
    $user = &$data[0];
    return new User($user['id'], $user['firstName'], $user['lastName'],
                    $user['username']);
  }

}
