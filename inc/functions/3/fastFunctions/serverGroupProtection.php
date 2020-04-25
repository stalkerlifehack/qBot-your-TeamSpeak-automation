<?php

/**********************************************

         Plik: serverGroupProtection.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class serverGroupProtection
{
    public function start($ts, $config, $lang)
    {
        $data = json_decode(file_get_contents('cache/serverGroupProtection.json'), true);

        foreach ($ts->clientList('-groups')['data'] as $client) {
            if (!in_array($client['client_database_id'], $config['ignoredDbIds'])) {
                if ($client['client_type'] == 0 && array_intersect(explode(",", $client['client_servergroups']), $config['groups'])) {
                    foreach (explode(",", $client['client_servergroups']) as $group) {
                        if (in_array($group, $config['groups'])) {
                            if (!in_array($group, $data[$client['client_database_id']])) {
                                $ts->serverGroupDeleteClient($group, $client['client_database_id']);
                                $ts->clientPoke($client['clid'], $lang['pokeMessage']);
                                $ts->clientKick($client['clid'], 'server', $lang['kickMessage']);
                            }
                        }
                    }
                }
            }
        }
    }
}
