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
 * Description of ResourcesSqlite
 *
 * @author Daniele Ambrosino
 */
class ResourcesSqlite extends Resources
{

  protected function __construct()
  {
    $this->db = Factory::createDatabase();
    $path = DATABASE_RESOURCES_PATH;
    $this->db->query("ATTACH '$path' AS resources");
  }

  public function getPhoto(string $id): string
  {
    $query = "SELECT fileId FROM PhotoResources WHERE id = '$id'";
    return $this->db->query($query)[0]['fileId'];
  }

  public function getRandomPhoto(): string
  {
    $query = "SELECT fileId FROM PhotoResources ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['fileId'];
  }

  public function getRandomSpeech(): string
  {
    $query = "SELECT fileId FROM Speeches ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['fileId'];
  }

  public function getRandomSong(): string
  {
    $query = "SELECT fileId FROM Songs ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['fileId'];
  }

  public function getRandomCityId(): int
  {
    $query = "SELECT id FROM Cities ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['id'];
  }

  public function getRandomJoke(): string
  {
    $query = "SELECT text FROM Jokes ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['text'];
  }

  public function getRandomProverb(): string
  {
    $query = "SELECT text FROM Proverbs ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['text'];
  }

  public function getRandomOpinion(): string
  {
    $query = "SELECT text FROM Opinions ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['text'];
  }

  public function getRandomJudgement(): string
  {
    $query = "SELECT text FROM Judgements ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['text'];
  }

  public function getRandomPhotoComment(): string
  {
    $query = "SELECT text FROM PhotoComments ORDER BY random() LIMIT 1";
    return $this->db->query($query)[0]['text'];
  }

}
