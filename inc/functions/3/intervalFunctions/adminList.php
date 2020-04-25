<?php

/**********************************************

         Plik: adminList.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class adminList
{
    public function start($ts, $config)
    {
        $date = json_decode(file_get_contents("cache/saveLastClientTime.json"), true);

        foreach ($config['adminGroups'] as $group) {
            $config['topDesc'] .= str_replace(['[group]', '[count]'], [qBot::getGroupName($ts, $group), qBot::getUsersCountFromGroup($ts, $group)], $config['groupDesc']);
            foreach ($ts->serverGroupClientList($group, true)['data'] as $admin) {
                $info = qBot::getInfo($ts);
                if (!empty($admin['cldbid'])) {
                    if (empty($info[$admin['cldbid']])) {
                        if (empty($date[$admin['cldbid']])) {
                            $config['topDesc'] .= str_replace(['[uid]', '[nick]', '[date]', '[count]'], [$admin['client_unique_identifier'], $admin['client_nickname'], "NaN"], $config['offlineDesc']);
                        } else {
                            $config['topDesc'] .= str_replace(['[uid]', '[nick]', '[date]', '[count]'], [$admin['client_unique_identifier'], $admin['client_nickname'], qBot::convertDate($date[$admin['cldbid']], 1)], $config['offlineDesc']);
                        }
                    } elseif ($info[$admin['cldbid']]['idleTime']/1000 > $config['idleTime'] || array_intersect($info[$admin['cldbid']]['groups'], $config['awayGroups'])) {
                        $config['topDesc'] .= str_replace(['[uid]', '[nick]', '[channelId]', '[channelName]'], [$admin['client_unique_identifier'], $admin['client_nickname'], $info[$admin['cldbid']]['channelId'], $info[$admin['cldbid']]['channelName']], $config['awayDesc']);
                    } else {
                        $config['topDesc'] .= str_replace(['[uid]', '[nick]', '[channelId]', '[channelName]'], [$admin['client_unique_identifier'], $admin['client_nickname'], $info[$admin['cldbid']]['channelId'], $info[$admin['cldbid']]['channelName']], $config['onlineDesc']);
                    }
                } else {
                    $config['topDesc'] .= $config['noUsers'];
                }
            }
            $config['topDesc'] .= "\n\n";
        }
        $config['topDesc'] .= $config['footer'];
        if (qBot::removeChars($ts->channelInfo($config['channelId'])['data']['channel_description']) != qBot::removeChars($config['topDesc'])) {
            $ts->channelEdit($config['channelId'], [
              'channel_description' => $config['topDesc']
            ]);
        }
    }
}
