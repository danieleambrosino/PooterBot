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
 * Description of TextMessageDaoMysql
 *
 * @author Daniele Ambrosino
 */
class TextMessageDaoMysql extends TextMessageDao
{

  /**
   * 
   * @param TextMessage $message
   */
  public function store($message)
  {
    $this->db->query('START TRANSACTION');
    $id = $this->storeMessageByType($message, 'text');
    $query = "REPLACE INTO TextMessages (messageId, text) VALUES (?, ?)";
    $values = [$id, $message->getText()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
