<?php

/**********************************************

         Plik: banGroup.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class banGroup
{
    public function start($ts, $config)
    {
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if ($client['client_type'] == 0 && !array_intersect(explode(',', $client['client_servergroups']), $config['ignoredGroups'])) {
                foreach ($config['cfg'] as $group => $cfg) {
                    if (in_array($group, explode(',', $client['client_servergroups']))) {
                        $ts->banClient($client['clid'], $cfg['duration'], $cfg['reason']);
                    }
                }
            }
        }
    }
}
