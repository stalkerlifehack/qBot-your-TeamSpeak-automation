<?php

/**********************************************

         Plik: nickNameChecker.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class nickNameChecker
{
    public function start($ts, $config, $lang)
    {
        foreach ($ts->clientList('-groups -ip')['data'] as $client) {
            if ($client['client_type'] == 0 && !array_intersect($config['ignoredGroups'], explode(',', $client['client_servergroups'])) && !in_array($client['connection_client_ip'], $config['ignoredIP'])) {
                foreach ($config['phrases'] as $phrase) {
                    if (strstr(strtolower($client['client_nickname']), strtolower($phrase)) !== false) {
                        $ts->clientPoke($client['clid'], str_replace('[phrase]', $phrase, $lang['pokeMessage']));
                        $ts->clientKick($client['clid'], 'server', $lang['kickMessage']);
                    }
                }
            }
        }
    }
}
