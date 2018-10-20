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
DROP TABLE IF EXISTS `PhotoResources`;
DROP TABLE IF EXISTS `Cities`;
DROP TABLE IF EXISTS `Jokes`;
DROP TABLE IF EXISTS `Proverbs`;
DROP TABLE IF EXISTS `Opinions`;
DROP TABLE IF EXISTS `Judgements`;
DROP TABLE IF EXISTS `PhotoComments`;
DROP TABLE IF EXISTS `Speeches`;
DROP TABLE IF EXISTS `Songs`;
DROP TABLE IF EXISTS `Stickers`;
DROP TABLE IF EXISTS `PrivateChats`;
DROP TABLE IF EXISTS `Groups`;
DROP TABLE IF EXISTS `Supergroups`;
DROP TABLE IF EXISTS `Channels`;
DROP TABLE IF EXISTS `FemaleNames`;
DROP TABLE IF EXISTS `MutedChats`;
PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS ChatTypes (
  `name` TEXT PRIMARY KEY
) WITHOUT ROWID;
INSERT INTO ChatTypes VALUES
('private'),
('group'),
('supergroup'),
('channel');

CREATE TABLE IF NOT EXISTS Chats (
  id INTEGER PRIMARY KEY,
  `type` TEXT NOT NULL REFERENCES ChatTypes (`name`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE PrivateChats (
  chatId INTEGER PRIMARY KEY REFERENCES Chats (id) ON UPDATE CASCADE ON DELETE CASCADE,
  firstName TEXT NOT NULL,
  lastName TEXT,
  username TEXT
);

CREATE TABLE Groups (
  chatId INTEGER PRIMARY KEY REFERENCES Chats (id) ON UPDATE CASCADE ON DELETE CASCADE,
  title TEXT NOT NULL
);

CREATE TABLE Supergroups (
  chatId INTEGER PRIMARY KEY REFERENCES Chats (id) ON UPDATE CASCADE ON DELETE CASCADE,
  `title` TEXT NOT NULL,
  username TEXT
);

CREATE TABLE Channels (
  chatId INTEGER PRIMARY KEY REFERENCES Chats (id) ON UPDATE CASCADE ON DELETE CASCADE,
  title TEXT NOT NULL,
  username TEXT
);

CREATE TABLE MutedChats (
  chatId INTEGER PRIMARY KEY REFERENCES Chats (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Users (
  id INTEGER PRIMARY KEY,
  firstName TEXT NOT NULL,
  lastName TEXT,
  username TEXT
);

CREATE TABLE IF NOT EXISTS Participants (
  chatId INTEGER NOT NULL REFERENCES Chats (id) ON UPDATE CASCADE ON DELETE CASCADE,
  userId INTEGER NOT NULL REFERENCES Users (id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (chatId, userId)
);

CREATE TABLE IF NOT EXISTS MessageTypes (
  `name` TEXT PRIMARY KEY
) WITHOUT ROWID;
INSERT INTO MessageTypes VALUES
('text'),
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
('document');

CREATE TABLE IF NOT EXISTS Messages (
  id INTEGER PRIMARY KEY,
  `datetime` TEXT NOT NULL,
  `type` TEXT NOT NULL REFERENCES MessageTypes (`name`) ON UPDATE CASCADE ON DELETE CASCADE,
  userId INTEGER NOT NULL REFERENCES Users (id) ON UPDATE CASCADE ON DELETE CASCADE,
  chatId INTEGER NOT NULL REFERENCES Chats (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Files (
  id TEXT PRIMARY KEY,
  content BLOB,
  `size` INTEGER,
  mimeType TEXT
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS TextMessages (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  text TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Stickers (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  width INTEGER NOT NULL,
  height INTEGER NOT NULL,
  emoji TEXT,
  setName TEXT,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Photos (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  width INTEGER NOT NULL,
  height INTEGER NOT NULL,
  caption TEXT,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Audios (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  duration INTEGER NOT NULL,
  title TEXT,
  performer TEXT,
  caption TEXT,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Videos (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  width INTEGER NOT NULL,
  height INTEGER NOT NULL,
  duration INTEGER NOT NULL,
  caption TEXT,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Animations (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  width INTEGER NOT NULL,
  height INTEGER NOT NULL,
  duration INTEGER NOT NULL,
  fileName TEXT NOT NULL,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Voices (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  duration INTEGER NOT NULL,
  caption TEXT,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS VideoNotes (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  `length` INTEGER NOT NULL,
  duration INTEGER NOT NULL,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Contacts (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  phoneNumber TEXT NOT NULL,
  firstName TEXT NOT NULL,
  lastName TEXT,
  userId INTEGER,
  vcard TEXT
);

CREATE TABLE IF NOT EXISTS Locations (
  id INTEGER PRIMARY KEY,
  messageId INTEGER NOT NULL UNIQUE,
  longitude REAL NOT NULL,
  latitude REAL NOT NULL
);

CREATE TABLE IF NOT EXISTS Venues (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  title TEXT NOT NULL,
  address TEXT NOT NULL,
  fousquareId TEXT,
  foursquareType TEXT,
  locationId INTEGER NOT NULL REFERENCES Locations (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Documents (
  messageId INTEGER PRIMARY KEY REFERENCES Messages (id) ON UPDATE CASCADE ON DELETE CASCADE,
  fileName INTEGER,
  caption TEXT,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- RESOURCES

CREATE TABLE IF NOT EXISTS PhotoResources (
  id TEXT PRIMARY KEY,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITHOUT ROWID;


CREATE TABLE IF NOT EXISTS Speeches (
  id TEXT PRIMARY KEY,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS Songs (
  id TEXT PRIMARY KEY,
  fileId TEXT NOT NULL REFERENCES Files (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS Cities (
  `name` TEXT PRIMARY KEY
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS Jokes (
  `text` TEXT PRIMARY KEY
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS Proverbs (
  `text` TEXT PRIMARY KEY
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS Opinions (
  `text` TEXT PRIMARY KEY
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS Judgements (
  `text` TEXT PRIMARY KEY
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS PhotoComments (
  `text` TEXT PRIMARY KEY
) WITHOUT ROWID;

CREATE TABLE IF NOT EXISTS FemaleNames (
  `name` TEXT PRIMARY KEY
) WITHOUT ROWID;

-- TRIGGERS

CREATE TRIGGER IF NOT EXISTS PrivateChats_insertChatId_beforeInsert
BEFORE INSERT ON PrivateChats
FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`) VALUES (NEW.messageId, 'private');
END;

CREATE TRIGGER IF NOT EXISTS Groups_insertChatId_beforeInsert
BEFORE INSERT ON Groups
FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`) VALUES (NEW.messageId, 'group');
END;

CREATE TRIGGER IF NOT EXISTS Supergroups_insertChatId_beforeInsert
BEFORE INSERT ON Supergroups
FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`) VALUES (NEW.messageId, 'supergroup');
END;

CREATE TRIGGER IF NOT EXISTS Channels_insertChatId_beforeInsert
BEFORE INSERT ON Channels
FOR EACH ROW
BEGIN
  INSERT INTO Chats (id, `type`) VALUES (NEW.messageId, 'channel');
END;

CREATE TRIGGER IF NOT EXISTS PhotoResources_insertFileId_beforeInsert
BEFORE INSERT ON PhotoResources
FOR EACH ROW
BEGIN
  INSERT INTO Files (id) VALUES (NEW.fileId);
END;

CREATE TRIGGER IF NOT EXISTS Speeches_insertFileId_beforeInsert
BEFORE INSERT ON Speeches
FOR EACH ROW
BEGIN
  INSERT INTO Files (id) VALUES (NEW.fileId);
END;

CREATE TRIGGER IF NOT EXISTS Songs_insertFileId_beforeInsert
BEFORE INSERT ON Songs
FOR EACH ROW
BEGIN
  INSERT INTO Files (id) VALUES (NEW.fileId);
END;

-- DATA

INSERT INTO PhotoResources (id, fileId) VALUES
('rugby', 'AgADBAADRKkxGzn7-VAjJrMG6scndNWMuxkABGNtHsrxnyBOJysBAAEC'),
('intenso', 'AgADBAADR6kxGzn7-VBUBMOaS-y26OfJnhkABBhGeuQ5-mma5FoEAAEC'),
('linguaccia', 'AgADBAADGakxG0EyCFGAkt-oPjv8GqNrmxkABHaZp0cgZuKvbmAEAAEC'),
('filosofia', 'AgADBAADGqkxG0EyCFG4sm1oqFa0fBLnnxkABGk_yfNNlWpb6WUEAAEC'),
('sociale', 'AgADBAADG6kxG0EyCFHcuocSdX-pfcjWnBkABMBjO6Rh8bYfrFgEAAEC'),
('evil', 'AgADBAADHKkxG0EyCFGGD1Pgnh6Fmz0AAb0ZAAShfA5vbTv5tms3AQABAg'),
('hooligan', 'AgADBAADMaoxGwJlEVFlm6cmRDZVWV51mxkABPJAlMffzG8bZGcEAAEC'),
('caschetto', 'AgADBAADzagxG09xGFGgt-QvRKw20QTmnxkABELGH8Fe93p0a2kEAAEC'),
('donna', 'AgADBAAD1KgxG09xGFFhmilQ01jlD6ZkqRkABENvTwYiKKi0Eq0BAAEC'),
('olmo', 'AgADBAAD16gxG09xGFEnfKKKMsxpaVimuxkABD9pYMaIW39cSUIBAAEC'),
('sergio_brio', 'AgADBAADxqgxG3sfIVENltTMCQQs5j9KuxkABPt2tL9OyLESg0EBAAEC');

INSERT INTO Speeches (id, fileId) VALUES
('esatto', 'AwADBAADEwEAAk-rYVFJ4vECDuLzJQI'),
('somebody', 'AwADBAADFAEAAk-rYVFyXdKkQimdpAI'),
('somebody_poesia', 'AwADBAADFQEAAk-rYVFQWqetvlT71gI'),
('allucinazioni', 'AwADBAADFgEAAk-rYVG_x599FffrNwI'),
('delirio1', 'AwADBAADHwEAAk-rYVGQ1P9swKylxAI'),
('reflections', 'AwADBAADIAEAAk-rYVGvbgt2Dgc4egI'),
('delirio2', 'AwADBAADIQEAAk-rYVHpLsH7DHxrBAI'),
('english_reflections', 'AwADBAADIgEAAk-rYVHvZta-RnFYogI'),
('ruggito', 'AwADBAADEQEAAk-rYVGqSDFbkF5YJwI'),
('fantasia_potenza', 'AwADBAADEAEAAk-rYVHxjRG3s8hRogI'),
('magico', 'AwADBAADDwEAAk-rYVH8yZwt5mEWpwI'),
('sergio_brio', 'AwADBAADCgEAAk-rYVGvbZpjP5UEmAI'),
('most_famous', 'AwADBAADCQEAAk-rYVGodJALE2_0owI'),
('avventurosa', 'AwADBAADBgEAAk-rYVHTcFJ5z_hXNwI'),
('romagnolo', 'AwADBAADBwEAAk-rYVHej38x5nECogI'),
('zampino', 'AwADBAADBQEAAk-rYVHqF1j_TDjzMAI');

INSERT INTO Songs (id, fileId) VALUES
('tempo_cattedrali', 'AwADBAADFwEAAk-rYVHPx0beI6ewEQI'),
('stranieri', 'AwADBAADGAEAAk-rYVEihOZVNCQDdAI'),
('corte_miracoli', 'AwADBAADHgEAAk-rYVEx2Nikwfdh1QI');

INSERT INTO Jokes (`text`) VALUES
('Due gamberetti si incontrano a un party ed uno si accorge che l''altro è un po'' triste e gli chiede:\n-"Che cosa c''è?"\n-"No niente"'),
('Una tartaruga, dopo aver battuto la testa contro un albero si confida con un''amica:\n-"Spero che... che la... sgusa, anzi, prego..."\nNon me la ricordo più'),
('-"Voto inglese"?\n-"Ottimo"\n-"Ok... traduca ''capire le donne''\n-"Somebody"'),
('Che cosa fa un pittore al polo nord? Io non lo so'),
('Tua madre è cosi troia che quando le dico... no cioè, quando non le dico... che poi tua madre non è troia... capito? Sto scherzando amico mio!'),
('Il commendator Colombo Ernesto va in Africa a caccia di leoni nella savana. Mentre è acquattato con il fucile in mano nel più completo silenzio, si sente toccare su una spalla e, giratosi di scatto, vede un negro tutto nudo, alto e muscoloso che gli grida: "SOOOOMEBOOOOODY"'),
('Nella sala d''attesa dello studio di un dottore c''è una lunghissima fila. I pazienti si consultano tra di loro, un paziente dice: "io mi sono rotto un braccio" ed un altro: "io mi sono rotto una gamba" e l''ultimo paziente: "SOOOOMEBOOOOODY"');

INSERT INTO Cities (`name`) VALUES
('Bangkok'),
('Pyongyang'),
('Kuala Lumpur'),
('Reykjavik'),
('Beirut'),
('Kabul'),
('Kathmandu'),
('Jakarta'),
('Tehran'),
('Baghdad'),
('Caracas'),
('Quito'),
('La Vella'),
('Brazzaville'),
('Minsk'),
('Glasgow'),
('Dakar'),
('Bissau'),
('Cusco'),
('Antananarivo'),
('Male'),
('Pita Kotte');

INSERT INTO Proverbs (`text`) VALUES
('A buon intenditor ogni scherzo vale'),
('A carnevale poche parole'),
('Al cuor, che si vinca o che si perda, si fa il mare'),
('A mali estremi, Pasqua con chi vuoi'),
('Campa cavallo che il buon sangue batte il ferro finché è caldo'),
('Chi ben comincia, disperato muore'),
('Chi disprezza ed è causa del suo mal, non fa errori'),
('Chi dorme non lascia la via vecchia per la nuova'),
('Chi di spada ferisce è per gli altri un trastullo'),
('Can che abbaia non prende lezioni'),
('Chi la fa sa quel che lascia ma non piglia pesci'),
('Chi nasce tondo raccoglie solo rabbia'),
('Chi non muore non rosica'),
('Chi non risica si rivede'),
('Chiodo scaccia chi ti accarezza oltre quel che suole'),
('Chi va piano va con lo zoppo e impara a toccare il fuoco');

INSERT INTO Opinions (`text`) VALUES
('Somebody'),
('A me piace'),
('Sono d''accordissimo'),
('Ma cosa dici, amico mio'),
('Eh! Eh! No dai scherzo amico mio'),
('Hai assolutamente ragione, amico mio'),
('Heh... non so che dirti amico mio...'),
('Secondo me sì'),
('Secondo me no'),
('Secondo me sbaglia'),
('Secondo me è giusto'),
('Secondo me... Somebody'),
('Secondo me è giustissimo così'),
('Secondo me... non lo so amico mio'),
('Secondo me non è tanto vero, amico mio'),
('Secondo me fa schifo... ahah dai scherzavo amico mio');

INSERT INTO Judgements (`text`) VALUES
('No'),
('Proprio per nulla amico mio'),
('Senza offesa amico mio ma fa proprio schifo'),
('Può andare'),
('Non è male'),
('Sì'),
('Mi piace'),
('Mi piace molto amico mio'),
('Amico mio, non avrei saputo fare di meglio'),
('È incredibile, quasi quanto te, caro amico mio');

INSERT INTO PhotoComments (`text`) VALUES
('Questa foto non mi piace amico mio'),
('Questa foto non mi piace proprio per nulla amico mio'),
('Senza offesa amico mio ma questa foto fa proprio schifo'),
('Bella foto amico mio'),
('Mi piace questa foto, si vede che hai il palato fino amico mio'),
('Mi piace molto amico mio, sei un grande'),
('Amico mio, non avrei saputo fare di meglio'),
('Questa foto è incredibile quasi quanto te, caro amico mio');

INSERT INTO FemaleNames (`name`) VALUES
('abbondanza'),
('acilia'),
('ada'),
('adalberta'),
('adalgisa'),
('addolorata'),
('adelaide'),
('adelasia'),
('adele'),
('adelina'),
('adina'),
('adria'),
('adriana'),
('agape'),
('agata'),
('agnese'),
('agostina'),
('aida'),
('alba'),
('alberta'),
('albina'),
('alcina'),
('alda'),
('alessandra'),
('alessia'),
('alfonsa'),
('alfreda'),
('alice'),
('alida'),
('alina'),
('allegra'),
('alma'),
('altea'),
('amalia'),
('amanda'),
('amata'),
('ambra'),
('amelia'),
('amina'),
('anastasia'),
('anatolia'),
('ancilla'),
('andromeda'),
('angela'),
('angelica'),
('anita'),
('anna'),
('annabella'),
('annagrazia'),
('annamaria'),
('annunziata'),
('antea'),
('antonella'),
('antonia'),
('apollina'),
('apollonia'),
('appia'),
('arabella'),
('argelia'),
('arianna'),
('armida'),
('artemisa'),
('asella'),
('asia'),
('assunta'),
('astrid'),
('atanasia'),
('aurelia'),
('aurora'),
('ausilia'),
('ausiliatrice'),
('ave'),
('aza'),
('azelia'),
('azzurra'),
('babila'),
('bambina'),
('barbara'),
('bartolomea'),
('basilia'),
('bassilla'),
('batilda'),
('beata'),
('beatrice'),
('belina'),
('benedetta'),
('beniamina'),
('benigna'),
('benvenuta'),
('berenice'),
('bernadetta'),
('betta'),
('bianca'),
('bibiana'),
('bice'),
('brigida'),
('brigitta'),
('bruna'),
('brunilde'),
('calogera'),
('calpurnia'),
('camelia'),
('camilla'),
('candida'),
('capitolina'),
('carina'),
('carla'),
('carlotta'),
('carmela'),
('carmen'),
('carola'),
('carolina'),
('casilda'),
('casimira'),
('cassandra'),
('cassiopea'),
('catena'),
('caterina'),
('cecilia'),
('celeste'),
('celinia'),
('chiara'),
('cinzia'),
('cirilla'),
('clara'),
('claudia'),
('clelia'),
('clemenzia'),
('cleo'),
('cleofe'),
('cleopatra'),
('cloe'),
('clorinda'),
('cointa'),
('colomba'),
('concetta'),
('consolata'),
('cora'),
('cordelia'),
('corinna'),
('cornelia'),
('cosima'),
('costanza'),
('crescenzia'),
('cristiana'),
('cristina'),
('crocefissa'),
('cronida'),
('cunegonda'),
('cuzia'),
('dafne'),
('dalida'),
('dalila'),
('damiana'),
('daniela'),
('daria'),
('deanna'),
('debora'),
('degna'),
('delfina'),
('delia'),
('delinda'),
('delizia'),
('demetria'),
('deodata'),
('desdemona'),
('desiderata'),
('devota'),
('diamante'),
('diana'),
('dianora'),
('diletta'),
('dina'),
('diodata'),
('dionisia'),
('doda'),
('dolores'),
('domenica'),
('donata'),
('donatella'),
('donna'),
('dora'),
('dorotea'),
('druina'),
('dulina'),
('ebe'),
('edda'),
('edelberga'),
('editta'),
('edvige'),
('egizia'),
('egle'),
('elaide'),
('elda'),
('elena'),
('eleonora'),
('elettra'),
('eliana'),
('elide'),
('elimena'),
('elisa'),
('elisabetta'),
('elisea'),
('ella'),
('eloisa'),
('elsa'),
('elvia'),
('elvira'),
('emanuela'),
('emilia'),
('emiliana'),
('emma'),
('enimia'),
('enrica'),
('eracla'),
('ermelinda'),
('ermenegarda'),
('ermenegilda'),
('erminia'),
('ernesta'),
('ersilia'),
('esmeralda'),
('estella'),
('ester'),
('esterina'),
('eufemia'),
('eufrasia'),
('eugenia'),
('eulalia'),
('euridice'),
('eusebia'),
('eutalia'),
('eva'),
('evangelina'),
('evelina'),
('fabiana'),
('fabiola'),
('fatima'),
('fausta'),
('federica'),
('fedora'),
('felicia'),
('felicita'),
('fernanda'),
('fiammetta'),
('filippa'),
('filomena'),
('fiordaliso'),
('fiore'),
('fiorella'),
('fiorenza'),
('flaminia'),
('flavia'),
('flaviana'),
('flora'),
('floriana'),
('floridia'),
('florina'),
('foca'),
('fortunata'),
('fosca'),
('franca'),
('francesca'),
('fulvia'),
('gabriella'),
('gaia'),
('galatea'),
('gaudenzia'),
('gelsomina'),
('geltrude'),
('gemma'),
('generosa'),
('genesia'),
('genoveffa'),
('germana'),
('gertrude'),
('ghita'),
('giacinta'),
('giada'),
('gigliola'),
('gilda'),
('giliola'),
('ginevra'),
('gioacchina'),
('gioconda'),
('gioia'),
('giorgia'),
('giovanna'),
('gisella'),
('giuditta'),
('giulia'),
('giuliana'),
('giulitta'),
('giuseppa'),
('giuseppina'),
('giusta'),
('glenda'),
('gloria'),
('godeberta'),
('godiva'),
('grazia'),
('graziana'),
('graziella'),
('greta'),
('griselda'),
('guenda'),
('guendalina'),
('gundelinda'),
('ianira'),
('ida'),
('idea'),
('iginia'),
('ilaria'),
('ilda'),
('ildegarda'),
('ildegonda'),
('ileana'),
('ilenia'),
('ilia'),
('ilva'),
('imelda'),
('immacolata'),
('incoronata'),
('ines'),
('innocenza'),
('iolanda'),
('iole'),
('iona'),
('ione'),
('ionne'),
('irene'),
('iride'),
('iris'),
('irma'),
('irmina'),
('isa'),
('isabella'),
('iside'),
('isidora'),
('isotta'),
('italia'),
('ivetta'),
('lara'),
('laura'),
('lavinia'),
('lea'),
('leda'),
('lelia'),
('lena'),
('leonia'),
('leonilda'),
('leontina'),
('letizia'),
('lia'),
('liana'),
('liberata'),
('liboria'),
('licia'),
('lidania'),
('lidia'),
('liliana'),
('linda'),
('lisa'),
('livia'),
('liviana'),
('lodovica'),
('loredana'),
('lorella'),
('lorena'),
('lorenza'),
('loretta'),
('loriana'),
('luana'),
('luce'),
('lucia'),
('luciana'),
('lucilla'),
('lucrezia'),
('ludovica'),
('luigia'),
('luisa'),
('luminosa'),
('luna'),
('macaria'),
('maddalena'),
('mafalda'),
('magda'),
('maida'),
('manuela'),
('mara'),
('marana'),
('marcella'),
('mareta'),
('margherita'),
('maria'),
('marianna'),
('marica'),
('mariella'),
('marilena'),
('marina'),
('marinella'),
('marinetta'),
('marisa'),
('marita'),
('marta'),
('martina'),
('maruta'),
('marzia'),
('massima'),
('matilde'),
('maura'),
('melania'),
('melissa'),
('melitina'),
('menodora'),
('mercede'),
('messalina'),
('mia'),
('michela'),
('milena'),
('mimma'),
('mina'),
('minerva'),
('minervina'),
('miranda'),
('mirella'),
('miriam'),
('mirta'),
('moira'),
('monica'),
('morena'),
('morgana'),
('nadia'),
('natalia'),
('natalina'),
('neiva'),
('nerea'),
('nicla'),
('nicoletta'),
('nilde'),
('nina'),
('ninfa'),
('nives'),
('noemi'),
('norina'),
('norma'),
('novella'),
('nuccia'),
('nunziata'),
('odetta'),
('odilia'),
('ofelia'),
('olga'),
('olimpia'),
('olinda'),
('olivia'),
('oliviera'),
('ombretta'),
('ondina'),
('onesta'),
('onorata'),
('onorina'),
('orchidea'),
('oriana'),
('orietta'),
('ornella'),
('orsola'),
('orsolina'),
('ortensia'),
('osanna'),
('otilia'),
('ottilia'),
('palladia'),
('palmazio'),
('palmira'),
('pamela'),
('paola'),
('patrizia'),
('pelagia'),
('penelope'),
('perla'),
('petronilla'),
('pia'),
('piera'),
('placida'),
('polissena'),
('porzia'),
('prisca'),
('priscilla'),
('proserpina'),
('prospera'),
('prudenzia'),
('quartilla'),
('quieta'),
('quiteria'),
('rachele'),
('raffaella'),
('rainelda'),
('rebecca'),
('regina'),
('renata'),
('riccarda'),
('rina'),
('rita'),
('roberta'),
('romana'),
('romilda'),
('romina'),
('romola'),
('rosa'),
('rosalia'),
('rosalinda'),
('rosamunda'),
('rosanna'),
('rosita'),
('rosmunda'),
('rossana'),
('rossella'),
('rufina'),
('saba'),
('sabina'),
('sabrina'),
('samanta'),
('samona'),
('sandra'),
('santina'),
('sara'),
('savina'),
('scolastica'),
('sebastiana'),
('seconda'),
('secondina'),
('sefora'),
('selene'),
('selvaggia'),
('serafina'),
('serena'),
('severa'),
('sibilla'),
('sidonia'),
('silvana'),
('silvia'),
('simona'),
('simonetta'),
('soave'),
('sofia'),
('sofronia'),
('solange'),
('sonia'),
('stefania'),
('stella'),
('susanna'),
('sveva'),
('tabita'),
('tamara'),
('tarquinia'),
('tarsilla'),
('taziana'),
('tea'),
('tecla'),
('telica'),
('teodata'),
('teodolinda'),
('teodora'),
('teresa'),
('teudosia'),
('tina'),
('tiziana'),
('tosca'),
('trasea'),
('tullia'),
('ugolina'),
('ulfa'),
('uliva'),
('unna'),
('vala'),
('valentina'),
('valeria'),
('valeriana'),
('vanda'),
('vanessa'),
('vanna'),
('venera'),
('veneranda'),
('venere'),
('venusta'),
('vera'),
('verdiana'),
('verena'),
('veriana'),
('veridiana'),
('veronica'),
('viliana'),
('vilma'),
('vincenza'),
('viola'),
('violante'),
('virginia'),
('vissia'),
('vittoria'),
('viviana'),
('wanda'),
('zabina'),
('zaira'),
('zama'),
('zanita'),
('zarina'),
('zelinda'),
('zenobia'),
('zita'),
('zoe'),
('zosima');