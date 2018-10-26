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
 * Description of NewChatTitleEvent
 *
 * @author Daniele Ambrosino
 */
class ChatTitleChangedEvent extends ChatEvent
{

  private $newTitle;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              string $newTitle)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->newTitle = $newTitle;
  }

  public function getNewTitle(): string
  {
    return $this->newTitle;
  }

}
