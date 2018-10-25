<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../vendor/autoload.php');

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

  public static function createCommunicator(): Communicator
  {
    return DEVELOPMENT ? new Echoer() : new Sender();
  }

  public static function createResources(): Resources
  {
    return DEVELOPMENT ? ResourcesSqlite::getInstance() : ResourcesMysql::getInstance();
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

  public static function createChannelDao(): ChannelDao
  {
    return DEVELOPMENT ? ChannelDaoSqlite::getInstance() : ChannelDaoMysql::getInstance();
  }

  public static function createTextMessageDao(): TextMessageDao
  {
    return DEVELOPMENT ? TextMessageDaoSqlite::getInstance() : TextMessageDaoMysql::getInstance();
  }

  public static function createContactDao(): ContactDao
  {
    return DEVELOPMENT ? ContactDaoSqlite::getInstance() : ContactDaoMysql::getInstance();
  }

  public static function createLocationDao(): LocationDao
  {
    return DEVELOPMENT ? LocationDaoSqlite::getInstance() : LocationDaoMysql::getInstance();
  }

  public static function createVenueDao(): VenueDao
  {
    return DEVELOPMENT ? VenueDaoSqlite::getInstance() : VenueDaoMysql::getInstance();
  }

  public static function createPhotoDao(): PhotoDao
  {
    return DEVELOPMENT ? PhotoDaoSqlite::getInstance() : PhotoDaoMysql::getInstance();
  }

  public static function createAudioDao(): AudioDao
  {
    return DEVELOPMENT ? AudioDaoSqlite::getInstance() : AudioDaoMysql::getInstance();
  }

  public static function createStickerDao(): StickerDao
  {
    return DEVELOPMENT ? StickerDaoSqlite::getInstance() : StickerDaoMysql::getInstance();
  }

  public static function createVideoDao(): VideoDao
  {
    return DEVELOPMENT ? VideoDaoSqlite::getInstance() : VideoDaoMysql::getInstance();
  }

  public static function createVideoNoteDao(): VideoNoteDao
  {
    return DEVELOPMENT ? VideoNoteDaoSqlite::getInstance() : VideoNoteDaoMysql::getInstance();
  }

  public static function createDocumentDao(): DocumentDao
  {
    return DEVELOPMENT ? DocumentDaoSqlite::getInstance() : DocumentDaoMysql::getInstance();
  }

  public static function createVoiceDao(): VoiceDao
  {
    return DEVELOPMENT ? VoiceDaoSqlite::getInstance() : VoiceDaoMysql::getInstance();
  }

  public static function createAnimationDao(): AnimationDao
  {
    return DEVELOPMENT ? AnimationDaoSqlite::getInstance() : AnimationDaoMysql::getInstance();
  }

}
