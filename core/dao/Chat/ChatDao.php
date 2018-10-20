<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../vendor/autoload.php');
/**
 * Description of ChatDao
 *
 * @author Daniele Ambrosino
 */
abstract class ChatDao extends Dao
{
  
  public static $instantiatedChats;

  /**
   * 
   * @param Chat $chat
   */
  public function delete($chat)
  {
    $query = "DELETE FROM Chats WHERE id = ?";
    $values = [$chat->getId()];
    $this->db->query($query, $values);
  }
  
  public static function getCorrectChat(int $id): Chat
  {
    $query = "SELECT type FROM Chats WHERE id = ?";
    $values = [$id];
    $data = $this->db->query($query, $values);
    $type = &$data[0];
    switch ($type)
    {
      case 'private':
        return Factory::createPrivateChatDao()::getInstance()->get($id);
      case 'group':
        return Factory::createGroupDao()::getInstance()->get($id);
      case 'supergroup':
        return Factory::createSupergroupDao()::getInstance()->get($id);
      case 'channel':
        return Factory::createChannelDao()::getInstance()->get($id);
      default:
        break;
    }
  }

}
