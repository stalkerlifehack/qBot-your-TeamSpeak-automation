<?php

/**********************************************

         Plik: showStatistics.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class showStatistics
{
    public function start($ts, $config)
    {
        $ids = [];
        foreach ($ts->clientList('-groups')['data'] as $client) {
            if (array_intersect($config['ignoredGroups'], explode(",", $client['client_servergroups']))) {
                $ids[] = $client['client_database_id'];
            }
        }
        $i = 0;
        foreach ($config['enabled'] as $function) {
            self::$function($ts, $config['cfg'][$function], $ids, $i, $config['results']);
        }
    }
    private static function topTimeSpent($ts, $config, $ids, $i, $results)
    {
        $data = json_decode(file_get_contents("cache/topTimeSpent.json"), true);

        arsort($data);

        foreach ($data as $index => $value) {
            if (!in_array($index, $ids)) {
                $client = $ts->clientDbInfo($index)['data'];
                $config['topDesc'] .= str_replace(['[nick]', '[uid]', '[time]'], [$client['client_nickname'], $client['client_unique_identifier'], qBot::convertSecondsSecond($value['t'])], $config['desc']);
                $i++;
            }
            if ($i == $results) {
                break;
            }
        }
        $config['topDesc'] .= $config['footer'];
        $ts->channelEdit($config['channelId'], array(
          'channel_description' => $config['topDesc']
        ));
    }

    private static function topAfkSpent($ts, $config, $ids, $i, $results)
    {
        $data = json_decode(file_get_contents("cache/topAfkSpent.json"), true);

        arsort($data);

        foreach ($data as $index => $value) {
            if (!in_array($index, $ids)) {
                $client = $ts->clientDbInfo($index)['data'];
                $config['topDesc'] .= str_replace(['[nick]', '[uid]', '[time]'], [$client['client_nickname'], $client['client_unique_identifier'], qBot::convertSecondsSecond($value['t'])], $config['desc']);
                $i++;
            }
            if ($i == $results) {
                break;
            }
        }
        $config['topDesc'] .= $config['footer'];
        $ts->channelEdit($config['channelId'], array(
          'channel_description' => $config['topDesc']
        ));
    }

    private static function topConnections($ts, $config, $ids, $i, $results)
    {
        $data = json_decode(file_get_contents("cache/topConnections.json"), true);

        arsort($data);

        foreach ($data as $index => $value) {
            if (!in_array($index, $ids)) {
                $client = $ts->clientDbInfo($index)['data'];
                $config['topDesc'] .= str_replace(['[nick]', '[uid]', '[conn]'], [$client['client_nickname'], $client['client_unique_identifier'], $value['c']], $config['desc']);
                $i++;
            }
            if ($i == $results) {
                break;
            }
        }
        $config['topDesc'] .= $config['footer'];
        $ts->channelEdit($config['channelId'], array(
          'channel_description' => $config['topDesc']
        ));
    }

    private static function topConnectedTime($ts, $config, $ids, $i, $results)
    {
        $data = json_decode(file_get_contents("cache/topConnectedTime.json"), true);

        arsort($data);

        foreach ($data as $index => $value) {
            if (!in_array($index, $ids)) {
                $client = $ts->clientDbInfo($index)['data'];
                $config['topDesc'] .= str_replace(['[nick]', '[uid]', '[time]'], [$client['client_nickname'], $client['client_unique_identifier'], qBot::convertSecondsSecond($value['t'])], $config['desc']);
                $i++;
            }
            if ($i == $results) {
                break;
            }
        }
        $config['topDesc'] .= $config['footer'];
        $ts->channelEdit($config['channelId'], array(
          'channel_description' => $config['topDesc']
        ));
    }

}
