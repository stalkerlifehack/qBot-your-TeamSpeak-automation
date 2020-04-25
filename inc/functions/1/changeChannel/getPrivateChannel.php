<?php

/**********************************************

         Plik: getPrivateChannel.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class getPrivateChannel
{
    public function start($ts, $client, $config, $lastChannel, $lang)
    {
        if ($client['cid'] == $config['channelId']) {
            $channels = json_decode(file_get_contents(("cache/getPrivateChannel.json")), true);

            $data = qBot::getClientData($channels);

            if (empty($data[$client['client_database_id']]) && empty($data[$client['connection_client_ip']])) {
                $count = qBot::getChannels($ts, $config);
                $info = $ts->channelCreate([
                      'channel_name' => str_replace(['[num]', '[nick]'], [$count+1, $client['client_nickname']], $config['channelName']),
                      'channel_flag_permanent' => 1,
                      'cpid' => $config['mainChannelId'],
                      'channel_password' => $passwd = rand(9999, 99999),
                      'channel_topic' => date("Y.m.d"),
                      'channel_description' => $config['topDesc'].str_replace(['[owner]', '[date]'], [$client['client_nickname'], date('Y-m-d')], $config['desc']).$config['footer'],
                      'channel_codec_quality' => 10
                    ])['data'];
                for ($i = 1; $i <= $config['subChannels']; $i++) {
                    $ts->channelCreate([
                          'channel_name' => str_replace('[num]', $i, $config['subChannelName']),
                          'channel_flag_permanent' => 1,
                          'cpid' => $info['cid'],
                          'channel_password' => $passwd,
                          'channel_codec_quality' => 10
                        ]);
                }

                $channels[] = [
                      'clientNickname' => $client['client_nickname'],
                      'cldbid' => $client['client_database_id'],
                      'ip' => $client['connection_client_ip'],
                      'created' => date('Y-m-d'),
                      'channelId' => $info['cid']
                    ];


                file_put_contents("cache/getPrivateChannel.json", json_encode($channels));

                $ts->sendMessage(1, $client['clid'], str_replace('[passwd]', $passwd, $config['msg']));
                $ts->clientMove($client['clid'], $info['cid']);
                $ts->setClientChannelGroup($config['channelGroupId'], $info['cid'], $client['client_database_id']);
                return $info['cid'];
            } else {
                if (!empty($data[$client['client_database_id']])) {
                    $ts->clientMove($client['clid'], $data[$client['client_database_id']]);
                    $ts->clientPoke($client['clid'], $lang['alreadyOwner']);
                    $ts->setClientChannelGroup($config['channelGroupId'], $data[$client['client_database_id']], $client['client_database_id']);
                    return $data[$client['client_database_id']];
                } else {
                    $ts->clientMove($client['clid'], $data[$client['connection_client_ip']]);
                    $ts->clientPoke($client['clid'], $lang['alreadyOwner']);
                    $ts->setClientChannelGroup($config['channelGroupId'], $data[$client['connection_client_ip']], $client['client_database_id']);
                    return $data[$client['connection_client_ip']];
                }
            }
        }
    }
}
