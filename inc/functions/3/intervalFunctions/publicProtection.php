<?php

/**********************************************

         Plik: publicProtection.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class publicProtection
{
    public function start($ts, $config)
    {
        foreach ($config['cfg'] as $value) {
            $all = 0;
            foreach ($ts->channelList()['data'] as $channel) {
                if ($channel['pid'] == $value['channelId']) {
                    $all++;
                    if ($channel['total_clients'] == 0) {
                        $channels[$value['channelId']][] = $channel['cid'];
                    }
                }
            }
            if (count($channels[$value['channelId']]) > $value['minFreeChannels']) {
                for ($i = count($channels[$value['channelId']]) - 1; $i >= $value['minFreeChannels']; $i--) {
                    $ts->channelDelete($channels[$value['channelId']][$i]);
                }
            }
            if (count($channels[$value['channelId']]) < $value['minFreeChannels']) {
                for ($ch = count($channels[$value['channelId']]); $ch < $value['minFreeChannels']; $ch++) {
                    $all++;
                    if ($value['maxClients'] == 0) {
                        $ts->channelCreate([
                          'channel_name' => str_replace('[num]', $all, $value['channelName']),
                          'cpid' => $value['channelId'],
                          'channel_flag_permanent' => 1,
                          'channel_flag_maxclients_unlimited' => 1,
                          'channel_flag_maxfamilyclients_unlimited' => 1,
                          'channel_codec_quality' => 10
                        ]);
                    } else {
                        $ts->channelCreate([
                            'channel_name' => str_replace('[num]', $all, $value['channelName']),
                            'cpid' => $value['channelId'],
                            'channel_maxclients' => $value['maxClients'],
                            'channel_flag_permanent' => 1,
                            'channel_flag_maxclients_unlimited' => 0,
                            'channel_flag_maxfamilyclients_unlimited' => 1,
                            'channel_codec_quality' => 10
                          ]);
                    }
                }
                unset($ch);
            }
        }
        unset($channels);
    }
}
