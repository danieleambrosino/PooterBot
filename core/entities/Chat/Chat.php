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

  public function __construct(int $id)
  {
    $this->id = $id;
    
    $db = Factory::createDatabase();
    $query = "SELECT 1 FROM MutedChats WHERE chatId = ?";
    $values = [$this->id];
    $result = $db->query($query, $values);
    $this->isMuted = !empty($result);
  }

  public final function getId(): int
  {
    return $this->id;
  }

  public final function isMuted(): bool
  {
    return $this->isMuted;
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
