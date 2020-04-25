<?php

/**********************************************

         Plik: saveToken.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class saveToken{
  function start($ts, $config, $client){

    $data = json_decode(file_get_contents('cache/generatedTokens.json'), true);

    if(!empty($data[$client['token']])){

      $token = json_decode(file_get_contents('cache/timeToken.json'), true);

      $token[$client['token']] = [
        'group' => $data[$client['token']]['group'],
        'time' => $data[$client['token']]['time']+time(),
        'cldbid' => $client['cldbid']
      ];

      file_put_contents('cache/timeToken.json', json_encode($token));

      unset($data[$client['token']]);

      file_put_contents('cache/generatedTokens.json', json_encode($data));
    }
  }
}
 ?>
