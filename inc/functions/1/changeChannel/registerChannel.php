<?php

/**********************************************

         Plik: registerChannel.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class registerChannel
{
    public function start($ts, $client, $config, $lastChannel, $lang)
    {
        foreach ($config['cfg'] as $channel => $group) {
            if ($client['cid'] == $channel) {
                if (!array_intersect($config['groups'], explode(",", $client['client_servergroups']))) {
                    $data = json_decode(file_get_contents("cache/topTimeSpent.json"), true);
                    if (@$data[$client['client_database_id']]['t'] > $config['requiredTime'] || $config['requiredTime'] == 0) {
                        $ts->serverGroupAddClient($group, $client['client_database_id']);
                        $ts->clientPoke($client['clid'], $lang['successfullyAdded']);
                        $ts->clientMove($client['clid'], $lastChannel);
                    } else {
                        $ts->clientPoke($client['clid'], $lang['tooShortOnServer']);
                        $ts->clientMove($client['clid'], $lastChannel);
                    }
                } else {
                    $ts->clientPoke($client['clid'], $lang['alreadyRegistered']);
                    $ts->clientMove($client['clid'], $lastChannel);
                }
                return $lastChannel;
            }
        }
    }
}
