<?php

/**********************************************

         Plik: guildChatMessage.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class guildChatMessage
{
    public function start($ts, $config, $client)
    {
        $data = json_decode(file_get_contents('cache/guildChatMessageStatus.json'), true);

        if (@in_array($client['client_database_id'], self::getIds($ts)) && @$data[$client['client_database_id']] == 1 || in_array($client['client_database_id'], self::getIds($ts)) && empty($data[$client['client_database_id']])) {
            foreach ($config['msg'] as $msg) {
                $ts->sendMessage(1, $client['clid'], $msg);
            }
        }
    }

    private function getIds($ts)
    {
        $groups = qBot::getClanData();

        if (!empty($groups)) {
            foreach ($groups as $group) {
                foreach (@$ts->serverGroupClientList($group)['data'] as $client) {
                    @$cldbids[] = $client['cldbid'];
                }
            }
            return $cldbids;
        } else {
            return array();
        }
    }
}
