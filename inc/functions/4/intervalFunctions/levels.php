<?php

/**********************************************

         Plik: levels.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class levels
{
    public function start($ts, $config, $lang)
    {
        $data = json_decode(file_get_contents("cache/topTimeSpent.json"), true);
        $levels = json_decode(file_get_contents("cache/levels.json"), true);

        foreach ($ts->clientList('-groups')['data'] as $client) {
            if ($client['client_type'] == 0 && !array_intersect(explode(",", $client['client_servergroups']), $config['ignoredGroups'])) {
                foreach ($config['levels'] as $level => $value) {
                    if ($data[$client['client_database_id']]['t'] < $value['time']) {
                        if (@!in_array($config['levels'][$level-1]['group'], explode(",", $client['client_servergroups']))) {
                            if ($level-2 > -1) {
                                $ts->serverGroupAddClient($config['levels'][$level-1]['group'], $client['client_database_id']);
                                $ts->sendMessage(1, $client['clid'], str_replace(['[x]', '[y]'], [$level-2, $level-1], $lang['message']));
                                
                            }
                            
                        }
                        for ($i = $level-2; $i > 0; $i--) {
                            if (in_array($config['levels'][$i]['group'], explode(",", $client['client_servergroups']))) {
                                $ts->serverGroupDeleteClient($config['levels'][$i]['group'], $client['client_database_id']);
                            }
                        }
                        break;
                    }
                }
            }
        }
        file_put_contents('cache/levels.json', json_encode($levels));
    }
}
