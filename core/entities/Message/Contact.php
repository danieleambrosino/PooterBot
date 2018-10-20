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
 * Description of Contact
 *
 * @author Daniele Ambrosino
 */
class Contact extends Message
{

  private $phoneNumber;
  private $firstName;
  private $lastName;
  private $userId;
  private $vcard;

  /**
   * 
   * @param int $id
   * @param int $datetime
   * @param User $user
   * @param Chat $chat
   * @param string $phoneNumber
   * @param string $firstName
   * @param string $lastName
   * @param int $userId
   * @param string $vcard
   */
  public function __construct(int $id, int $datetime, User $user, Chat $chat,
                              string $phoneNumber, string $firstName, $lastName,
                              $userId, $vcard)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->phoneNumber = $phoneNumber;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->userId = $userId;
    $this->vcard = $vcard;
  }

  public function getPhoneNumber(): string
  {
    return $this->phoneNumber;
  }

  public function getFirstName(): string
  {
    return $this->firstName;
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }

  public function getUserId(): int
  {
    return $this->userId;
  }

  public function getVcard(): string
  {
    return $this->vcard;
  }

}
