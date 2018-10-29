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
 * Description of ContactDaoMysql
 *
 * @author Daniele Ambrosino
 */
class ContactDaoMysql extends ContactDao
{

  /**
   * 
   * @param Contact $message
   */
  public function store($message)
  {
    $this->db->query('START TRANSACTION');
    $this->storeMessageByType($message, 'contact');
    $query = "INSERT INTO Contacts (messageId, phoneNumber, firstName, lastName, userId, vcard) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getPhoneNumber(), $message->getFirstName(), $message->getLastName(), $message->getUserId(), $message->getVcard()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
