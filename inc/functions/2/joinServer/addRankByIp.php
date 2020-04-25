<?php

/**********************************************

         Plik: addRankByIp.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class addRankByIp
{
    public function start($ts, $config, $client)
    {
        if (in_array($client['connection_client_ip'], $config['ip'])) {
            foreach ($config['groups'] as $group) {
                $ts->serverGroupAddClient($group, $client['client_database_id']);
            }
        }
    }
}
