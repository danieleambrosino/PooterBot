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
 * Description of Message
 *
 * @author Daniele Ambrosino
 */
abstract class Message
{

  protected $id;
  protected $datetime;
  protected $user;
  protected $chat;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat)
  {
    $this->id = $id;
    $this->datetime = $datetime;
    $this->user = $user;
    $this->chat = $chat;
  }

  public final function getId(): int
  {
    return $this->id;
  }

  public final function getDatetime(): int
  {
    return $this->datetime;
  }

  public final function getUser(): User
  {
    return $this->user;
  }

  public final function &getChat(): Chat
  {
    return $this->chat;
  }

}
