<?php

/**********************************************

         Plik: banList.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class banList
{
    public function start($ts, $config)
    {
        $i = 0;
        foreach ($ts->banList()['data'] as $ban) {
            if (!empty($ban['uid'])) {
                if ($ban['duration'] == 0) {
                    $ban['duration'] = 'Perm';
                }
                $var = [
                  $ban['lastnickname'],
                  $ban['reason'],
                  ($ban['duration'] == 0) ? 'Perm' : qBot::convertSecondsSecond($ban['duration']),
                  date('Y-m-d H:i', $ban['created']),
                  $ban['invokername'],
                  $ban['uid'],
                  $ban['invokeruid'],
                  $i
                ];

                $simpleVar = [
                  '[nickBanned]',
                  '[reason]',
                  '[duration]',
                  '[created]',
                  '[adminNick]',
                  '[uidBanned]',
                  '[invokeruid]',
                ];

                $config['topDesc'] .= str_replace($simpleVar, $var, $config['desc']);
                $i++;
                if ($config['count'] == $i) {
                    break;
                }
            }
        }
        $config['topDesc'] .= $config['footer'];
        if (qBot::removeChars($ts->channelInfo($config['channelId'])['data']['channel_description']) != qBot::removeChars($config['topDesc'])) {
            $ts->channelEdit($config['channelId'], [
              'channel_description' => $config['topDesc']
            ]);
        }
    }
}
