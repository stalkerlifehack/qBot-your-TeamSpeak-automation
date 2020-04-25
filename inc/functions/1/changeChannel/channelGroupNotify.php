<?php
/**********************************************

         Plik: channelGroupNotify.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class channelGroupNotify
{
    public function start($ts, $client, $config, $lastChannel, $lang)
    {
      
      foreach($config['cfg'] as $cid => $group){
        if($client['cid'] == $cid){
          
          $list = $ts->channelGroupClientList($cid, null, $group)['data'];

          if(is_array($list)){
            foreach($list as $user){
              if($user['cldbid'] != $client['client_database_id']){
                $clid = $ts->clientGetIds($ts->clientGetNameFromDbid($user['cldbid'])['data']['cluid'])['data'][0]['clid'];
                $cache[] = $clid;
                $ts->clientPoke($clid, str_replace('[user]', "[url=client://0/".$client['client_unique_identifier']."]".substr($client['client_nickname'], 0, 10)."...[/url]", $lang['pokeMessage']));
              }
            }
          }
          $list = $ts->channelGroupClientList($ts->channelInfo($cid)['data']['pid'], null, $group)['data'];
          if(is_array($list)){
            foreach($list as $user){
              if($user['cldbid'] != $client['client_database_id']){
                $clid = $ts->clientGetIds($ts->clientGetNameFromDbid($user['cldbid'])['data']['cluid'])['data'][0]['clid'];
                if(empty($cache) || !in_array($clid, $cache)){
                  $ts->clientPoke($clid, str_replace('[user]', "[url=client://0/".$client['client_unique_identifier']."]".substr($client['client_nickname'], 0, 10)."...[/url]", $lang['pokeMessage']));
                }
              }
            }
          }
        }
      }
    }
}
