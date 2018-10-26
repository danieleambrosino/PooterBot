<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../../vendor/autoload.php');

/**
 * Description of TextMessageDao
 *
 * @author Daniele Ambrosino
 */
abstract class TextMessageDao extends MessageDao
{

  protected static $instance;

  public static function getInstance()
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }

  public function get(int $id): TextMessage
  {
    $query = <<<SQL
SELECT *
FROM Messages M
  JOIN TextMessages T ON M.id = T.messageId
WHERE M.id = ?
SQL;
    $values = [$id];
    $data = $this->db->query($query, $values);
    return $this->constructObject($data);
  }

  /**
   * 
   * @param TextMessage $message
   */
  public function store($message)
  {
    $this->storeMessageByType($message, 'text');
    $query = "INSERT OR REPLACE INTO TextMessages (messageId, text) VALUES (?, ?)";
    $values = [$message->getId(), $message->getText()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param TextMessage $message
   */
  public function update($message)
  {
    $query = "UPDATE TextMessages SET text = ? WHERE messageId = ?";
    $values = [$message->getText(), $message->getId()];
    $this->db->query($query, $values);
  }

  protected function constructObject(array $data): TextMessage
  {
    $message = &$data[0];
    $user = Factory::createUserDao()->get($message['userId']);
    $chat = ChatDao::getCorrectChat($message['chatId']);
    return new TextMessage($message['id'], $message['datetime'], $user, $chat,
                           $message['text']);
  }

}
