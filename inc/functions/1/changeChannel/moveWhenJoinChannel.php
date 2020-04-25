<?php

/**********************************************

         Plik: moveWhenJoinChannel.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class moveWhenJoinChannel
{
    public function start($ts, $client, $config, $lastChannel, $lang)
    {
        $data = json_decode(file_get_contents("cache/moveWhenJoinChannel.json"), true);
        $i = 0;
        foreach ($data as $index => $value) {
            if ($client['cid'] == $value['moveChannelId']) {
                $i = 1;
                if (!empty($value['group']) && array_intersect(explode(",", $client['client_servergroups']), $value['group'])) {
                    $if = $ts->clientMove($client['clid'], $index);
                    $ts->sendMessage(1, $client['clid'], str_replace("[user]", "[url=client://0/".$client['client_unique_identifier']."]klik[/url]", $lang['successfullyMoved']));
                    if ($if['success']) {
                        $i = 0;
                        return $index;
                    }
                }
            }
        }
        if ($i) {
            $t = $ts->clientMove($client['clid'], $lastChannel);
            $ts->sendMessage(1, $client['clid'], $lang['failureMoved']);
            return $lastChannel;
        }
    }
}
