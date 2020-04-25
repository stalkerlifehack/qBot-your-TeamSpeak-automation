<?php

/**********************************************

         Plik: adminStatusOnChannel.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class adminStatusOnChannel
{
    public function start($ts, $config)
    {
        foreach ($ts->clientList('-times')['data'] as $client) {
            $array[$client['client_database_id']] = $client['client_idle_time']/1000;
        }

        $data = json_decode(file_get_contents("cache/adminStatusOnChannel.json"), true);

        if (!empty($data)) {
            foreach ($data as $cldbid => $channelId) {
                # Jeśli klient jest na ts
                $client = $ts->clientdbInfo($cldbid)['data'];
                if (!empty($array[$cldbid])) {
                    # Jeśli afk
                    if ($array[$cldbid] > $config['awayTime']) {
                        $name = str_replace(['[nick]', '[status]'], [$client['client_nickname'], $config['away']], $config['channelName']);
                        $ts->channelEdit($channelId, array(
                            'channel_name' => $name
                          ));
                    }
                    # jeśli nie jest afk
                    else {
                        $name = str_replace(['[nick]', '[status]'], [$client['client_nickname'], $config['on']], $config['channelName']);

                        $ts->channelEdit($channelId, array(
                              'channel_name' => $name
                            ));
                    }
                }
                # Jeśli klienta nie ma
                else {
                    $name = str_replace(['[nick]', '[status]'], [$client['client_nickname'], $config['off']], $config['channelName']);

                    $ts->channelEdit($channelId, array(
                          'channel_name' => $name
                        ));
                }
            }
        }
    }
}
