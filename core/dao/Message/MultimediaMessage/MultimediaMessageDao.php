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
 * Description of MultimediaDao
 *
 * @author Daniele Ambrosino
 */
abstract class MultimediaMessageDao extends MessageDao
{

  public final function getFile(string $fileId): string
  {
    $query = "SELECT content FROM Files WHERE id = ?";
    $values = [$fileId];
    $this->db->query($query, $values);
  }

  public final function getFileSize(string $fileId): int
  {
    $query = "SELECT size FROM Files WHERE id = ?";
    $values = [$fileId];
    $this->db->query($query, $values);
  }

  public final function getMimeType(string $fileId): string
  {
    $query = "SELECT mimeType FROM Files WHERE id = ?";
    $values = [$fileId];
    $this->db->query($query, $values);
  }
  
  protected final function storeFile(string $fileId, $file, $size, $mimeType)
  {
    $query = "INSERT OR IGNORE INTO Files (id, content, size, mimeType) VALUES (?, ?, ?, ?)";
    $values = [$fileId, $file, $size, $mimeType];
    $db = Factory::createDatabase();
    $db->query($query, $values);
  }

}
