<?php

/**********************************************

         Plik: notifyWhenJoin.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class notifyWhenJoin
{
    public function start($ts, $config, $client, $lang)
    {
        if (in_array($client['client_database_id'], $config['ids'])) {
            if (in_array($client['client_database_id'], $config['databaseIdsToNotify'])) {
                $ts->clientPoke($cl['clid'], str_replace('[user]', $config['databaseIds'][$client['client_database_id']], $lang['pokeMessage']));
            }
        }
    }
}
