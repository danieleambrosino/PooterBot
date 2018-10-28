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
 * Description of Resources
 *
 * @author Daniele Ambrosino
 */
abstract class Resources
{

  protected static $instance;
  protected $db;

  public static function getInstance(): Resources
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }
  
  protected abstract function __construct();
  
  public abstract function getPhoto(string $id): string;
  
  public abstract function getRandomPhoto(): string;
  
  public abstract function getRandomSpeech(): string;
  
  public abstract function getRandomSong(): string;
  
  public abstract function getRandomCityId(): int;
  
  public abstract function getRandomJoke(): string;
  
  public abstract function getRandomProverb(): string;
  
  public abstract function getRandomOpinion(): string;
  
  public abstract function getRandomJudgement(): string;
  
  public abstract function getRandomPhotoComment(): string;

}
