<?php

/**********************************************

         Plik: banGuard.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class banGuard
{
    public function start($ts, $config, $client, $lang)
    {
      var_dump($client);
      $clientInfo = $ts->clientInfo($client['invokerid'])['data'];
      if(!array_intersect(explode(",", $clientInfo['client_servergroups']), $config['ignoredGroups'])){

        $i = 0;
        $data = json_decode(file_get_contents('cache/banGuard.json'), true);

        $data[$client['invokeruid']][] = time();

        $data[$client['invokeruid']] = array_values($data[$client['invokeruid']]);

        foreach($data[$client['invokeruid']] as $index => $info){
          if(time()-$info < $config['time']){
            $i++;
          }
          else{
            unset($data[$client['invokeruid']][$index]);
          }
        }

        if($i > $config['maxBans']){
          foreach($config['adminGroups'] as $group){
            $ts->serverGroupDeleteClient($group, $clientInfo['client_database_id']);
            $ts->clientPoke($client['invokerid'], $lang['pokeMessage']);
            unset($data[$client['invokeruid']]);
          }
        }

        file_put_contents('cache/banGuard.json', json_encode($data));
      }
    }
}
