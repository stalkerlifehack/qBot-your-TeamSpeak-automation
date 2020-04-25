<?php

/**********************************************

         Plik: musicBotChecker.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class musicBotChecker
{
    public function start($ts, $config)
    {
        foreach ($config['cfg'] as $cfg) {
            foreach ($ts->clientList('-times')['data'] as $client) {
                if ($client['client_database_id'] == $cfg['cldbid']) {
                    if ($client['client_idle_time'] > $cfg['idleTime'] * 1000) {
                        foreach ($cfg['commands'] as $command) {
                            $ts->sendMessage(1, $client['clid'], $command);
                        }
                    }
                }
            }
        }
    }
}
