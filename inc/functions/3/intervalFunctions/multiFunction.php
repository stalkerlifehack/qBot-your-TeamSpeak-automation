<?php

/**********************************************

         Plik: multiFunction.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class multiFunction
{
    public function start($ts, $config)
    {
        $server = $ts->serverInfo()['data'];
        foreach ($config['enabledFunctions'] as $function) {
            self::$function($ts, $server, $config['cfg'][$function]);
        }
    }
    private static function onlineOnChannel($ts, $server, $config)
    {
        $name = str_replace(['[on]', '[max]'], [$server['virtualserver_clientsonline']-$server['virtualserver_queryclientsonline'], $server['virtualserver_maxclients']], $config['channelName']);

        $ts->channelEdit($config['channelId'], [
              'channel_name' => $name
            ]);
    }
    private static function pingOnChannel($ts, $server, $config)
    {
        $name = str_replace('[ping]', round($server['virtualserver_total_ping'], 2), $config['channelName']);

        $ts->channelEdit($config['channelId'], [
            'channel_name' => $name
          ]);
    }
    private static function packetLossOnChannel($ts, $server, $config)
    {
        $name = str_replace('[packet]', round($server['virtualserver_total_packetloss_total'], 2), $config['channelName']);

        $ts->channelEdit($config['channelId'], [
            'channel_name' => $name
          ]);
    }
    private static function uptimeOnChannel($ts, $server, $config)
    {
        $name = str_replace('[uptime]', qBot::convertSecondsSecond($server['virtualserver_uptime']), $config['channelName']);

        $ts->channelEdit($config['channelId'], [
            'channel_name' => $name
          ]);
    }
    private static function queryClientsOnline($ts, $server, $config)
    {
        foreach ($ts->clientList('-uid')['data'] as $client) {
            if ($client['client_type'] != 0) {
                $config['topDesc'] .= str_replace(['[uid]', '[nick]'], [$client['client_unique_identifier'], $client['client_nickname']], $config['desc']);
            }
        }
        $config['topDesc'] .= $config['footer'];
        $name = str_replace('[on]', $server['virtualserver_queryclientsonline'], $config['channelName']);

        $ts->channelEdit($config['channelId'], [
            'channel_description' => $config['topDesc'],
            'channel_name' => $name
          ]);
    }
    private static function adminCount($ts, $server=null, $config)
    {
        $status = [
          'online' => 0,
          'all' => 0
        ];
        foreach ($ts->clientList()['data'] as $client) {
            $ids[] = $client['client_database_id'];
        }
        foreach ($config['groups'] as $group) {
            foreach ($ts->serverGroupClientList($group)['data'] as $admin) {
                $status['all']++;
                if (@in_array($admin['cldbid'], $ids)) {
                    $status['online']++;
                }
            }
        }
        $name = str_replace(['[on]', '[all]'], [$status['online'], $status['all']], $config['channelName']);

        $ts->channelEdit($config['channelId'], [
            'channel_name' => $name
          ]);
    }
}
