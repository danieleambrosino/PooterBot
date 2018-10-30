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
 * Created: 17-ott-2018
 */

PRAGMA foreign_keys = OFF;
DROP TABLE IF EXISTS `Users`;
DROP TABLE IF EXISTS `Chats`;
DROP TABLE IF EXISTS `Members`;
DROP TABLE IF EXISTS `Messages`;
DROP TABLE IF EXISTS `ChatTypes`;
DROP TABLE IF EXISTS `MessageTypes`;
DROP TABLE IF EXISTS `Files`;
DROP TABLE IF EXISTS `TextMessages`;
DROP TABLE IF EXISTS `Photos`;
DROP TABLE IF EXISTS `Audios`;
DROP TABLE IF EXISTS `Videos`;
DROP TABLE IF EXISTS `Animations`;
DROP TABLE IF EXISTS `Voices`;
DROP TABLE IF EXISTS `VideoNotes`;
DROP TABLE IF EXISTS `Contacts`;
DROP TABLE IF EXISTS `Locations`;
DROP TABLE IF EXISTS `Venues`;
DROP TABLE IF EXISTS `Documents`;
DROP TABLE IF EXISTS `Stickers`;
DROP TABLE IF EXISTS `PrivateChats`;
DROP TABLE IF EXISTS `Groups`;
DROP TABLE IF EXISTS `Supergroups`;
DROP TABLE IF EXISTS `Channels`;
DROP TABLE IF EXISTS `MutedChats`;
DROP TABLE IF EXISTS `ChatTitleChangedEvents`;
DROP TABLE IF EXISTS `ChatPhotoChangedEvents`;
DROP TABLE IF EXISTS `ChatEvents`;
DROP TABLE IF EXISTS `ChatEventTypes`;
PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS ChatTypes (
  `name` TEXT PRIMARY KEY
)
  WITHOUT ROWID;
INSERT INTO ChatTypes
VALUES ('private'),
       ('group'),
       ('supergroup'),
       ('channel');

CREATE TABLE IF NOT EXISTS Chats (
  id     INTEGER PRIMARY KEY,
  `type` TEXT NOT NULL REFERENCES ChatTypes (`name`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE PrivateChats (
  chatId    INTEGER PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  firstName TEXT NOT NULL,
  lastName  TEXT,
  username  TEXT
);

CREATE TABLE Groups (
  chatId INTEGER PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  title  TEXT NOT NULL
);

CREATE TABLE Supergroups (
  chatId   INTEGER PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  `title`  TEXT NOT NULL,
  username TEXT
);

CREATE TABLE Channels (
  chatId   INTEGER PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  title    TEXT NOT NULL,
  username TEXT
);

CREATE TABLE MutedChats (
  chatId INTEGER PRIMARY KEY REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Users (
  id        INTEGER PRIMARY KEY,
  firstName TEXT NOT NULL,
  lastName  TEXT,
  username  TEXT
);
INSERT INTO Users (id, firstName, lastName, username)
VALUES (395202945, 'PooterBot', NULL, 'PooterBot');

CREATE TABLE IF NOT EXISTS Members (
  chatId INTEGER NOT NULL REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  userId INTEGER NOT NULL REFERENCES Users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  PRIMARY KEY (chatId, userId)
);

CREATE TABLE IF NOT EXISTS MessageTypes (
  `name` TEXT PRIMARY KEY
)
  WITHOUT ROWID;
INSERT INTO MessageTypes
VALUES ('text'),
       ('voice'),
       ('photo'),
       ('audio'),
       ('video'),
       ('animation'),
       ('sticker'),
       ('contact'),
       ('location'),
       ('venue'),
       ('videoNote'),
       ('document'),
       ('chatEvent');

CREATE TABLE IF NOT EXISTS Messages (
  id         INTEGER PRIMARY KEY,
  telegramId INTEGER NOT NULL,
  `datetime` INTEGER NOT NULL,
  `type`     TEXT    NOT NULL REFERENCES MessageTypes (`name`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  userId     INTEGER NOT NULL REFERENCES Users (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  chatId     INTEGER NOT NULL REFERENCES Chats (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  UNIQUE (telegramId, chatId)
);

CREATE TABLE IF NOT EXISTS ChatEventTypes (
  `name` TEXT PRIMARY KEY
)
  WITHOUT ROWID;
INSERT INTO ChatEventTypes (`name`)
VALUES ('chatCreated'),
       ('chatMembersAdded'),
       ('chatMemberRemoved'),
       ('chatTitleChanged'),
       ('chatPhotoChanged'),
       ('chatPhotoDeleted');

CREATE TABLE IF NOT EXISTS ChatEvents (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  `type`    TEXT NOT NULL REFERENCES ChatEventTypes (`name`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ChatTitleChangedEvents (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES ChatEvents (messageId)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  chatTitle TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS ChatPhotoChangedEvents (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES ChatEvents (messageId)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  photoId   TEXT NOT NULL REFERENCES Files (id)
);

CREATE TABLE IF NOT EXISTS Files (
  id       TEXT PRIMARY KEY,
  content  BLOB,
  `size`   INTEGER,
  mimeType TEXT
);

CREATE TABLE IF NOT EXISTS TextMessages (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  text      TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Stickers (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER NOT NULL,
  height    INTEGER NOT NULL,
  emoji     TEXT,
  setName   TEXT,
  fileId    TEXT    NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Photos (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER NOT NULL,
  height    INTEGER NOT NULL,
  caption   TEXT,
  fileId    TEXT    NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Audios (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  duration  INTEGER NOT NULL,
  title     TEXT,
  performer TEXT,
  caption   TEXT,
  fileId    TEXT    NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Videos (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER NOT NULL,
  height    INTEGER NOT NULL,
  duration  INTEGER NOT NULL,
  caption   TEXT,
  fileId    TEXT    NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Animations (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  width     INTEGER NOT NULL,
  height    INTEGER NOT NULL,
  duration  INTEGER NOT NULL,
  fileName  TEXT    NOT NULL,
  fileId    TEXT    NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Voices (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  duration  INTEGER NOT NULL,
  caption   TEXT,
  fileId    TEXT    NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS VideoNotes (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  `length`  INTEGER NOT NULL,
  duration  INTEGER NOT NULL,
  fileId    TEXT    NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Contacts (
  messageId   INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  phoneNumber TEXT NOT NULL,
  firstName   TEXT NOT NULL,
  lastName    TEXT,
  userId      INTEGER,
  vcard       TEXT
);

CREATE TABLE IF NOT EXISTS Locations (
  id        INTEGER PRIMARY KEY,
  messageId INTEGER NOT NULL UNIQUE,
  longitude REAL    NOT NULL,
  latitude  REAL    NOT NULL
);

CREATE TABLE IF NOT EXISTS Venues (
  messageId      INTEGER PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  title          TEXT    NOT NULL,
  address        TEXT    NOT NULL,
  fousquareId    TEXT,
  foursquareType TEXT,
  locationId     INTEGER NOT NULL REFERENCES Locations (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Documents (
  messageId INTEGER NOT NULL PRIMARY KEY REFERENCES Messages (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  fileName  TEXT,
  caption   TEXT,
  fileId    TEXT NOT NULL REFERENCES Files (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

-- TRIGGERS
-- -CHAT TRIGGERS
CREATE TRIGGER IF NOT EXISTS PrivateChats_insertChatId_beforeInsert
  BEFORE INSERT
  ON PrivateChats
  FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'private');
END;

CREATE TRIGGER IF NOT EXISTS Groups_insertChatId_beforeInsert
  BEFORE INSERT
  ON Groups
  FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'group');
END;

CREATE TRIGGER IF NOT EXISTS Supergroups_insertChatId_beforeInsert
  BEFORE INSERT
  ON Supergroups
  FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'supergroup');
END;

CREATE TRIGGER IF NOT EXISTS Channels_insertChatId_beforeInsert
  BEFORE INSERT
  ON Channels
  FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`)
  VALUES (NEW.chatId, 'channel');
END;
