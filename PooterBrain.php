<?php

/**
 * Created by PhpStorm.
 * User: danie
 * Date: 19/05/2017
 * Time: 00:09
 */
define('BOT_ID', '395202945');

class PooterBrain
{


    private $text;
    private $interlocutor_name;
    private $message;

    private $pictures = array(
        'rugby' => 'AgADBAADRKkxGzn7-VAjJrMG6scndNWMuxkABGNtHsrxnyBOJysBAAEC',
        'intenso' => 'AgADBAADR6kxGzn7-VBUBMOaS-y26OfJnhkABBhGeuQ5-mma5FoEAAEC',
        'linguaccia' => 'AgADBAADGakxG0EyCFGAkt-oPjv8GqNrmxkABHaZp0cgZuKvbmAEAAEC',
        'filosofia' => 'AgADBAADGqkxG0EyCFG4sm1oqFa0fBLnnxkABGk_yfNNlWpb6WUEAAEC',
        'sociale' => 'AgADBAADG6kxG0EyCFHcuocSdX-pfcjWnBkABMBjO6Rh8bYfrFgEAAEC',
        'evil' => 'AgADBAADHKkxG0EyCFGGD1Pgnh6Fmz0AAb0ZAAShfA5vbTv5tms3AQABAg',
        'hooligan' => 'AgADBAADMaoxGwJlEVFlm6cmRDZVWV51mxkABPJAlMffzG8bZGcEAAEC'
    );

    public function __construct($update)
    {
        if (!isset($update['message'])) {
            throw new Exception('No message');
        }
        $this->message = $update['message'];

        if (isset($this->message['text'])) {
            $this->text = strtolower(trim($this->message['text']));
        } else {
            $this->text = "";
        }

        if (isset($this->message['chat'])) {
            switch ($this->message['chat']['type']) {
                case ('private'): {
                    $this->interlocutor_name = $this->message['chat']['first_name'];
                    break;
                }
                case ('group'): {
                    $this->interlocutor_name = $this->message['from']['first_name'];
                    break;
                }
            }
        }
    }

    public function answer()
    {
        if (isset($this->message['new_chat_members'])) {
            if ($this->message['new_chat_members'][0]['id'] == BOT_ID) {
                return $this->interpret('text', 'Amici miei come va? Che fate di bello stasera?');
            }
            else {
                $new_member = $this->message['new_chat_members'][0]['first_name'];
                return $this->interpret('text', "Ciao $new_member, che fai di bello stasera?");
            }
        }

        if ($this->text === "") return FALSE;

        if (strpos($this->text, 'ciao') !== FALSE || strpos($this->text, '/start') !== FALSE) {
            $text_to_send = 'Ciao ' . $this->interlocutor_name . ', caro amico mio, io sono Pietro Gusso. Ho 20 anni e mi piace la musica e lo sport e da ben 9 anni pratico rugby!';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'meteo') !== FALSE) {
            $text_to_send = $this->get_weather();
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'zitto') !== FALSE) {
            $text_to_send = $this->interlocutor_name . ' potresti rispettare le persone che scrivono quello che vogliono? Senza offesa per te, ma potresti non cagare il cazzo?';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'somebody') !== FALSE) {
            $text_to_send = 'Eh grande pezzo';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'fidanzata') !== FALSE || strpos($this->text, 'sono') !== FALSE ||
            strpos($this->text, 'sharade') !== FALSE || strpos($this->text, 'charade') !== FALSE
        ) {
            $text_to_send = 'Sono Speedy Gonzales?';
            return $this->interpret('text', $text_to_send);
        }
        elseif (preg_match('/s+t+o+p{2,}e+r+/', $this->text)) {
            $text_to_send = 'Sergio Brio!';
            return $this->interpret('text', $text_to_send);
        }
        elseif (preg_match('/s+o+m+e+/', $this->text)) {
            $text_to_send = 'Bbbbbbboooooooooooodddddddddddyyyyyyyyyyy';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'passione') !== FALSE) {
            $text_to_send = 'Il mio sogno è fare il telecronista';
            return $this->interpret('text', $text_to_send);
        }
        elseif (strpos($this->text, 'brau') !== FALSE) {
            $text_to_send = 'Sto arrivando, ' . $this->interlocutor_name . ' mi dai uno strappo?';
            return $this->interpret('text', $text_to_send);
        }
        elseif (preg_match('/.*lava.*piedi.*/', $this->text)) {
            return $this->interpret('photo', 'filosofia');
        }
        elseif (strpos($this->text, 'conquista') !== FALSE) {
            return $this->interpret('photo', 'rugby');
        }
        elseif (strpos($this->text, 'intimidisci') !== FALSE || strpos($this->text, 'spaventa') !== FALSE) {
            return $this->interpret('photo', 'hooligan');
        }
        elseif (strpos($this->text, 'pooter') !== FALSE) {
            $text_to_send = 'Dimmi tutto ' . $this->interlocutor_name . ', mio grandissimo amico e bravissima persona';
            return $this->interpret('text', $text_to_send);
        }
        else {
            return FALSE;
        }
        // aggiungere birreria -> arrivo + foto bicicletta
        // aggiungere brau -> foto pooter allenamento
    }

    private function get_weather()
    {
        $api_key = 'e65327d8546ce97da440352f6a915c61';
        $base_url = 'http://api.openweathermap.org/data/2.5/weather';
        $cities = array(
            'Bangkok',
            'Pyongyang',
            'KualaLumpur',
            'Reykjavik',
            'Beirut',
            'Kabul',
            'Kathmandu',
            'Jakarta',
            'Tehran',
            'Baghdad',
            'Caracas'
        );
        $city = $cities[array_rand($cities)];

        $url = $base_url . '?q=' . $city . '&units=metric' . '&lang=it' . '&appid=' . $api_key;
        $content = file_get_contents($url);
        $response = json_decode($content, true);

        $current_weather = $response['weather'][0]['description'];
        $temperature = $response['main']['temp'];
        $wind_speed = $response['wind']['speed'];
        $wind_direction = $response['wind']['deg'];

        $text_to_send = "Ragazzi aggiornamenti per il meteo: a ".
                        "$city c'è ".
                        "$current_weather con una temperatura di ".
                        "$temperature gradi centigradi, il vento tira ad una velocità di ".
                        "$wind_speed km/h a ".
                        "$wind_direction" . '°';
        return $text_to_send;
    }

    private function interpret($type, $content)
    {
        switch ($type) {
            case ('text'):
                return array('method' => 'sendMessage', 'text' => $content);
            case ('photo'): {
                switch ($content) {
                    case ('rugby'):
                        return array('method' => 'sendPhoto', 'photo' => $this->pictures['rugby'], 'caption' => 'Ti sventro la passera');
                    case ('filosofia'):
                        return array('method' => 'sendPhoto', 'photo' => $this->pictures['filosofia'], 'caption' => 'Come dissi tempo fa...');
                    case ('hooligan'):
                        return array('method' => 'sendPhoto', 'photo' => $this->pictures['hooligan'], 'caption' => 'Trema! No scherzo amico mio <3');
                    default:
                        throw new Exception('Invalid argument');
                }
            }
            default:
                throw new Exception('Invalid argument');
        }
    }

}
