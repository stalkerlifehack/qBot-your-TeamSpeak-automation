<?php

/**********************************************

         Plik: groupLimit.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class groupLimit
{
    public function start($ts, $config, $lang)
    {
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if (!array_intersect($config['ignoredGroups'], explode(",", $client['client_servergroups']))) {
                foreach ($config['settings'] as $value) {
                    if (count(array_intersect(explode(",", $client['client_servergroups']), $value['groups'])) > $value['limit']) {
                        $i = 0;
                        foreach ($value['groups'] as $group) {
                            $data = $ts->serverGroupDeleteClient($group, $client['client_database_id']);
                            if ($data['success']) {
                                $i++;
                            }
                            if ($i >= count(array_intersect(explode(",", $client['client_servergroups']), $value['groups']))-$value['limit']) {
                                break;
                            }
                        }
                        $ts->sendMessage(1, $client['clid'], $lang['message']);
                    }
                }
            }
        }
    }
}
