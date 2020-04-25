<?php

/**********************************************

         Plik: kickFromCp.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class kickFromCp
{
    public function start($ts, $config)
    {
        foreach ($ts->clientList('-groups -uid -times')['data'] as $client) {
            if (array_intersect(explode(",", $client['client_servergroups']), $config['adminGroups']) && !array_intersect(explode(",", $client['client_servergroups']), $config['ignoredGroups'])) {
                if (in_array($client['cid'], $config['channels']) && ($client['client_idle_time']/1000) > $config['idleTime']) {
                    $ts->clientMove($client['clid'], $data[$client['client_unique_identifier']]);
                    $ts->clientPoke($client['clid'], $config['reason']);
                }
            }
        }
    }
}
