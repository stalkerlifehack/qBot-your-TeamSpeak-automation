<?php

/**********************************************

         Plik: topConnectedTime.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class topConnectedTime
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/topConnectedTime.json"), true);

        foreach ($ts->clientList('-times -groups')['data'] as $client) {
            if ($client['client_type'] == 0 && !array_intersect($config['ignoredGroups'], explode(",", $client['client_servergroups']))) {
                $clientInfo = $ts->clientInfo($client['clid'])['data'];
                if (empty($data[$client['client_database_id']])) {
                    $data[$client['client_database_id']] = [
                      't' => round($clientInfo['connection_connected_time']/1000, 2)
                    ];
                } else {
                    if (($clientInfo['connection_connected_time']/1000) > $data[$client['client_database_id']]['t']) {
                        $data[$client['client_database_id']] = [
                          't' => round($clientInfo['connection_connected_time']/1000, 2)
                        ];
                    }
                }
            }
        }
        file_put_contents("cache/topConnectedTime.json", json_encode($data));
    }
}
