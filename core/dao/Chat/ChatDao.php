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

  public static final function getChatTitle(int $id): string
  {
    $db = Factory::createDatabase();
    $query = 'SELECT type FROM Chats WHERE id = ?';
    $values = [$id];
    $chatType = $db->query($query, $values)[0]['type'];

    switch ($chatType)
    {
      case 'private':
        $query = "SELECT firstName, lastName, username FROM PrivateChats WHERE chatId = ?";
        $values = [$id];
        $res = $db->query($query, $values)[0];
        $title = "{$res['firstName']} {$res['lastName']} ({$res['username']})";
        break;
      case 'group':
        $query = "SELECT title FROM Groups WHERE chatId = ?";
        $values = [$id];
        $res = $db->query($query, $values)[0];
        $title = $res['title'];
        break;
      case 'supergroup':
        $query = "SELECT title, username FROM Supergroups WHERE chatId = ?";
        $values = [$id];
        $res = $db->query($query, $values)[0];
        $title = $res['title'] . isset($res['username']) ? " ({$res['username']})" : "";
        break;
      case 'Channel':
        $query = "SELECT title, username FROM Channels WHERE chatId = ?";
        $values = [$id];
        $res = $db->query($query, $values)[0];
        $title = $res['title'] . isset($res['username']) ? " ({$res['username']})" : "";
        break;
      default:
        break;
    }
    return $title;
  }

  public static final function getChatType(int $id): string
  {
    $db = Factory::createDatabase();
    $query = "SELECT type FROM Chats WHERE id = ?";
    $values = [$id];
    return $db->query($query, $values)[0]['type'];
  }

}
