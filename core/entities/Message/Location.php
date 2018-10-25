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
 * Description of Location
 *
 * @author Daniele Ambrosino
 */
class Location extends Message
{

  private $latitude;
  private $longitude;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              float $latitude, float $longitude)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->latitude = $latitude;
    $this->longitude = $longitude;
  }

  public function getLatitude()
  {
    return $this->latitude;
  }

  public function getLongitude()
  {
    return $this->longitude;
  }

}
