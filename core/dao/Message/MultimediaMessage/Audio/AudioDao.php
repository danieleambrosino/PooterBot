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
 * Description of AudioDao
 *
 * @author Daniele Ambrosino
 */
abstract class AudioDao extends MultimediaMessageDao
{

  protected static $instance;

  public static function getInstance()
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }

  protected function constructObject(array $data)
  {
    
  }

  public function get($id)
  {
    
  }

  public function update($object)
  {
    
  }

}
