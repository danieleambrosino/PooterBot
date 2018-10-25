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

}
