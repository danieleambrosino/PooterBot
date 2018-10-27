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
 * Description of FilesDao
 *
 * @author Daniele Ambrosino
 */
class FileDao extends Dao
{

  protected static $instance;

  public static function getInstance(): FileDao
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }

  protected function constructObject(array $data)
  {
    $file = &$data[0];
    return new File($file['id'], $file['size'], $file['mimeType']);
  }

  /**
   * 
   * @param File $file
   */
  public function delete($file)
  {
    $query = "DELETE FROM Files WHERE id = ?";
    $values = [$file->getId()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param string $id
   * @return string
   */
  public function getContent($id): string
  {
    $query = "SELECT content FROM Files WHERE id = ?";
    $values = [$id];
    $data = $this->db->query($query, $values);
    if ( empty($data) )
    {
      return "";
    }

    if ( "" === $data[0]['content'] )
    {
      return "";
    }

    return $data[0]['content'];
  }

  /**
   * 
   * @param string $id
   * @return File
   */
  public function get($id): File
  {
    $query = "SELECT id, size, mimeType FROM Files WHERE id = ?";
    $values = [$id];
    $data = $this->db->query($query, $values);
    return $this->constructObject($data);
  }

  /**
   * 
   * @param File $file
   */
  public function store($file)
  {
    $query = "INSERT OR IGNORE INTO Files (id, content, size, mimeType) VALUES (?, ?, ?, ?)";
    $values = [$file->getId(), $file->getContent(), $file->getSize(), $file->getMimeType()];
    $this->db->query($query, $values);
  }

  /**
   * 
   * @param File $file
   */
  public function update($file)
  {
    $query = "UPDATE Files SET content = ?, size = ?, mimeType = ? WHERE id = ?";
    $values = [$file->getContent(), $file->getSize(), $file->getMimeType(), $file->getId()];
    $this->db->query($query, $values);
  }

}
