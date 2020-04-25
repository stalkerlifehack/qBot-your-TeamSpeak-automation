<?php

/**********************************************

         Plik: checkConnections.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class checkConnections
{
    public function start($ts, $config, $client=null, $lang)
    {
        foreach ($ts->clientList('-ip -groups')['data'] as $cl) {
            if (!array_intersect(explode(",", $cl['client_servergroups']), $config['ignoredGroups']) && $cl['client_type'] == 0) {
                $ip[] = $cl['connection_client_ip'];
                $clid[$cl['connection_client_ip']] = $cl['clid'];
            }
        }
        if (!empty($ip)) {
            foreach (array_count_values($ip) as $index => $value) {
                if ($value > $config['maxConnections']) {
                    $ts->clientKick($clid[$index], 'server', str_replace('[max_connections]', $config['maxConnections'], $lang['kickMessage']));
                }
            }
        }
    }
}
