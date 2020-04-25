<?php

/**********************************************

         Plik: descriptionGuard.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class descriptionGuard
{
    public function start($ts, $config, $client, $channelId, $lang)
    {
        $data = qBot::getDescInfo($channelId);
        if (!empty($data['clientNickname'])) {
            $desc = $config['topDesc'].str_replace(['[owner]', '[date]'], [$data['clientNickname'], $data['created']], $config['desc']).$config['footer'];

            $channel = $ts->channelInfo($channelId)['data'];
            if ($channel['channel_description'] != $desc) {
                $ts->channelEdit($channelId, array(
                  'channel_description' => $desc,
                ));

                $ts->clientPoke($client['clid'], $lang['pokeMessage']);
            }
        }
    }
}
