<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once realpath(__DIR__ . '/../../../vendor/autoload.php');

/**
 * Description of MessageDao
 *
 * @author Daniele Ambrosino
 */
abstract class MessageDao extends Dao
{

  /**
   * 
   * @param Message $message
   */
  public function delete($message)
  {
    $query = "DELETE FROM Messages WHERE id = ?";
    $values = [$message->getId()];
    $this->db->query($query, $values);
  }

  protected final function storeMessageByType(Message $message, string $type)
  {
    $query = "INSERT INTO Messages (id, datetime, type, userId, chatId) VALUES (?, ?, ?, ?, ?)";
    $values = [$message->getId(), $message->getDatetime(), $type, $message->getUser()->getId(), $message->getChat()->getId()];
    $this->db->query($query, $values);
  }

  public static final function getAllMessages(int $chatId)
  {
    $db = Factory::createDatabase();
    $query = <<<SQL
WITH ContentTable (id, datetime, chatId, userId, type, content) AS
(
  SELECT
    M.id,
    M.datetime,
    M.chatId,
    M.userId,
    M.type,
    TM.text AS content
  FROM Messages M
    JOIN TextMessages TM on M.id = TM.messageId
  UNION
  SELECT
    M2.id,
    M2.datetime,
    M2.chatId,
    M2.userId,
    M2.type,
    P.fileId AS content
  FROM Messages M2
    JOIN Photos P on M2.id = P.messageId
  UNION
  SELECT
    M3.id,
    M3.datetime,
    M3.chatId,
    M3.userId,
    M3.type,
    A.fileId AS content
  FROM Messages M3
     JOIN Animations A on M3.id = A.messageId
  UNION
  SELECT
    M4.id,
    M4.datetime,
    M4.chatId,
    M4.userId,
    M4.type,
    A2.fileId AS content
  FROM Messages M4
    JOIN Audios A2 on M4.id = A2.messageId
  UNION
  SELECT
    M5.id,
    M5.datetime,
    M5.chatId,
    M5.userId,
    M5.type,
    C.firstName || ' ' || C.lastName || ', ' || C.phoneNumber AS content
  FROM Messages M5
    JOIN Contacts C on M5.id = C.messageId
  UNION
  SELECT
    M6.id,
    M6.datetime,
    M6.chatId,
    M6.userId,
    M6.type,
    D.fileId AS content
  FROM Messages M6
    JOIN Documents D on M6.id = D.messageId
  UNION
  SELECT
    M7.id,
    M7.datetime,
    M7.chatId,
    M7.userId,
    M7.type,
    L.latitude || ', ' || L.longitude AS content
  FROM Messages M7
    JOIN Locations L ON M7.id = L.messageId
  UNION
  SELECT
    M8.id,
    M8.datetime,
    M8.chatId,
    M8.userId,
    M8.type,
    S.fileId AS content
  FROM Messages M8
    JOIN Stickers S on M8.id = S.messageId
  UNION
  SELECT
    M9.id,
    M9.datetime,
    M9.chatId,
    M9.userId,
    M9.type,
    V.address AS content
  FROM Messages M9
    JOIN Venues V on M9.id = V.messageId
  UNION
  SELECT
    M10.id,
    M10.datetime,
    M10.chatId,
    M10.userId,
    M10.type,
    VN.fileId AS content
  FROM Messages M10
    JOIN VideoNotes VN on M10.id = VN.messageId
  UNION
  SELECT
    M11.id,
    M11.datetime,
    M11.chatId,
    M11.userId,
    M11.type,
    V2.fileId AS content
  FROM Messages M11
    JOIN Videos V2 on M11.id = V2.messageId
  UNION
  SELECT
    M12.id,
    M12.datetime,
    M12.chatId,
    M12.userId,
    M12.type,
    V3.fileId AS content
  FROM Messages M12
    JOIN Voices V3 on M12.id = V3.messageId
)
SELECT
  strftime('%d/%m/%Y %H:%M:%S', CT.datetime, 'unixepoch') AS datetime,
  U.firstName,
  U.lastName,
  U.username,
  CT.type,
  CT.content
FROM ContentTable CT
  JOIN Users U ON userId = U.id
WHERE chatId = ?
ORDER BY datetime ASC;
SQL;
    $values = [$chatId];
    return $db->query($query, $values);
  }

}
