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
 * Description of StickerDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class StickerDaoSqlite extends StickerDao
{

  /**
   * 
   * @param Sticker $message
   */
  public function store($message)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeMessageByType($message, 'sticker');
    $this->fileDao->store($message->getFile());
    $query = "INSERT INTO Stickers (messageId, width, height, emoji, setName, fileId) VALUES (?, ?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getEmoji(), $message->getSetName(), $message->getFile()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

}
