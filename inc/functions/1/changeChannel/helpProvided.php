<?php

/**********************************************

         Plik: helpProvided.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class helpProvided
{
    public function start($ts, $client, $config, $lastChannel)
    {
        $data = json_decode(file_get_contents("cache/helpProvided.json"), true);

        if ($lastChannel == $config['helpChannel']) {
            $info = $ts->clientInfo($client['invokerid'])['data'];
            if (!empty($client['invokerid']) && array_intersect($config['adminGroups'], explode(',', $info['client_servergroups']))) {
                $data[$info['client_database_id']][] = time();
            }
        }

        file_put_contents("cache/helpProvided.json", json_encode($data));
    }
}
