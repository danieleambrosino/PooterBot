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
 * Description of ContactDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class ContactDaoSqlite extends ContactDao
{

  /**
   * 
   * @param Contact $message
   */
  public function store($message)
  {
    $this->db->query('BEGIN TRANSACTION');
    $id = $this->storeMessageByType($message, 'contact');
    $query = "INSERT INTO Contacts (messageId, phoneNumber, firstName, lastName, userId, vcard) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$id, $message->getPhoneNumber(), $message->getFirstName(), $message->getLastName(), $message->getUserId(), $message->getVcard()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
