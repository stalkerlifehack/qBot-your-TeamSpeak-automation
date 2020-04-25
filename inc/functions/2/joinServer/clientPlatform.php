<?php

/**********************************************

         Plik: clientPlatform.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class clientPlatform
{
    public function start($ts, $config, $client)
    {
        foreach ($config as $platform => $group) {
            if ($platform == $client['client_platform']) {
                if (!in_array($group, explode(",", $client['client_servergroups'])) && $group != 0) {
                    $ts->serverGroupAddClient($group, $client['client_database_id']);
                }
            } else {
                if (in_array($group, explode(",", $client['client_servergroups'])) && $group != 0) {
                    $ts->serverGroupDeleteClient($group, $client['client_database_id']);
                }
            }
        }
    }
}
