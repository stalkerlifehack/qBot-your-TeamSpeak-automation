<?php

/**********************************************

         Plik: groupOnline.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class groupOnline
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/groupOnline.json"), true);
        $lastTime = json_decode(file_get_contents("cache/saveLastClientTime.json"), true);

        foreach ($ts->clientList('-groups')['data'] as $client) {
            $clients[] = $client['client_database_id'];
        }

        foreach ($data as $channel => $value) {
            $status = [
              'all' => 0,
              'online' => 0,
              'weekOnline' => 0
            ];
            $groupInfo = $ts->serverGroupClientList($value['sgid'], true)['data'];
            $desc = str_replace('[group]', qBot::getGroupName($ts, $value['sgid']), $config['topDesc']);
            if (!empty($groupInfo[0]['cldbid'])) {
                foreach ($groupInfo as $group) {
                    if (in_array($group['cldbid'], $clients)) {
                        $status['online']++;
                        $desc .= str_replace('[nick]', $group['client_nickname'], $config['onlineDesc']);
                    } else {
                        if (!empty($lastTime[$group['cldbid']])) {
                            $desc .= str_replace(['[nick]', '[lastOnline]'], [$group['client_nickname'], qBot::convertDate($lastTime[$group['cldbid']], 1)], $config['offlineDesc']);
                        } else {
                            $desc .= str_replace('[nick]', $group['client_nickname'], $config['noDataOfflineDesc']);
                        }
                    }
                    $status['all']++;

                }
            } else {
                $desc .= $config['noUserDesc'];
            }

            $desc .= $config['footer'];
            $name = str_replace(['[num]', '[on]', '[all]'], [$value['sgid'], $status['online'], $status['all']], $value['name']);

            $ts->channelEdit($channel, array(
              'channel_name' => $name,
              'channel_description' => $desc
            ));
        }
    }
}
