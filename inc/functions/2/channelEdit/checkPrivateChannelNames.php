<?php

/**********************************************

         Plik: checkPrivateChannels.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class checkPrivateChannelNames
{
    public function start($ts, $config, $client, $channelId)
    {
        $index = qBot::getIndex($channelId);
        if (!empty($index)) {
            $channel = $ts->channelInfo($channelId)['data'];
            preg_match(str_replace('[num]', $index, $config['regex']), $channel['channel_name'], $matches);
            if (!$matches) {
                $ts->channelEdit($channelId, array(
                  'channel_name' => str_replace(['[num]', '[nick]'], [$index, $client['client_nickname']], $config['channelName'])
                ));
            }
        }
    }
}
