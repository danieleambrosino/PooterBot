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
 * Description of ChatPhotoChangedEventDao
 *
 * @author Daniele Ambrosino
 */
class ChatPhotoChangedEventDao extends ChatEventDao
{

  protected static $instance;
  protected $fileDao;

  public static function getInstance()
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }
  
  protected function __construct()
  {
    parent::__construct();
    $this->fileDao = Factory::createFileDao();
  }

  protected function constructObject(array $data)
  {
    
  }

  public function get($id)
  {
    
  }

  /**
   * 
   * @param ChatPhotoChangedEvent $event
   */
  public function store($event)
  {
    $this->db->query('BEGIN TRANSACTION');
    $this->storeChatEventByType($event, 'chatPhotoChanged');
    $this->fileDao->store($event->getNewPhoto());
    $query = "INSERT INTO ChatPhotoChangedEvents (messageId, photoId) VALUES (?, ?)";
    $values = [$event->getId(), $event->getNewPhoto()->getId()];
    $this->db->query($query, $values);
    $this->db->query('COMMIT');
  }

  public function update($object)
  {
    
  }

}
