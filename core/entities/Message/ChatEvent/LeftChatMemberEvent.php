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
 * Description of LeftChatMemberEvent
 *
 * @author Daniele Ambrosino
 */
class LeftChatMemberEvent extends ChatEvent
{

  /**
   *
   * @var User
   */
  private $leftMember;
  
  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              User &$leftMember)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->leftMember = $leftMember;
  }

}
