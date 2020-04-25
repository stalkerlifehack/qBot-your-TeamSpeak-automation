<?php

/**********************************************

         Plik: checkDescriptionLinks.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class checkDescriptionLinks
{
    public function start($ts, $config, $client, $channelId)
    {
        if (!in_array($channelId, $config['ignoredChannels'])) {
            $desc = $ts->channelInfo($channelId)['data']['channel_description'];
            preg_match_all('/((?i)(\[url=)(.*?)(?i)(\])(.*?)(?i)(\[\/url\]))|((?i)(\[url\])(.*?)(?i)(\[\/url\]))|(?i)(\[url=)(.*?)(?i)(\])/', strtolower($desc), $matches);
            foreach ($matches[0] as $index => $value) {
                if (!empty($matches[9][$index]) && !strstr($matches[9][$index], "client://") !== false && !strstr($matches[9][$index], "channelid://") !== false) {
                    if (qBot::checkLink($matches[9][$index], $config)) {
                        $desc = str_replace($matches[9][$index], $config['replace'], $desc);
                        $i = 1;
                    }
                } elseif (!empty($matches[3][$index]) && !empty($matches[5][$index])) {
                    if (!strstr($matches[3][$index], "client://") !== false && !strstr($matches[3][$index], "channelid://") !== false) {
                        if (qBot::checkLink($matches[3][$index], $config)) {
                            $desc = str_replace($matches[3][$index], $config['replace'], $desc);
                            $i = 1;
                        }
                    }
                    if (!strstr($matches[5][$index], "client://") !== false && !strstr($matches[5][$index], "channelid://") !== false) {
                        if (@gethostbyname(@parse_url($matches[5][$index])['host']) != @parse_url($matches[5][$index])['host']) {
                            $desc = str_replace($matches[5][$index], $config['replace'], $desc);
                            $i = 1;
                        }
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
