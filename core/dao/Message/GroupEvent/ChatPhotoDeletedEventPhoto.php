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
 * Description of ChatPhotoDeletedEventPhoto
 *
 * @author Daniele Ambrosino
 */
class ChatPhotoDeletedEventPhoto extends ChatEventDao
{
  
  protected function constructObject(array $data)
  {
    
  }

  public function get(int $id)
  {
    
  }

  /**
   * 
   * @param ChatPhotoDeletedEvent $event
   */
  public function store($event)
  {
    $this->storeChatEventByType($event, 'chatPhotoDeleted');
  }

  public function update($object)
  {
    
  }

}
