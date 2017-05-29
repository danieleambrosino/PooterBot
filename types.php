<?php
/**
 * Created by IntelliJ IDEA.
 * User: dani
 * Date: 29/05/17
 * Time: 16.45
 */

abstract class MessageType {
  const TEXT = 0;
  const PHOTO = 1;
  const AUDIO = 2;
  const DOCUMENT = 3;
  const STICKER = 4;
  const VOICE = 5;
  const VIDEO = 6;
  const VIDEO_NOTE = 7;
  const CONTACT = 8;
  const LOCATION = 9;
}

abstract class ChatType {
  const PRIVATE_CHAT = 0;
  const GROUP = 1;
  const SUPERGROUP = 2;
  const CHANNEL = 3;
}