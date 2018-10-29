<?php

/*
 * This file is part of RacFiNordBot,
 * the official Telegram Bot of the Rotaract Club Firenze Nord.
 * 
 * (c) 2018 Rotaract Club Firenze Nord <rotaractfirenzenord@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../vendor/autoload.php');
/**
 * Description of Database
 *
 * @author Daniele Ambrosino
 */
abstract class Database
{

  protected $handle;
  protected static $instance;

  protected abstract function __construct();

  public static function getInstance(): Database
  {
    if ( empty(static::$instance) )
    {
      static::$instance = new static();
    }
    return static::$instance;
  }

  /**
   * 
   * @param string $query
   * @param array $values
   * @return array
   * @throws ErrorException
   */
  public abstract function query(string $query, array $values = NULL): array;
  
  protected abstract function bind(string $query, array $values);

  protected abstract function fetchAll($result): array;
}
