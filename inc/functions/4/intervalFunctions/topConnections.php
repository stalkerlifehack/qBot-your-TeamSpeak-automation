<?php

/**********************************************

         Plik: topConnections.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class topConnections
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/topConnections.json"), true);
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if ($client['client_type'] == 0 && !array_intersect($config['ignoredGroups'], explode(",", $client['client_servergroups']))) {
                $clientInfo = $ts->clientInfo($client['clid'])['data'];
                if (empty($data[$client['client_database_id']])) {
                    $data[$client['client_database_id']] = [
                      'c' => $clientInfo['client_totalconnections']
                    ];
                } elseif ($data[$client['client_database_id']]['c'] < $clientInfo['client_totalconnections']) {
                    $data[$client['client_database_id']] = [
                      'c' => $clientInfo['client_totalconnections']
                    ];
                }
            }
        }
        file_put_contents("cache/topConnections.json", json_encode($data));
    }
}
