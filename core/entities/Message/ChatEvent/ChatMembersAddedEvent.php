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
 * Description of NewChatMembersEvent
 *
 * @author Daniele Ambrosino
 */
class ChatMembersAddedEvent extends ChatEvent
{

  /**
   *
   * @var array
   */
  private $newMembers;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              array $newMembers)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->newMembers = $newMembers;
  }

  public function getNewMembers(): array
  {
    return $this->newMembers;
  }

}
