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

  /**
   *
   * @var bool
   */
  protected $isMuted;

  /**
   *
   * @var int
   */
  protected $offenseCount;

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

  public function getOffenseCount(): int
  {
    if ( is_null($this->offenseCount) )
    {
      $query = "SELECT offenseCount FROM Chats WHERE id = ?";
      $values = [$this->id];
      $result = Factory::createDatabase()->query($query, $values);
      $this->offenseCount = empty($result) ? 0 : $result[0]['offenseCount'];
    }
    return $this->offenseCount;
  }

  public function setOffenseCount($offenseCount)
  {
    $query = "UPDATE Chats SET offenseCount = ? WHERE id = ?";
    $values = [$offenseCount, $this->id];
    Factory::createDatabase()->query($query, $values);
    $this->offenseCount = $offenseCount;
  }

  public final function mute()
  {
    $db = Factory::createDatabase();
    $query = "INSERT INTO MutedChats (chatId) VALUES (?)";
    $values = [$this->id];
    $db->query($query, $values);
    $this->isMuted = TRUE;
  }

  public final function unmute()
  {
    $db = Factory::createDatabase();
    $query = "DELETE FROM MutedChats WHERE chatId = ?";
    $values = [$this->id];
    $db->query($query, $values);
    $this->isMuted = FALSE;
  }

}
