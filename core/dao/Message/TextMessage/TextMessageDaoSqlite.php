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
 * Description of TextMessageDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class TextMessageDaoSqlite extends TextMessageDaoMysql
{

  /**
   * 
   * @param TextMessage $message
   */
  public function store($message)
  {
    $this->db->query('BEGIN TRANSACTION');
    $id = $this->storeMessageByType($message, 'text');
    $query = "INSERT OR REPLACE INTO TextMessages (messageId, text) VALUES (?, ?)";
    $values = [$id, $message->getText()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
