<?php

/**********************************************

         Plik: publicChannelGroup.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class publicChannelGroup{
    public function start($ts, $client, $config, $lastChannel, $lang)
    {

           if(in_array($ts->channelInfo($client['cid'])['data']['pid'], $config['publicParentChannels'])){

                $data = json_decode(file_get_contents('cache/saveClientChannel.json'), true);
                $data[$client['cid']][$client['client_database_id']] = time();
                file_put_contents('cache/saveClientChannel.json', json_encode($data));

               foreach($ts->channelClientList($client['cid'])['data'] as $user){
                    if($user['clid'] != $client['clid']){
                        $control = 1;
                    }
               }
               if(!isset($control)){
                    $ts->setClientChannelGroup($config['channelAdminGroup'], $client['cid'], $client['client_database_id']); 
                    $ts->sendMessage(1, $client['clid'], $lang['msg1']);
               }
             
           }


           if(in_array($ts->channelInfo($lastChannel)['data']['pid'], $config['publicParentChannels'])){
                $ts->setClientChannelGroup($config['defaultChannelGroup'], $lastChannel, $client['client_database_id']);

                $data = json_decode(file_get_contents('cache/saveClientChannel.json'), true);

                if(!empty($ts->channelClientList($lastChannel)['data'])){
                 

                    foreach($ts->channelClientList($lastChannel)['data'] as $user){
                        $allUsers[$user['client_database_id']] = $user['clid'];
                    }
                    
                    asort($data[$lastChannel]);
                    
                    foreach(array_keys($data[$lastChannel]) as $newUser){
                        
                        if(array_key_exists($newUser, $allUsers)){  
                            $ts->setClientChannelGroup($config['channelAdminGroup'], $lastChannel, $newUser);
                            $ts->sendMessage(1, $allUsers[$newUser], $lang['msg2']);
                            break;
                        }
                    }

                }
           }
    }
}


?>