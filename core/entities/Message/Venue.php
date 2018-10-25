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
 * Description of Venue
 *
 * @author Daniele Ambrosino
 */
class Venue extends Message
{

  private $location;
  private $title;
  private $address;
  private $foursquareId;
  private $foursquareType;

  public function __construct(int $id, int $datetime, User &$user, Chat &$chat,
                              Location &$location, string $title,
                              string $address, $foursquareId, $foursquareType)
  {
    parent::__construct($id, $datetime, $user, $chat);
    $this->location = $location;
    $this->title = $title;
    $this->address = $address;
    $this->foursquareId = $foursquareId;
    $this->foursquareType = $foursquareType;
  }

  public function getLocation(): Location
  {
    return $this->location;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getAddress(): string
  {
    return $this->address;
  }

  public function getFoursquareId(): string
  {
    return $this->foursquareId;
  }

  public function getFoursquareType(): string
  {
    return $this->foursquareType;
  }

}
