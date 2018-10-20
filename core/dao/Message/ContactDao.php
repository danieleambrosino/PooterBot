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
 * Description of ContactDao
 *
 * @author Daniele Ambrosino
 */
abstract class ContactDao extends MessageDao
{

  public function get(int $id): Contact
  {
    $query = <<<SQL
SELECT *
FROM Messages M
  JOIN Contacts C ON M.id = C.messageId
WHERE M.id = ?
SQL;
    $values = [$id];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param Contact $message
   */
  public function store($message)
  {
    $this->storeMessageByType($message, 'contact');
    $query = "INSERT INTO Contacts (messageId, phoneNumber, firstName, lastName, userId, vcard) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getPhoneNumber(), $message->getFirstName(), $message->getLastName(), $message->getUserId(), $message->getVcard()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param Contact $message
   */
  public function update($message)
  {
    $query = "UPDATE Contacts SET phoneNumber = ?, firstName = ?, lastName = ?, userId = ?, vcard = ? WHERE messageId = ?";
    $values = [$message->getPhoneNumber(), $message->getFirstName(), $message->getLastName(), $message->getUser(), $message->getVcard()];
    $this->db->query($query, $values);
  }

  protected function constructObject(array $data): Contact
  {
    $message = &$data[0];
    return new Contact($message['id'], $message['datetime'], $user, $chat,
                       $message['phoneNumber'], $message['firstName'],
                       $message['lastName'], $message['userId'],
                       $message['vcard']);
  }

}
