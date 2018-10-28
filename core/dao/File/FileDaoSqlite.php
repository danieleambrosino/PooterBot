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
 * Description of FilesDaoSqlite
 *
 * @author Daniele Ambrosino
 */
class FileDaoSqlite extends FileDao
{

  /**
   * 
   * @param File $file
   */
  public function store($file)
  {
    $query = "SELECT 1 FROM Files WHERE id = ? AND content <> ''";
    $values = [$file->getId()];
    $data = $this->db->query($query, $values);
    if ( !empty($data) )
    {
      if ( $data[0]['1'] === 1 )
      {
        return;
      }
    }
    $query = "INSERT OR REPLACE INTO Files (id, content, size, mimeType) VALUES (?, ?, ?, ?)";
    $values = [$file->getId(), $file->getContent(), $file->getSize(), $file->getMimeType()];
    $this->db->query($query, $values);
  }

}
