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
 * Description of GroupEventDao
 *
 * @author Daniele Ambrosino
 */
abstract class ChatEventDao extends MessageDao
{

  protected final function storeChatEventByType(ChatEvent $event, string $type)
  {
    $id = $this->storeMessageByType($event, 'chatEvent');
    $query = "INSERT INTO ChatEvents (messageId, type) VALUES (?, ?)";
    $values = [$id, $type];
    $this->db->query($query, $values);
  }

}
