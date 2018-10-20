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
 * Description of User
 *
 * @author Daniele Ambrosino
 */
class User
{

  private $id;
  private $firstName;
  private $lastName;
  private $username;

  /**
   * 
   * @param int $id
   * @param string $firstName
   * @param string $lastName
   * @param string $username
   */
  public function __construct(int $id, string $firstName, $lastName, $username)
  {
    $this->id = $id;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->username = $username;
  }

  public function getId(): int
  {
    return $this->id;
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
