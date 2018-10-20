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
 * Description of Factory
 *
 * @author Daniele Ambrosino
 */
class Factory
{
  
  public static function createDatabase(): Database
  {
    return DEVELOPMENT ? DatabaseSqlite::getInstance() : DatabaseMysql::getInstance();
  }
  
  public static function createResources(): Resources
  {
    return Resources::getInstance();
  }

  public static function createUserDao(): UserDao
  {
    return DEVELOPMENT ? UserDaoSqlite::getInstance() : UserDaoMysql::getInstance();
  }

  public static function createPrivateChatDao(): PrivateChatDao
  {
    return DEVELOPMENT ? PrivateChatDaoSqlite::getInstance() : PrivateChatDaoMysql::getInstance();
  }

  public static function createGroupDao(): GroupDao
  {
    return DEVELOPMENT ? GroupDaoSqlite::getInstance() : GroupDaoMysql::getInstance();
  }

  public static function createSupergroupDao(): SupergroupDao
  {
    return DEVELOPMENT ? SupergroupDaoSqlite::getInstance() : SupergroupDaoMysql::getInstance();
  }

  public static function createChannelDao()
  {
    
  }

  public static function createTextMessageDao()
  {
    
  }

  public static function createContactDao()
  {
    
  }

  public static function createLocationDao(){}

  public static function createVenueDao(){}

  public static function createPhotoDao(){}

  public static function createAudioDao(){}

  public static function createStickerDao(){}

  public static function createVideoDao(){}

  public static function createVideoNoteDao(){}

  public static function createDocumentDao(){}

  public static function createVoiceDao(){}

  public static function createAnimationDao(){}
}
