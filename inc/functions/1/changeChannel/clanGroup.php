<?php

/**********************************************

         Plik: clanGroup.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class clanGroup
{
    public function start($ts, $client, $config, $lastChannel, $lang)
    {
        $data = json_decode(file_get_contents("cache/clanGroup.json"), true);

        if (!empty($data[$client['cid']])) {
            if (!array_intersect(explode(',', $client['client_servergroups']), $config['ignoredGroups'])) {
                if (!in_array($data[$client['cid']], explode(',', $client['client_servergroups']))) {
                    $ts->serverGroupAddClient($data[$client['cid']], $client['client_database_id']);
                    $ts->clientPoke($client['clid'], $lang['addPokeMessage']);
                    $ts->clientMove($client['clid'], $lastChannel);


                    return $lastChannel;
                } else {
                    $ts->serverGroupDeleteClient($data[$client['cid']], $client['client_database_id']);
                    $ts->clientPoke($client['clid'], $lang['removePokeMessage']);
                    $ts->clientMove($client['clid'], $lastChannel);


                    return $lastChannel;
                }
                return $lastChannel;
            }
            else{
              $ts->clientMove($client['clid'], $lastChannel);
              return $lastChannel;
            }
        }
    }
}
