<?php
/**********************************************

         File: config.php
              Author: Stalker
              TS: Jutuby.Net
          Telegram: @Stal_ker

***********************************************/
$config = [

  /*

      Aby ustawić banner należy wkleić link do pliku index.php
      np. https://127.0.0.1/banner/index.php/

      For set the banner on server, you have to put the link to index.php
      ex. https://127.0.0.1/banner/index.php/

  */

  # 0 -> wyłącza wyświetlanie błędów | -1 -> włącza wyświetlanie błędów

  # 0 -> turn off error reporting | 1 -> turn on error reporting
  'errors' => 1,

  # true / false
  'logs' => true,

  # Link do generowanych przez bota danych (Funkcja generateBannerData.php) w qBot

  # Link to bannerData, generated with qBot
  'dataUrl' => 'http://217.182.76.77/bannerData.php',

  # Losowe wiadomości

  # Random messages
  'randomMessage' => [
    0 => "Wbijaj na nasz fanpage!",
  ],

  # Po ilu dniach ma usuwać cache

  # every how many days it has to delete the cache
  'removeCache' => 2 * 24 * 60 * 60,

  # Klucz API ze strony https://openweathermap.org

  # API key, you get it here: https://openweathermap.org
  'apiKey' => 'XXX',

  # Ścieżka do template baneru

  # Path to banner template
  'bannerBackground' => 'img/1.png',

  # Co ile ma pobierac informacje o pogodzie (Optymalnie jest co 10 minut)

  # every how many seconds it has to get weathaer data
  'weatherInterval' => 10 * 60,


  'settings' => [

    # Godzina # Hour
    0 => [
      'enabled' => true,    # true/false
      'size' => 22,   # Wielkość tekstu # text size
      'x' => 723,     # Współrzędna X # coordinate X
      'y' => 152,     # Współrzędna Y # coordinate Y
      'font' => 'font/LEMONMILK-LightItalic.otf',     # Ścieżka do czcionki # path to font
      'color' => [    # Kolor tekstu w RGB (0 -> R, 1 -> G, 2 -> B) # Text color in RGB (0 -> R, 1 -> G, 2 -> B)
        0 => 255,
        1 => 255,
        2 => 255,
      ],
    ],

    # Online
    1 => [
      'enabled' => true,
      'size' => 22,
      'x' => 226,
      'y' => 152,
      'font' => 'font/LEMONMILK-LightItalic.otf',
      'color' => [
        0 => 255,
        1 => 255,
        2 => 255,
      ],
    ],

    # admini online # admins online
    2 => [
      'enabled' => true,
      'size' => 22,
      'x' => 569,
      'y' => 152,
      'font' => 'font/LEMONMILK-LightItalic.otf',
      'color' => [
        0 => 255,
        1 => 255,
        2 => 255,
      ],
    ],

    # Tekst z nickiem # text with nick
    3 => [
      'enabled' => true,
      'size' => 14,
      'x' => 390,
      'y' => 290,
      'font' => 'font/LEMONMILK-LightItalic.otf',
      'color' => [
        0 => 255,
        1 => 255,
        2 => 255,
      ],
    ],

    # Losowy tekst # random text
    4 => [
      'enabled' => true,
      'size' => 14,
      'x' => 360,
      'y' => 17,
      'font' => 'font/LEMONMILK-LightItalic.otf',
      'color' => [
        0 => 255,
        1 => 255,
        2 => 255,
      ],
    ],

    # Temperatura # temperature
    5 => [
      'enabled' => true,
      'size' => 19,
      'x' => 73,
      'y' => 170,
      'font' => 'font/LEMONMILK-LightItalic.otf',
      'color' => [
        0 => 255,
        1 => 255,
        2 => 255,
      ],
    ],

    # Miasto  # city
    6 => [
      'enabled' => true,
      'size' => 14,
      'x' => 73,
      'y' => 145,
      'font' => 'font/LEMONMILK-LightItalic.otf',
      'color' => [
        0 => 255,
        1 => 255,
        2 => 255,
      ],
    ],
  ]
];
 ?>
