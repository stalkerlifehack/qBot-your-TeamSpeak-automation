<?php

/**********************************************

         Plik: joinMessage.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class joinMessage
{
    public function start($ts, $config, $client)
    {
        foreach ($config['cfg'] as $cfg) {
            if (!array_intersect($config['ignoredGroups'], explode(",", $client['client_servergroups']))) {
                $ts->sendMessage(1, $client['clid'], $cfg);
            }
        }
    }
}
