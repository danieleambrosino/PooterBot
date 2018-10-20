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
 * Description of PrivateChat
 *
 * @author Daniele Ambrosino
 */
class PrivateChat extends Chat
{

  protected $firstName;
  protected $lastName;
  protected $username;

  /**
   * 
   * @param int $id
   * @param string $firstName
   * @param string $lastName
   * @param string $username
   */
  public function __construct(int $id, string $firstName, $lastName, $username)
  {
    parent::__construct($id);
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->username = $username;
  }

  public function getFirstName(): string
  {
    return $this->firstName;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function getUsername()
  {
    return $this->username;
  }

}
