<?php

/**********************************************

         Plik: createClanChannels.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/






class createClanChannels
{
    public function start($ts, $config, $lang)
    {   
        
        $data = json_decode(file_get_contents("cache/createClanChannels.json"), true);
            
        self::checkNumeric($ts, $data, $config);
        self::checkChannels($ts, $data, $config);

            


            foreach($config['cfg'] as $key => $config){
                

                foreach ($ts->clientList('-uid')['data'] as $client) {
                    
                

                    if ($client['cid'] == $config['channelId']) {

                    
                        $break = 0;

                        if (isset($data[$key]) && is_array($data[$key])) {
                            foreach ($data[$key] as $value) {
                                if ($client['client_database_id'] == $value['database_id']) {
                                    if ($ts->clientMove($client['clid'], $value['channelId'])['success']) {
                                        $ts->sendMessage(1, $client['clid'], str_replace('[user]', "[url=client://0/".$client['client_unique_identifier']."]klik[/url]", $lang['alreadyHaveChanel']));
                                        $ts->serverGroupDelete($group['sgid']);
                                    } else {
                                        $ts->sendMessage(1, $client['clid'], $lang['notRemovedFromDb']);
                                        $ts->clientKick($client['clid'], 'channel', $lang['failureCreate']);
                                        $ts->serverGroupDelete($group['sgid']);
                                    }
                                    $break = 1;
                                    break;
                                }
                            }
                        }

                        if ($break) {
                            break;
                        }

                        $group = $ts->serverGroupCopy($config['groupToCopy'], 0, $client['client_nickname'], 1);


                        if ($group['success']) {
                            $structure = $config['channels'];
                            $control = 1;
                            $ifFirstChannel = 1;

                            do {
                                if (!empty($subChannel)) {
                                    unset($structure);
                                    $structure = $subChannel;
                                    unset($subChannel, $tab, $table);
                                    $control = 0;
                                }

                                foreach ($structure as $num => $cfg) {
                                    usleep(200000);
                                    if ($control) {

                                        # jesli nie ma kanalow
                                        if (!isset($data[$key])) {
                                            if ($ifFirstChannel) {
                                                $channelId = self::createChannel($ts, $config, $config['firstChannel'], $cfg['channelName'], $cfg['type'], $client['client_database_id'], $group, 1);


                                                if ($cfg['type'] == 'channelNumeration') {
                                                    $channelNumeration = $channelId;
                                                }
                                                if (array_key_exists('setup', $cfg)) {
                                                    if ($cfg['setup'] == 'saveThatChannel') {
                                                        $dashboardChannels['saveThatChannel'][] = $channelId;
                                                    }
                                                    if ($cfg['setup'] == 'channelGroupName') {
                                                        $dashboardChannels['channelGroup'][] = $channelId;
                                                    }
                                                }
                                                $allChannels[] = $channelId;

                                                $lastChannelId = $channelId;
                                                $ifFirstChannel = 0;
                                            } else {
                                                $channelId = self::createChannel($ts, $config, $channelId, $cfg['channelName'], $cfg['type'], $client['client_database_id'], $group, 1);

                                                if ($cfg['type'] == 'channelNumeration') {
                                                    $channelNumeration = $channelId;
                                                }
                                                if (array_key_exists('setup', $cfg)) {
                                                    if ($cfg['setup'] == 'saveThatChannel') {
                                                        $dashboardChannels['saveThatChannel'][] = $channelId;
                                                    }
                                                    if ($cfg['setup'] == 'channelGroupName') {
                                                        $dashboardChannels['channelGroup'][] = $channelId;
                                                    }
                                                }

                                                $lastChannelId = $channelId;
                                                $allChannels[] = $channelId;
                                            }
                                        } else {
                                            if ($ifFirstChannel) {
                                                $channelId = self::createChannel($ts, $config, self::getLastChannel($data[$key]), $cfg['channelName'], $cfg['type'], $client['client_database_id'], $group, count($data[$key])+1);

                                                if ($cfg['type'] == 'channelNumeration') {
                                                    $channelNumeration = $channelId;
                                                }
                                                if (array_key_exists('setup', $cfg)) {
                                                    if ($cfg['setup'] == 'saveThatChannel') {
                                                        $dashboardChannels['saveThatChannel'][] = $channelId;
                                                    }
                                                    if ($cfg['setup'] == 'channelGroupName') {
                                                        $dashboardChannels['channelGroup'][] = $channelId;
                                                    }
                                                }

                                                $lastChannelId = $channelId;
                                                $ifFirstChannel = 0;
                                                $allChannels[] = $channelId;
                                            } else {
                                                # tworzy kanal juz po powyzszym channelID
                                                $channelId = self::createChannel($ts, $config, $channelId, $cfg['channelName'], $cfg['type'], $client['client_database_id'], $group, count($data[$key])+1);

                                                if ($cfg['type'] == 'channelNumeration') {
                                                    $channelNumeration = $channelId;
                                                }
                                                if (array_key_exists('setup', $cfg)) {
                                                    if ($cfg['setup'] == 'saveThatChannel') {
                                                        $dashboardChannels['saveThatChannel'][] = $channelId;
                                                    }
                                                    if ($cfg['setup'] == 'channelGroupName') {
                                                        $dashboardChannels['channelGroup'][] = $channelId;
                                                    }
                                                }

                                                $lastChannelId = $channelId;
                                                $allChannels[] = $channelId;
                                            }
                                        }
                                    } else {
                                       @$channelId = self::createSubChannel($ts, $config, $cfg['parentId'], $cfg['channelName'], $cfg['type'], $client['client_database_id'], $group, count($data[$key])+1);

                                        if ($cfg['type'] == 'channelNumeration') {
                                            $channelNumeration = $channelId;
                                        }
                                    }

                                    if (array_key_exists('sub', $cfg)) {
                                        for ($j = 0; $j <= count($cfg['sub'])-1; $j++) {
                                            $table[$j]['parentId'] = $channelId;

                                            foreach ($cfg['sub'][$j] as $index => $c) {
                                                $table[$j][$index] = $c;
                                            }
                                        }
                                        $tab[] = $table;
                                    }
                                    unset($table);
                                }
                                if (!empty($tab) && is_array($tab)) {
                                    for ($a = 0; $a <= count($tab)-1; $a++) {
                                        foreach ($tab[$a] as $value) {
                                            $subChannel[] = $value;
                                        }
                                    }
                                }
                            } while (!empty($subChannel));
                        } else {
                            $ts->sendMessage(1, $client['clid'], $lang['failureCreateGroup']);
                            $ts->clientKick($client['clid'], 'channel', $lang['failureCreate']);
                            break;
                        }

                        if (!$ts->clientMove($client['clid'], $lastChannelId)['success']) {
                            $ts->sendMessage(1, $client['clid'], $lang['repeatedChannelName']);
                            $ts->clientKick($client['clid'], 'channel', $lang['failureCreate']);
                        } else {
                            $ts->sendMessage(1, $client['clid'], str_replace('[user]', "[url=client://0/".$client['client_unique_identifier']."]klik[/url]", $lang['successfullyCreate']));

                            @$data[$key][count($data[$key])] = [
                            'channelId' => $lastChannelId,
                            'database_id' => $client['client_database_id'],
                            'groupId' => $group['data']['sgid'],
                            'channelNumeration' => $channelNumeration,
                            'dashboardChannels' => $dashboardChannels,
                            'allChannels' => $allChannels
                            ];
                        
                            //$tab[$key] = array_values($data);
                            
                            file_put_contents("cache/createClanChannels.json", json_encode($data));
                            $data = json_decode(file_get_contents("cache/createClanChannels.json"), true);
                            
                            
                        }

                        
                    }

                    unset($lastChannelId, $channelNumeration, $dashboardChannels, $allChannels, $channelId, $ifFirstChannel, $control);
                }
            }
        
    }


    private static function createChannel($ts, $config, $channelOrder, $channelName, $type, $cldbid, $group, $numeration)
    {
        $name = str_replace(['[num]', '[s]', '[group]'], [substr(sha1(mt_rand()), 13, 4), $numeration, qBot::getGroupName($ts, $group['data']['sgid'])], $channelName);

        if (mb_strlen($name, 'UTF-8') > 40) {
            $name = substr($name, 0, 40-mb_strlen($name, 'UTF-8'));
        }

        $channel = $ts->channelCreate([
          'channel_name' => $name,
          'channel_flag_permanent' => 1,
          'channel_maxclients' => 0,
          'channel_flag_maxclients_unlimited' => 0,
          'channel_order' => $channelOrder
        ])['data'];

        switch ($type) {

        case 'onlineOnChannel':
          $groupOnline = json_decode(file_get_contents("cache/groupOnline.json"), true);
          $groupOnline[$channel['cid']] = [
            'sgid' => $group['data']['sgid'],
            'name' => $channelName
          ];
          file_put_contents("cache/groupOnline.json", json_encode($groupOnline));
          break;


        case 'addChannelGroup':
          $ts->setClientChannelGroup($config['channelAdminGroupId'], $channel['cid'], $cldbid);
          break;


        case 'clanGroup':
          $ts->setClientChannelGroup($config['channelAdminGroupId'], $channel['cid'], $cldbid);
          $clanGroup = json_decode(file_get_contents("cache/clanGroup.json"), true);
          $clanGroup[$channel['cid']] = $group['data']['sgid'];
          file_put_contents("cache/clanGroup.json", json_encode($clanGroup));
          break;


        case 'teleportChannel':
          $ts->setClientChannelGroup($config['channelAdminGroupId'], $channel['cid'], $cldbid);
          $moveWhenJoinChannel = json_decode(file_get_contents("cache/moveWhenJoinChannel.json"), true);
          $teleportChannel = json_decode(file_get_contents("cache/teleport.json"), true);
          $moveWhenJoinChannel[$channel['cid']] = [
            'group' => [$group['data']['sgid']],
            'moveChannelId' => $config['moveChannelId']
          ];

          $teleportChannel[$channel['cid']] = $group['data']['sgid'];
          if ($config['moveChannelEnabled']) {
              file_put_contents("cache/moveWhenJoinChannel.json", json_encode($moveWhenJoinChannel));
          }
          file_put_contents("cache/teleport.json", json_encode($teleportChannel));
          break;


      }
        return $channel['cid'];
    }
    private static function createSubChannel($ts, $config, $channelParentId, $channelName, $type, $cldbid, $group, $numeration)
    {
        $name = str_replace(['[s]', '[group]'], [$numeration, qBot::getGroupName($ts, $group['data']['sgid'])], $channelName);

        if (mb_strlen($name, 'UTF-8') > 40) {
            $name = substr($name, 0, 40-mb_strlen($name, 'UTF-8'));
        }

        $channel = $ts->channelCreate([
          'channel_name' => $name,
          'channel_flag_permanent' => 1,
          'channel_maxclients' => 0,
          'channel_flag_maxclients_unlimited' => 0,
          'cpid' => $channelParentId
        ])['data'];

        switch ($type) {

        case 'onlineOnChannel':
          $groupOnline = json_decode(file_get_contents("cache/groupOnline.json"), true);
          $groupOnline[$channel['cid']] = [
            'sgid' => $group['data']['sgid'],
            'name' => $channelName
          ];
          file_put_contents("cache/groupOnline.json", json_encode($groupOnline));
          break;


        case 'addChannelGroup':
          $ts->setClientChannelGroup($config['channelAdminGroupId'], $channel['cid'], $cldbid);
          break;


        case 'clanGroup':
          $ts->setClientChannelGroup($config['channelAdminGroupId'], $channel['cid'], $cldbid);
          $clanGroup = json_decode(file_get_contents("cache/clanGroup.json"), true);
          $clanGroup[$channel['cid']] = $group['data']['sgid'];
          file_put_contents("cache/clanGroup.json", json_encode($clanGroup));
          break;


        case 'teleportChannel':
          $ts->setClientChannelGroup($config['channelAdminGroupId'], $channel['cid'], $cldbid);
          $moveWhenJoinChannel = json_decode(file_get_contents("cache/moveWhenJoinChannel.json"), true);
          $teleportChannel = json_decode(file_get_contents("cache/teleport.json"), true);
          $moveWhenJoinChannel[$channel['cid']] = [
            'group' => [$group['data']['sgid']],
            'moveChannelId' => $config['moveChannelId']
          ];

          $teleportChannel[$channel['cid']] = $group['data']['sgid'];
          if ($config['moveChannelEnabled']) {
              file_put_contents("cache/moveWhenJoinChannel.json", json_encode($moveWhenJoinChannel));
          }
          file_put_contents("cache/teleport.json", json_encode($teleportChannel));
          break;


      }

        return $channel['cid'];
    }
    private static function getLastChannel($data)
    {
        return $data[count($data)-1]['channelId'];
    }
    private static function checkNumeric($ts, $data, $config)
    {
        if (!empty($data) && is_array($data)) {
            
           foreach($data as $key => $value){
               
                foreach($value as $index => $val){
                    
                    $t = $ts->channelEdit($val['channelNumeration'], [
                        'channel_name' => str_replace(['[s]', '[group]'], [$index+1, qBot::getGroupName($ts, $val['groupId'])], $config['cfg'][$key]['channelNumeration'])
                    ]);
                  
                }
            }
            
        }
    }
    private static function checkChannels($ts, $data, $config)
    {

        foreach($ts->serverGroupList()['data'] as $group){
            $groups[] = $group['sgid'];
        }

        if(isset($groups) && isset($data)){
            foreach($data as $index => $value){
                foreach($value as $key => $val){
                    
                    if(!in_array($val['groupId'], $groups)){

                        foreach($val['allChannels'] as $channelId){
                        
                         $ts->channelDelete($channelId);
                        }
                        
                        unset($data[$index][$key]);
                        $data[$index] = array_values($data[$index]);
                        file_put_contents("cache/createClanChannels.json", json_encode($data));
                        $data = json_decode(file_get_contents("cache/createClanChannels.json"), true);
                        self::checkNumeric($ts, $data, $config);
                        if(empty($data[$index])){
                            unset($data[$index]);
                            file_put_contents("cache/createClanChannels.json", json_encode($data));
                        }
                    }
                }
            }
        }
    }
}
