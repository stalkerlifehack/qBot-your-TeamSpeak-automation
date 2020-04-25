<?php

/**********************************************

         Plik: channelChecker.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class channelChecker
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/getPrivateChannel.json"), true);
        if (!empty($data)) {
            self::updateDate($ts, $config, $data);
        }
    }

    # Aktualizacja daty na kanale
    private static function updateDate($ts, $config, $data)
    {
        foreach ($data as $info) {
            $channels[] = $info['channelId'];
        }

        foreach ($ts->clientList()['data'] as $client) {

      # info o kanale na ktorym jest klient
            $channelInfo = $ts->channelInfo($client['cid'])['data'];
            if (in_array($channelInfo['pid'], $channels) || in_array($client['cid'], $channels)) {
                # Tu siedzą na kanale głównym

                if ($channelInfo['pid'] == $config['mainChannelId']) {
                    if (empty($channelInfo['channel_topic']) || $channelInfo['channel_topic'] != $config['holidayTopic'] && $channelInfo['channel_topic'] != date('Y.m.d')) {
                        $ts->channelEdit($client['cid'], array(
                          'channel_topic' => date('Y.m.d')
                        ));
                    }
                }
                # Tu siedzą na podkanałach
                else {
                    $subChannelInfo = $ts->channelInfo($channelInfo['pid'])['data'];
                    if (empty($subChannelInfo['channel_topic']) || $subChannelInfo['channel_topic'] != $config['holidayTopic'] && $subChannelInfo['channel_topic'] != date('Y.m.d')) {
                        $ts->channelEdit($channelInfo['pid'], array(
                          'channel_topic' => date('Y.m.d')
                        ));
                    }
                }
            }
        }
    }
}
