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
 * Description of File
 *
 * @author Daniele Ambrosino
 */
class File
{

  /**
   *
   * @var string
   */
  private $id;
  private $content;
  private $size;
  private $mimeType;

  public function __construct(string $id, $size, $mimeType)
  {
    $this->id = $id;
    $this->content = "";
    $this->size = $size;
    $this->mimeType = $mimeType;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getContent()
  {
    if ( empty($this->content) )
    {
      $this->loadContent();
    }
    return $this->content;
  }

  public function getSize()
  {
    return $this->size;
  }

  public function getMimeType()
  {
    return $this->mimeType;
  }

  public function setContent($content)
  {
    $this->content = $content;
  }

  private function loadContent()
  {
    $fileDao = Factory::createFileDao();
    $content = $fileDao->getContent($this->id);
    if ( empty($content) )
    {
      $this->content = FileDownloader::downloadFile($this->id);
    }
    else
    {
      $this->content = $content;
    }
  }

}
