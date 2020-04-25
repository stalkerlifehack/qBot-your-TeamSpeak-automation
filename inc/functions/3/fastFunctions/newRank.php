<?php

/**********************************************

         Plik: newRank.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class newRank
{
    public function start($ts, $config)
    {
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if ($client['client_type'] == 0) {
                if (!array_intersect(explode(",", $client['client_servergroups']), $config['registerGroups'])) {
                    if (!in_array($config['newRankId'], explode(",", $client['client_servergroups']))) {
                        $ts->serverGroupAddClient($config['newRankId'], $client['client_database_id']);
                    }
                } else {
                    if (in_array($config['newRankId'], explode(",", $client['client_servergroups']))) {
                        $ts->serverGroupDeleteClient($config['newRankId'], $client['client_database_id']);
                    }
                }
            }
        }
    }
}
