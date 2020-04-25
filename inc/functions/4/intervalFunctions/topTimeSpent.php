<?php

/**********************************************

         Plik: topTimeSpent.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class topTimeSpent
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/topTimeSpent.json"), true);
        foreach ($ts->clientList('-groups -uid -times')['data'] as $client) {
            $clInfo = $ts->clientInfo($client['clid'])['data'];
            if ($client['client_type'] == 0 && !array_intersect($config['ignoredGroups'], explode(",", $client['client_servergroups']))) {
                if (!empty($data[$client['client_database_id']])) {
                    if (round($clInfo['connection_connected_time'] / 1000) >= $data[$client['client_database_id']]['t']) {
                        $data[$client['client_database_id']] = [
                          't' => round($clInfo['connection_connected_time'] / 1000, 2),
                          'c' => 0,
                        ];
                    } else {
                        if (round($clInfo['connection_connected_time'] / 1000) < $data[$client['client_database_id']]['c']) {
                            $data[$client['client_database_id']]['c'] = 0;
                        }
                        $data[$client['client_database_id']] = [
                          't' => ($data[$client['client_database_id']]['t'] - $data[$client['client_database_id']]['c']) + round($clInfo['connection_connected_time'] / 1000, 2),
                          'c' => round($clInfo['connection_connected_time'] / 1000, 2)
                        ];
                    }
                } else {
                    $data[$client['client_database_id']] = [
                      't' => round($clInfo['connection_connected_time'] / 1000, 2),
                      'c' => 0
                    ];
                }
            }
        }
        file_put_contents("cache/topTimeSpent.json", json_encode($data));
    }
}
