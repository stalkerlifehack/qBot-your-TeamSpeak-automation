<?php

/**********************************************

         Plik: checkDescriptionImage.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class checkDescriptionImage
{
    public function start($ts, $config, $client, $channelId)
    {
        if (!in_array($channelId, $config['ignoredChannels'])) {
            $channel = $ts->channelInfo($channelId)['data'];
            preg_match_all('/(?i)\[img\][ ]*(.*?)(?i)[ ]*\[\/img\]|(?i)\[img\][ ]*(.*?)(?i)[ ]|(?i)\[img\][ ]*(.*?)(?i)$/', $channel['channel_description'], $matches);
            if (empty($matches[1][0]) && empty($matches[2][0]) && !empty($matches[3][0])) {
                if (qBot::checkLink($matches[3][0], $config)) {
                    $data = $ts->channelEdit($channelId, [
                      'channel_description' => str_replace($matches[3][0], $config['replace']."[/img]", $channel['channel_description'])
                    ]);
                    if (!$data['success']) {
                        $data = $ts->channelEdit($channelId, [
                          'channel_description' => ""
                        ]);
                    }
                    $ts->sendMessage(1, $client['clid'], $config['msg']);
                }
            } elseif (!empty($matches[1][0]) && empty($matches[2][0]) && empty($matches[3][0])) {
                $desc = $channel['channel_description'];
                foreach ($matches[1] as $match) {
                    if (qBot::checkLink($match, $config)) {
                        $desc = str_replace($match, $config['replace'], $desc);
                        $i = 1;
                    }
                }
                foreach ($matches[3] as $match) {
                    if (!empty($match)) {
                        if (qBot::checkLink($match, $config)) {
                            $desc = str_replace($match, $config['replace'], $desc);
                            $i = 1;
                        }
                    }
                }
                if (@$i) {
                    $data = $ts->channelEdit($channelId, [
                      'channel_description' => $desc
                    ]);
                    if (!$data['success']) {
                        $data = $ts->channelEdit($channelId, [
                          'channel_description' => ""
                        ]);
                    }
                    $ts->sendMessage(1, $client['clid'], $config['msg']);
                }
            }
        }
    }
}
