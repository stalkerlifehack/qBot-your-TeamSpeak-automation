<?php

/**********************************************

         Plik: clientChannelInfo.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class clientChannelInfo
{
    public function start($ts, $client, $config, $lastChannel)
    {
        if ($client['cid'] == $config['channelId']) {

            $simpleVars = ['[nick]', '[uid]', '[ip]', '[date]', '[time]', '[timeRank]', '[conn]', '[connRank]', '[afk]', '[afkRank]'];
            $vars = [$client['client_nickname'], $client['client_unique_identifier'], $client['connection_client_ip'], date("Y-m-d H:i", $client['client_created']) , self::getTopTime($client) [0], self::getTopTime($client) [1], self::topConnection($client) [0], self::topConnection($client) [1], self::topAfk($client) [0], self::topAfk($client) [1]];

            foreach($config['msg'] as $msg){
              $ts->sendMessage(1, $client['clid'], str_replace($simpleVars, $vars, $msg));
            }

            $ts->clientMove($client['clid'], $lastChannel);
            return $lastChannel;
        }
    }

    private static function getTopTime($client)
    {
        $data = json_decode(file_get_contents("cache/topConnectedTime.json"), true);
        arsort($data);
        $i = 1;
        foreach ($data as $index => $value) {
            if ($client['client_database_id'] == $index) {
                $msg = [0 => qBot::convertThirdSecond($value['t']) , 1 => $i];
            }

            $i++;
        }

        if (empty($msg)) {
            return $msg = [0 => 'NaN', 1 => 'NaN'];
        } else {
            return $msg;
        }
    }

    private static function topConnection($client)
    {
        $data = json_decode(file_get_contents("cache/topConnections.json"), true);
        arsort($data);
        $i = 1;
        foreach ($data as $index => $value) {
            if ($client['client_database_id'] == $index) {
                $msg = [0 => $value['c'], 1 => $i];
            }

            $i++;
        }

        if (empty($msg)) {
            return $msg = [0 => 'NaN', 1 => 'NaN'];
        } else {
            return $msg;
        }
    }

    private static function topAfk($client)
    {
        $data = json_decode(file_get_contents("cache/topAfkSpent.json"), true);
        arsort($data);
        $i = 1;
        foreach ($data as $index => $value) {
            if ($client['client_database_id'] == $index) {
                $msg = [0 => qBot::convertThirdSecond($value['t']) , 1 => $i];
            }

            $i++;
        }

        if (empty($msg)) {
            return $msg = [0 => 'NaN', 1 => 'NaN'];
        } else {
            return $msg;
        }
    }
}
