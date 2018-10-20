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
 * Description of PhotoDao
 *
 * @author Daniele Ambrosino
 */
class PhotoDao extends MultimediaMessageDao
{

  public function get(int $id)
  {
    $query = <<<SQL
SELECT *
FROM Messages M
  JOIN Photos P ON M.id = P.messageId
WHERE M.id = ?
SQL;
    $values = [$id];
    $this->db->query($query, $values);
  }

  public function store(Photo $message)
  {
    $this->storeMessageByType($message, 'photo');
    $query = "INSERT INTO Photos (messageId, width, height, caption, fileId) VALUES (?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getWidth(), $message->getHeight(), $message->getCaption(), $message->getCaption()];
    $this->db->query($query, $values);
  }

  public function update($object)
  {
    
  }

}
