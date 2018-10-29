/* 
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
/**
 * Author:  Daniele Ambrosino
 * Created: 28-ott-2018
 */

CREATE TABLE IF NOT EXISTS Chats (
  id   BIGINT PRIMARY KEY,
  type ENUM ('private', 'group', 'supergroup', 'channel') NOT NULL
  COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS PrivateChats (
  chatId    BIGINT PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  firstName VARCHAR(128) NOT NULL
  COLLATE utf8mb4_bin,
  lastName  VARCHAR(128) COLLATE utf8mb4_bin,
  username  VARCHAR(32) COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS Groups (
  chatId BIGINT PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  title  VARCHAR(128) NOT NULL
  COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS Supergroups (
  chatId   BIGINT PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  title    VARCHAR(128) NOT NULL
  COLLATE utf8mb4_bin,
  username VARCHAR(32) COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS Channels (
  chatId   BIGINT PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  title    VARCHAR(128) NOT NULL
  COLLATE utf8mb4_bin,
  username VARCHAR(32) COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE MutedChats (
  chatId BIGINT PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS Users (
  id        INTEGER PRIMARY KEY,
  firstName VARCHAR(128) NOT NULL
  COLLATE utf8mb4_bin,
  lastName  VARCHAR(128) COLLATE utf8mb4_bin,
  username  VARCHAR(32) COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;
INSERT INTO Users (id, firstName, lastName, username)
VALUES (395202945, 'PooterBot', NULL, 'PooterBot');


CREATE TABLE IF NOT EXISTS Members (
  chatId BIGINT NOT NULL REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  userId INTEGER NOT NULL REFERENCES Users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  PRIMARY KEY (chatId, userId)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS Messages (
  id       INTEGER PRIMARY KEY,
  datetime INTEGER NOT NULL,
  `type`   ENUM (
    'text',
    'voice',
    'photo',
    'audio',
    'video',
    'animation',
    'sticker',
    'contact',
    'location',
    'venue',
    'videoNote',
    'document',
    'chatEvent')   NOT NULL,
  userId   INTEGER NOT NULL REFERENCES Users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  chatId   BIGINT NOT NULL REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS ChatEvents (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  type      ENUM (
    'chatCreated',
    'chatMembersAdded',
    'chatMemberRemoved',
    'chatTitleChanged',
    'chatPhotoChanged',
    'chatPhotoDeleted'
  ) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS Files (
  id       VARCHAR(128) PRIMARY KEY,
  content  MEDIUMBLOB,
  size     INTEGER,
  mimeType VARCHAR(32)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS ChatTitleChangedEvents (
  messageId INTEGER PRIMARY KEY REFERENCES ChatEvents (messageId)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  chatTitle VARCHAR(128) NOT NULL
  COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS ChatPhotoChangedEvents (
  messageId INTEGER PRIMARY KEY REFERENCES ChatEvents (messageId)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  photoId   VARCHAR(128) NOT NULL REFERENCES Files (id)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;


CREATE TABLE IF NOT EXISTS TextMessages (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  text      VARCHAR(4096) NOT NULL
  COLLATE utf8mb4_bin
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Stickers (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER      NOT NULL,
  height    INTEGER      NOT NULL,
  emoji     CHAR(4) COLLATE utf8mb4_bin,
  setName   VARCHAR(32) COLLATE utf8mb4_bin,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Photos (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER      NOT NULL,
  height    INTEGER      NOT NULL,
  caption   VARCHAR(1024) COLLATE utf8mb4_bin,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Audios (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  duration  INTEGER      NOT NULL,
  title     VARCHAR(128) COLLATE utf8mb4_bin,
  performer VARCHAR(128) COLLATE utf8mb4_bin,
  caption   VARCHAR(1024) COLLATE utf8mb4_bin,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Videos (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER      NOT NULL,
  height    INTEGER      NOT NULL,
  duration  INTEGER      NOT NULL,
  caption   VARCHAR(1024) COLLATE utf8mb4_bin,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Animations (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER      NOT NULL,
  height    INTEGER      NOT NULL,
  duration  INTEGER      NOT NULL,
  fileName  VARCHAR(128) NOT NULL
  COLLATE utf8mb4_bin,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Voices (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  duration  INTEGER      NOT NULL,
  caption   VARCHAR(1024) COLLATE utf8mb4_bin,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS VideoNotes (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  `length`  INTEGER      NOT NULL,
  duration  INTEGER      NOT NULL,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Contacts (
  messageId   INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  phoneNumber VARCHAR(32) NOT NULL,
  firstName   VARCHAR(32) NOT NULL
  COLLATE utf8mb4_bin,
  lastName    VARCHAR(32) COLLATE utf8mb4_bin,
  userId      INTEGER,
  vcard       VARCHAR(128)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Locations (
  id        INTEGER PRIMARY KEY,
  messageId INTEGER NOT NULL UNIQUE REFERENCES Messages (id),
  longitude FLOAT   NOT NULL,
  latitude  FLOAT   NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Venues (
  messageId      INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  title          VARCHAR(128) NOT NULL,
  address        VARCHAR(128) NOT NULL,
  fousquareId    VARCHAR(128),
  foursquareType VARCHAR(128),
  locationId     INTEGER      NOT NULL REFERENCES Locations (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

CREATE TABLE IF NOT EXISTS Documents (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  fileName  VARCHAR(128) NOT NULL,
  caption   VARCHAR(1024) COLLATE utf8mb4_bin,
  fileId    VARCHAR(128) NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_bin;

-- TRIGGERS

CREATE TRIGGER PrivateChats_insertChatId_beforeInsert
  BEFORE INSERT
  ON PrivateChats
  FOR EACH ROW
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'private');

CREATE TRIGGER Groups_insertChatId_beforeInsert
  BEFORE INSERT
  ON Groups
  FOR EACH ROW
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'group');

CREATE TRIGGER Supergroups_insertChatId_beforeInsert
  BEFORE INSERT
  ON Supergroups
  FOR EACH ROW
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'supergroup');

CREATE TRIGGER Channels_insertChatId_beforeInsert
  BEFORE INSERT
  ON Channels
  FOR EACH ROW
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'channel');
