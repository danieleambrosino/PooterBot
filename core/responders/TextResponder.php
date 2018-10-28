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
 * Description of TextResponder
 *
 * @author Daniele Ambrosino
 */
class TextResponder extends Responder
{

  private $text;

  /**
   * 
   * @param TextMessage $message
   */
  public function __construct(&$message)
  {
    parent::__construct($message);
    $this->text = $message->getText();
  }

  public function evaluateResponse()
  {
    if ( $this->message->getChat()->isMuted() )
    {
      if ( preg_match('/pooter.*(si )?(scherza|scherzav)/i', $this->text) )
      {
        $this->message->getChat()->unmute();
        $this->responses[] = new TextResponse($this->message,
                                              "Allora torno, amici miei");
      }
      return;
    }
    if ( preg_match('/^\/\w+(?:@PooterBot)?$/', $this->text) )
    {
      $this->evaluateCommand();
    }
    else
    {
      $this->evaluatePhrase();
    }
    $this->genderizeResponses();
  }

  private function evaluateCommand()
  {
    preg_match('/^\/(\w+)/', $this->text, $matches);
    $command = $matches[1];
    switch ($command)
    {
      case 'start':
        $this->responses[] = new TextResponse($this->message,
                                              "Ciao {$this->message->getUser()->getFirstName()}, come va?");
        break;
      case 'foto':
        $fileId = $this->resources->getRandomPhoto();
        $this->responses[] = new PhotoResponse($this->message, $fileId);
        break;
      case 'audio':
        $fileId = $this->resources->getRandomSpeech();
        $this->responses[] = new VoiceResponse($this->message, $fileId);
        break;
      case 'canzone':
        $fileId = $this->resources->getRandomSong();
        $this->responses[] = new VoiceResponse($this->message, $fileId);
        break;
      case 'proverbio':
        $proverb = $this->resources->getRandomProverb();
        $this->responses[] = new TextResponse($this->message, $proverb);
        break;
      case 'barzelletta':
        $joke = $this->resources->getRandomJoke();
        $this->responses[] = new TextResponse($this->message, $joke);
        break;
      case 'meteo':
        $cityId = $this->resources->getRandomCityId();
        $weatherReport = WeatherReportFetcher::getWeatherReport($cityId);
        $this->responses[] = new TextResponse($this->message, $weatherReport);
        break;
      case 'basta':
        $this->responses[] = new TextResponse($this->message,
                                              "Va bene sto zitto non dico stronzate");
        $this->message->getChat()->mute();
        break;
      default:
        break;
    }
  }

  private function evaluatePhrase()
  {

    function found(string $needle, string $haystack)
    {
      return stripos($haystack, $needle) !== FALSE;
    }

    if ( found('zitto', $this->text) )
    {
      $text = "{$this->message->getUser()->getFirstName()} potresti rispettare le persone che scrivono quello che vogliono? Senza offesa per te, ma potresti non cagare il cazzo?";
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('somebody', $this->text) )
    {
      $text = 'Eh grande pezzo, amico mio';
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('fidanzata', $this->text) || found('sharade', $this->text) || found('charade',
                                                                                       $this->text) )
    {
      $text = 'Sono Speedy Gonzales?';
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('stasera', $this->text) )
    {
      $text = "Posso venire anch'io?";
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('some', $this->text) )
    {
      $text = 'Body';
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('once', $this->text) )
    {
      $text = 'Told me';
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('the', $this->text) )
    {
      $text = 'World';
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('is gonna', $this->text) )
    {
      $text = 'Roll me';
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('passione', $this->text) )
    {
      $text = 'Il mio sogno è fare il telecronista';
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('brau', $this->text) || found('birr', $this->text) )
    {
      $fileId = $this->resources->getPhoto('caschetto');
      $caption = "Sto arrivando, {$this->message->getUser()->getFirstName()} mi dai un passaggio, amico mio?";
      $this->responses[] = new PhotoResponse($this->message, $fileId, $caption);
    }
    elseif ( found('olmo', $this->text) )
    {
      $fileId = $this->resources->getPhoto('olmo');
      $caption = "{$this->message->getUser()->getFirstName()} hai nominato Olmo? Grande amico mio ♥";
      $this->responses[] = new PhotoResponse($this->message, $fileId, $caption);
    }
    elseif ( found('pietrausen greco', $this->text) )
    {
      $text = "Non è carino da parte tua, amico mio";
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( found('passaggio', $this->text) )
    {
      $text = "Se vuoi ti accompagno io, {$this->message->getUser()->getFirstName()}";
      $this->responses[] = new TextResponse($this->message, $text);
    }
    // REGEX
    elseif ( preg_match('/conquista (\w+)/i', $this->text, $matches) )
    {
      $fileId = $this->resources->getPhoto('rugby');
      $caption = "{$matches[1]} ti sventro la passera... ahah no scherzo, caro amico mio";
      $this->responses[] = new PhotoResponse($this->message, $fileId, $caption);
    }
    elseif ( preg_match('/(?:spaventa|intimidisci) (\w+)/i', $this->text,
                        $matches) )
    {
      $fileId = $this->resources->getPhoto('hooligan');
      $caption = "{$matches[1]} trema! No scherzo amico mio ♥";
      $this->responses[] = new PhotoResponse($this->message, $fileId, $caption);
    }
    elseif ( preg_match('/secondo te|(?:(?:che|cosa)(?: ne)? (?:pens|dic))|come (?:la vedi|(?:ti )?sembra)|che te ne pare/i',
                        $this->text) )
    {
      $text = $this->resources->getRandomOpinion();
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( preg_match('/(?:a te|ti) piace/i', $this->text) )
    {
      $text = $this->resources->getRandomJudgement();
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( preg_match('/(?:pooter|sugo|sugus|sugoide|gusso|pietro|luca)/i',
                        $this->text) )
    {
      $text = "Dimmi tutto {$this->message->getUser()->getFirstName()}";
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( preg_match('/s+t+o+p{2,}e+r+/i', $this->text) )
    {
      $fileId = $this->resources->getPhoto('sergioBrio');
      $caption = "Il più grande di tutti";
      $this->responses[] = new PhotoResponse($this->message, $fileId, $caption);
    }
    elseif ( preg_match('/lava.*piedi/i', $this->text) )
    {
      $fileId = $this->resources->getPhoto('filosofia');
      $caption = "Come dissi tempo fa...";
      $this->responses[] = new PhotoResponse($this->message, $fileId, $caption);
    }
    elseif ( preg_match('/s+o+m+e+/i', $this->text) )
    {
      $text = "Bbbbbbboooooooooooodddddddddddyyyyyyyyyyy";
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( preg_match('/b+o+d+y+/i', $this->text) )
    {
      $text = "Sssssssssssoooooooooommmmmmmeeeeeeeeeeee";
      $this->responses[] = new TextResponse($this->message, $text);
    }
    elseif ( preg_match('/hai la (?:patente|macchina)/i', $this->text) )
    {
      $text = "No";
      $this->responses[] = new TextResponse($this->message, $text);
    }
  }

  private function genderizeResponses()
  {
    $db = Factory::createDatabase();
    $query = "SELECT 1 FROM FemaleNames WHERE name LIKE ?";
    $values = [$this->message->getUser()->getFirstName()];
    $result = $db->query($query, $values);
    if ( empty($result) )
    {
      return;
    }
    foreach ($this->responses as &$response)
    {
      if ( $response instanceof TextResponse )
      {
        $text = $response->getText();
        $text = preg_replace('/(car)o/i', '$1a', $text);
        $text = preg_replace('/(amic)o/i', '$1a', $text);
        $text = preg_replace('/(mi)o/i', '$1a', $text);
        $response->setText($text);
      }
    }
  }

}
