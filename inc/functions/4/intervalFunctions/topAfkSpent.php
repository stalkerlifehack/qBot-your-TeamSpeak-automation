<?php

/**********************************************

         Plik: topAfkTime.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class topAfkSpent
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/topAfkSpent.json"), true);
        foreach ($ts->clientList('-groups -uid -times')['data'] as $client) {
            if ($client['client_type'] == 0 && !array_intersect($config['ignoredGroups'], explode(",", $client['client_servergroups']))) {
                if (!empty($data[$client['client_database_id']])) {
                    if (($client['client_idle_time']/1000) >= $data[$client['client_database_id']]['t']) {
                        $data[$client['client_database_id']] = [
                          't' => round($client['client_idle_time']/1000, 2),
                          'c' => 0
                        ];
                    } else {
                        if (($client['client_idle_time']/1000) < $data[$client['client_database_id']]['c']) {
                            $data[$client['client_database_id']]['c'] = 0;
                        }
                        $data[$client['client_database_id']] = [
                          't' => round($data[$client['client_database_id']]['t'] - $data[$client['client_database_id']]['c']) + round($client['client_idle_time'] / 1000, 2),
                          'c' => round($client['client_idle_time'] / 1000, 2)
                        ];
                    }
                } else {
                    $data[$client['client_database_id']] = [
                      't' => round($client['client_idle_time']/1000, 2),
                      'c' => 0
                    ];
                }
            }
        }
        file_put_contents("cache/topAfkSpent.json", json_encode($data));
    }
}
