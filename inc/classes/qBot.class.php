<?php

/**********************************************

         Plik: qBot.class.php.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class qBot
{
    public static function ignoredChannels($config)
    {
        $channels = [];

        # clanGroup
        if ($config['clanGroup']['enabled']) {
            $clanGroup = json_decode(file_get_contents("cache/clanGroup.json"), true);
            if (!empty($clanGroup)) {
                foreach (array_keys($clanGroup) as $channel) {
                    $channels[] = $channel;
                }
            }
        }

        # moveWhenJoinChannel
        if ($config['moveWhenJoinChannel']['enabled']) {
            $moveWhenJoinChannel = json_decode(file_get_contents("cache/moveWhenJoinChannel.json"), true);
            if (!empty($moveWhenJoinChannel)) {
                foreach ($moveWhenJoinChannel as $channel) {
                    $channels[] = $channel['moveChannelId'];
                }
            }
        }

        # registerChanner
        if ($config['registerChannel']['enabled']) {
            foreach (array_keys($config['registerChannel']['cfg']) as $channel) {
                $channels[] = $channel;
            }
        }

        # getPrivateChannel
        if ($config['getPrivateChannel']['enabled']) {
            $channels[] = $config['getPrivateChannel']['channelId'];
        }

        # clientChannelInfo
        if ($config['clientChannelInfo']['enabled']) {
            $channels[] = $config['clientChannelInfo']['channelId'];
        }

        return $channels;
    }




    public static function convertSecondsSecond($seconds)
    {
        $lang = $GLOBALS['lang']['convertSecondsSecond'][$GLOBALS['config']['lang']];
        $time = array();
        if ($seconds < 60) {
            return $lang[0];
        }
        if ($seconds >= 60 && $seconds < 86400) {
            $time['hours'] = floor($seconds / 3600);
            $time['minutes'] = floor(($seconds - ($time['hours'] * 3600)) / 60);
            if ($time['hours'] == 1) {
                $time['hours'] .= $lang[1];
            } elseif ($time['hours'] > 1 && $time['hours'] < 5) {
                $time['hours'] .= $lang[2];
            } else {
                $time['hours'] .= $lang[3];
            }
            if ($time['minutes'] == 1) {
                $time['minutes'] .= $lang[4];
            } elseif ($time['minutes'] > 1 &&  $time['minutes'] < 5) {
                $time['minutes'] .= $lang[5];
            } else {
                $time['minutes'] .= $lang[6];
            }
            if ($time['hours'] == 0) {
                return ($time['minutes']);
            } else {
                if ($time['minutes'] == 0) {
                    return ($time['hours']);
                } else {
                    return ($time['hours'].' '.$time['minutes']);
                }
            }
        }
        if ($seconds >= 86400) {
            $time['days'] = floor($seconds / 86400);
            $time['hours'] = floor(($seconds - ($time['days'] * 86400)) / 3600);
            if ($time['days'] == 1) {
                $time['days'] .= ' dzień';
            } else {
                $time['days'] .= ' dni';
            }
            if ($time['hours'] == 1) {
                $time['hours'] .= ' godzina';
            } elseif ($time['hours'] > 1 && $time['hours'] < 5) {
                $time['hours'] .= ' godziny';
            } else {
                $time['hours'] .= ' godzin';
            }
            if ($time['days'] == 0) {
                return $$time['hours'];
            } else {
                if ($time['hours'] == 0) {
                    return $time['days'];
                } else {
                    return $time['days'].' '.$time['hours'];
                }
            }
        }
    }
    public static function convertThirdSecond($seconds)
    {
        $lang = $GLOBALS['lang']['convertSecondsSecond'][$GLOBALS['config']['lang']];
        $hours = '';
        $minutes = '';
        $days = '';
        $time = array();
        if ($seconds < 60) {
            return $lang[0];
        }
        if ($seconds >= 60 && $seconds < 86400) {
            $time['hours'] = floor($seconds / 3600);
            $time['minutes'] = floor(($seconds - ($time['hours'] * 3600)) / 60);
            if ($time['hours'] == 1) {
                $hours .= $time['hours'];
                $hours .= $lang[1];
            } elseif ($time['hours'] > 1 && $time['hours'] < 5) {
                $hours .= $time['hours'];
                $hours .= $lang[2];
            } else {
                $hours .= $time['hours'];
                $hours .= $lang[3];
            }
            if ($time['minutes'] == 1) {
                $minutes .= $time['minutes'];
                $minutes .= $lang[4];
            } elseif ($time['minutes'] > 1 &&  $time['minutes'] < 5) {
                $minutes .= $time['minutes'];
                $minutes .= $lang[5];
            } else {
                $minutes .= $time['minutes'];
                $minutes .= $lang[6];
            }
            if ($time['hours'] == 0) {
                return ($minutes);
            } else {
                if ($time['minutes'] == 0) {
                    return ($hours);
                } else {
                    return ($hours.' '.$minutes);
                }
            }
        }
        if ($seconds >= 86400) {
            $time['days'] = floor($seconds / 86400);
            $time['hours'] = floor(($seconds - ($time['days'] * 86400)) / 3600);
            if ($time['days'] == 1) {
                $days .= $time['days'];
                $days .= $lang[7];
            } else {
                $days .= $time['days'];
                $days .= $lang[8];
            }
            if ($time['hours'] == 1) {
                $hours .= $time['hours'];
                $hours .= $lang[9];
            } elseif ($time['hours'] > 1 && $time['hours'] < 5) {
                $hours .= $time['hours'];
                $hours .= $lang[10];
            } else {
                $hours .= $time['hours'];
                $hours .= $lang[11];
            }
            if ($time['days'] == 0) {
                return $hours;
            } else {
                if ($time['hours'] == 0) {
                    return $days;
                } else {
                    return $days.' '.$hours;
                }
            }
        }
    }

    public static function removeChars($string)
    {
        return str_replace(["\n", '\n', ' ', '  '], '', $string);
    }
    public static function getGroupsFromId($ts, $clientId)
    {
        return explode(",", $ts->clientInfo($clientId)['data']['client_servergroups']);
    }
    public static function checkLink($link, $config)
    {
        $domain = parse_url($link);
        if (isset($domain['host'])) {
            $ip = gethostbyname($domain['host']);
            if (!empty($ip)) {
                switch ($config['mode']) {
          case 'block':
            if (in_array($ip, $config['ip']) || in_array($domain['host'], $config['domains'])) {
                return true;
            } else {
                return false;
            }
            break;

          case 'allow':
            if (in_array($ip, $config['ip']) || in_array($domain['host'], $config['domains'])) {
                return false;
            } else {
                return true;
            }
            break;
        }
            } else {
                return true;
            }
        } elseif ($domain['path'] != $config['replace']) {
            return true;
        } else {
            return false;
        }
    }
    public static function getGroupName($ts, $sgid)
    {
        foreach ($ts->serverGroupList()['data'] as $group) {
            if ($group['sgid'] == $sgid) {
                return $group['name'];
            }
        }
    }
    public static function getUsersCountFromGroup($ts, $sgid)
    {
        $count = $ts->serverGroupClientList($sgid)['data'];
        if (empty($count[0]['cldbid'])) {
            return 0;
        } else {
            return count($count);
        }
    }
    public static function getInfo($ts)
    {
        $data = [];
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if ($client['client_type'] == 0) {
                $data[$client['client_database_id']] = [
                  'idleTime' => $ts->clientInfo($client['clid'])['data']['client_idle_time'],
                  'groups' => explode(",", $client['client_servergroups']),
                  'channelId' => $client['cid'],
                  'channelName' => $ts->channelInfo($client['cid'])['data']['channel_name']
                ];
            }
        }
        return $data;
    }
    public static function getChannelClientIds($ts, $channelId)
    {
        foreach ($ts->channelClientList($channelId)['data'] as $client) {
            $ids[] = $client['client_database_id'];
        }
        return $ids;
    }
    public static function getClientData($channels)
    {
        $array = [];

        foreach ($channels as $data) {
            $array[$data['cldbid']] = $data['channelId'];
            $array[$data['ip']] = $data['channelId'];
        }
        return $array;
    }
    public static function getChannels($ts, $cfg)
    {
        $i = 0;
        foreach ($ts->channelList()['data'] as $channel) {
            if ($channel['pid'] == $cfg['mainChannelId']) {
                $i++;
            }
        }
        return $i;
    }
    public static function getIndex($channelId)
    {
        $data = json_decode(file_get_contents("cache/getPrivateChannel.json"), true);
        foreach ($data as $index => $info) {
            if ($channelId == $info['channelId']) {
                return $index+1;
                break;
            }
        }
    }
    public static function getDescInfo($channelId)
    {
        $data = json_decode(file_get_contents("cache/getPrivateChannel.json"), true);
        foreach ($data as $info) {
            if ($info['channelId'] == $channelId) {
                $descInfo = [
                  'clientNickname' => $info['clientNickname'],
                  'created' => $info['created']
                ];
                return $descInfo;
                break;
            }
        }
    }
    public static function getAdmins($cfg, $ts)
    {
        foreach ($cfg['adminGroups'] as $group) {
            $admin = $ts->serverGroupClientList($group, true)['data'];
            foreach ($admin as $adm) {
                if (!empty($admin)) {
                    $admins[] = $adm['cldbid'];
                }
            }
        }
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if (in_array($client['client_database_id'], $admins)) {
                if (!array_intersect(explode(",", $client['client_servergroups']), $cfg['ignoredAdminGroups'])) {
                    $ids[] = $client['clid'];
                }
            }
        }
        if (!empty($ids)) {
            return $ids;
        } else {
            return array();
        }
    }
    public static function channelNameSame($ts, $cid, $name)
    {
        if ($name == $ts->channelInfo($cid)['data']['channel_name']) {
            return false;
        } else {
            return true;
        }
    }
    public static function getDefaultChannelId($ts)
    {
        foreach ($ts->channelList('-flags')['data'] as $channel) {
            if ($channel['channel_flag_default']) {
                return $channel['cid'];
            }
        }
    }

    public static function convertDate($var, $option)
    {
        if ($option) {
            $time = strtotime($var);
        } else {
            $time = $var;
        }
        return date('j', $time).' '.self::monthName(date('n', $time)).' '.date('Y', $time).' o '.date('H:i', $time);
    }
    public static function monthName($monthNumber)
    {
        return $GLOBALS['lang']['monthNumber'][$GLOBALS['config']['lang']][$monthNumber];
    }

    public static function weekName($weekNumber)
    {
        return $GLOBALS['lang']['weekName'][$GLOBALS['config']['lang']][$weekNumber];
    }

    public static function getClanData()
    {
        $data = json_decode(file_get_contents('cache/createClanChannels.json'), true);

        $groups = [];

        foreach($data as $value){
            foreach($value as $val){
                $groups[] = $val['groupId'];
            }
        }
        return $groups;
    }
    public static function cacheFiles()
    {
        $files = [
            'adminStatusOnChannel.json',
            'banGuard.json',
            'bannerData.json',
            'clanGroup.json',
            'createClanChannels.json',
            'generatedTokens.json',
            'getPrivateChannel.json',
            'groupOnline.json',
            'guildChat.json',
            'guildChatMessageStatus.json',
            'guildChatSettings.json',
            'helpProvided.json',
            'levels.json',
            'moreRecordOnline.json',
            'moveWhenJoinChannel.json',
            'newUsersToday.json',
            'proxyChecker.json',
            'recordOnline.json',
            'saveLastClientTime.json',
            'serverGroupProtection.json',
            'teleport.json',
            'timeToken.json',
            'topAfkSpent.json',
            'topConnectedTime.json',
            'topConnections.json',
            'topTimeSpent.json'
        ];
        return $files;
    }

    public static function getData($socket)
    {
        $data = fgets($socket, 4096);
        if (!empty($data)) {
            $datasets = explode(' ', $data);
            $output = array();
            foreach ($datasets as $dataset) {
                $dataset = explode('=', $dataset);
                if (count($dataset) > 2) {
                    for ($i = 2; $i < count($dataset); $i++) {
                        $dataset[1] .= '='.$dataset[$i];
                    }
                    $output[self::unEscapeText($dataset[0])] = self::unEscapeText($dataset[1]);
                } elseif (count($dataset) == 1) {
                    $output[self::unEscapeText($dataset[0])] = '';
                } else {
                    $output[self::unEscapeText($dataset[0])] = self::unEscapeText($dataset[1]);
                }
            }
            return $output;
        }
    }

    private static function unEscapeText($text)
    {
        $escapedChars = array("\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/");
        $unEscapedChars = array('', '', '', '', '', ' ', '|', '/');
        $text = str_replace($escapedChars, $unEscapedChars, $text);
        return $text;
    }

    public static function sendCommand($socket, $command)
    {
        $splittedCommand = str_split($command, 1024);
        $splittedCommand[(count($splittedCommand) - 1)] .= "\n";
        foreach ($splittedCommand as $commandPart) {
            fputs($socket, $commandPart);
        }

        return fgets($socket, 4096);
    }

}
