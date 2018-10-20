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
 * Description of Chat
 *
 * @author Daniele Ambrosino
 */
abstract class Chat
{

  /**
   *
   * @var int
   */
  protected $id;
  protected $isMuted;

  public function __construct(int $id)
  {
    $this->id = $id;
  }

  public final function getId(): int
  {
    return $this->id;
  }

  public final function isMuted(): bool
  {
    if ( is_null($this->isMuted) )
    {
      $db = Factory::createDatabase();
      $query = "SELECT 1 FROM MutedChats WHERE chatId = ?";
      $values = [$this->id];
      $result = $db->query($query, $values);
      $this->isMuted = !empty($result);
    }
    return $this->isMuted;
  }

  public final function mute()
  {
    $db = Factory::createDatabase();
    $query = "INSERT INTO MutedChats (chatId) VALUES (?)";
    $values = [$this->id];
    $db->query($query, $values);
  }

  public final function unmute()
  {
    $db = Factory::createDatabase();
    $query = "DELETE FROM MutedChats WHERE chatId = ?";
    $values = [$this->id];
    $db->query($query, $values);
  }

}
