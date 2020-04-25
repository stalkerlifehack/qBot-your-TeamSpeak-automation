<?php

/**********************************************

         Plik: newUsersToday.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class newUsersToday
{
    public function start($ts, $config, $client)
    {
        $data = json_decode(file_get_contents("cache/newUsersToday.json"), true);


        $clientInfo = $ts->clientInfo($client['clid'])['data'];
        if ($clientInfo['client_totalconnections'] == 1 && $client['client_type'] == 0 && empty($data[$clientInfo['client_database_id']]) && !array_intersect($config['ignoredGroups'], explode(",", $clientInfo['client_servergroups']))) {
            if (!in_array($client['connection_client_ip'], $config['ignoredIp'])) {
                $data[$clientInfo['client_database_id']] = [
                'hour' => date("H:i", $clientInfo['client_created']),
                'date' => date("Y-m-d", $clientInfo['client_created'])
              ];
            }
        }
        foreach ($data as $id => $value) {
            $clientInfo = $ts->clientDbInfo($id)['data'];
            if ($value['date'] == date('Y-m-d') && array_key_exists('client_unique_identifier', $clientInfo)) {
                $config['topDesc'] .= str_replace(['[uid]', '[nick]', '[hour]'], [$clientInfo['client_unique_identifier'], $clientInfo['client_nickname'], $value['hour']], $config['desc']);
            }
        }

        $config['topDesc'] .= $config['footer'];
        $ts->channelEdit($config['channelId'], array(
          'channel_name' => str_replace('[count]', count($data), $config['channelName']),
          'channel_description' => $config['topDesc']
        ));
        file_put_contents("cache/newUsersToday.json", json_encode($data));
    }
}
