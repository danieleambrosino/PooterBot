<?php

/**
 * Created by PhpStorm.
 * User: danie
 * Date: 19/05/2017
 * Time: 00:09
 */
class PooterBrain
{

    private $text;
    private $interlocutor_name;
    private $pictures = array(
        'rugby' => 'AgADBAADRKkxGzn7-VAjJrMG6scndNWMuxkABGNtHsrxnyBOJysBAAEC',
        'intenso' => 'AgADBAADR6kxGzn7-VBUBMOaS-y26OfJnhkABBhGeuQ5-mma5FoEAAEC',
        'linguaccia' => 'AgADBAADGakxG0EyCFGAkt-oPjv8GqNrmxkABHaZp0cgZuKvbmAEAAEC',
        'filosofia' => 'AgADBAADGqkxG0EyCFG4sm1oqFa0fBLnnxkABGk_yfNNlWpb6WUEAAEC',
        'sociale' => 'AgADBAADG6kxG0EyCFHcuocSdX-pfcjWnBkABMBjO6Rh8bYfrFgEAAEC',
        'evil' => 'AgADBAADHKkxG0EyCFGGD1Pgnh6Fmz0AAb0ZAAShfA5vbTv5tms3AQABAg'
    );

    public function __construct($update)
    {
        if (!isset($update['message'])) {
            throw new Exception('No message');
        }
        $message = $update['message'];

        if (!isset($message['text'])) {
            throw new Exception('No text');
        }
        $this->text = strtolower(trim($message['text']));

        if (isset($message['chat']['first_name'])) {
            $this->interlocutor_name = $message['chat']['first_name'];
        } else {
            $this->interlocutor_name = "";
        }

    }

    public function interpret()
    {
        $text_to_send = "";

        if (strpos($this->text, 'ciao') !== FALSE || strpos($this->text, '/start') !== FALSE) {
            $text_to_send = 'Ciao ' . $this->interlocutor_name . ', caro amico mio, io sono Pietro Gusso. Ho 20 anni e mi piace la musica e lo sport e da ben 9 anni pratico rugby!';
        } elseif (strpos($this->text, 'meteo')) {
            $text_to_send = $this->get_weather();
        } elseif (strpos($this->text, 'zitto') !== FALSE) {
            $text_to_send = $this->interlocutor_name . ' potresti rispettare le persone che scrivono quello che vogliono? Senza offesa per te, ma potresti non cagare il cazzo?';
        } elseif (strpos($this->text, 'somebody') !== FALSE) {
            $text_to_send = 'Eh grande pezzo';
        } elseif (strpos($this->text, 'fidanzata') !== FALSE || strpos($this->text, 'sono') !== FALSE ||
            strpos($this->text, 'sharade') !== FALSE || strpos($this->text, 'charade') !== FALSE
        ) {
            $text_to_send = 'Sono Speedy Gonzales?';
        } elseif (preg_match('/s+t+o+p{2,}e+r+/', $this->text)) {
            $text_to_send = 'Sergio Brio!';
        } elseif (preg_match('/s+o+m+e+/', $this->text)) {
            $text_to_send = 'Bbbbbbboooooooooooodddddddddddyyyyyyyyyyy';
        } elseif (strpos($this->text, 'passione') !== FALSE) {
            $text_to_send = 'Il mio sogno è fare il telecronista';
        } elseif (strpos($this->text, 'pooter') !== FALSE) {
            $text_to_send = 'Dimmi tutto ' . $this->interlocutor_name . ', mio grandissimo amico e bravissima persona';
        } elseif (strpos($this->text, 'brau') !== FALSE) {
            $text_to_send = 'Sto arrivando, ' . $this->interlocutor_name . ' mi dai uno strappo?';
        } elseif (preg_match('/.*lava.*piedi.*/', $this->text)) {
            $this->answer('photo', $this->pictures['filosofia']);
        }
        // aggiungere birreria -> arrivo + foto bicicletta
        // aggiungere brau -> foto pooter allenamento

        return $text_to_send;
    }

    public function get_weather()
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

        $url = $base_url . '?q=' . $city . '&appid=' . $api_key;
        $content = file_get_contents($url);
        $response = json_decode($content, true);

        $current_weather = $response['weather'][0]['main'];
        $wind_speed = $response['wind']['speed'];
        $wind_direction = $response['wind']['deg'];

        $text_to_send = 'Il clima a ' . $city . ' in questo momento è ' . $current_weather . ', il vento tira ad una velocità di ' . $wind_speed . ' km/h in direzione ' . $wind_direction;
        return $text_to_send;
    }

    public function answer($type, $content)
    {
        switch ($type) {
            case ('text'): {
                return array('method' => 'sendMessage', 'text' => $content);
            }
            case ('photo'): {
                return array('method' => 'sendPhoto', 'photo' => $content);
            }
            default:
                throw new Exception('Invalid argument');
        }
    }

}
