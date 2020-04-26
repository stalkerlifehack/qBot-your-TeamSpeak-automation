<?php

/**********************************************

         Plik: publicChannelGroupHelper.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class publicChannelGroupHelper
{
    public function start($ts, $cldbid, $config, $client, $lang)
    {
        
        if(in_array($ts->channelInfo($client['cfid'])['data']['pid'], $config['publicParentChannels'])){
            $data = json_decode(file_get_contents('cache/saveClientChannel.json'), true);
            $ts->setClientChannelGroup($config['defaultChannelGroup'], $client['cfid'], $cldbid);
            unset($data[$client['cfid']][$cldbid]);
            file_put_contents('cache/saveClientChannel.json', json_encode($data));


            $channelList = $ts->channelClientList($client['cfid'])['data'];
            if(!empty($channelList)){
                foreach($channelList as $user){
                    $allUsers[$user['client_database_id']] = $user['clid'];
                }

                asort($data[$client['cfid']]);

                foreach(array_keys($data[$client['cfid']]) as $newUser){
                    if(array_key_exists($newUser, $allUsers)){  
                        $ts->setClientChannelGroup($config['channelAdminGroup'], $client['cfid'], $newUser);
                        $ts->sendMessage(1, $allUsers[$newUser], $lang['msg1']);
                        break;
                    }
                }
            }
        }
    }
}

?>