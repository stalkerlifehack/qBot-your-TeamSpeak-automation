<?php

/**********************************************

         Plik: autoRegister.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class autoRegister
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/topTimeSpent.json"), true);
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if (!array_intersect(explode(",", $client['client_servergroups']), $config['groupsIgnore']) && $client['client_type']==0) {
                if (!empty($data[$client['client_database_id']]) && $data[$client['client_database_id']]['t'] > $config['requiredTime']) {
                  
                    if (!in_array($config['groupAdd'], explode(",", $client['client_servergroups']))) {

                        $ts->serverGroupAddClient($config['groupAdd'], $client['client_database_id']);
                    }
                }
            }
        }
    }
}
