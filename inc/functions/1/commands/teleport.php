<?php

/**********************************************

         Plik: teleport.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class teleport
{
    public function start($ts, $config, $client, $lang)
    {
        preg_match('/((!warp)(.)(list))|((!warp)(.)([0-9]*))/', $client['msg'], $command);
        if (strstr($client['msg'], "!warp") !== false) {
            if (empty($config['allowedGroups']) || array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                if (@$command[4] == 'list') {
                    $data = json_decode(file_get_contents('cache/teleport.json'), true);
                    $i = 1;
                    if (!empty($data)) {
                        $ts->sendMessage(1, $client['invokerid'], $lang['usage']);
                        foreach ($data as $group) {
                            $ts->sendMessage(1, $client['invokerid'], "[b]$i [/b]- [i]".qBot::getGroupName($ts, $group)."[/i]");
                            $i++;
                        }
                    } else {
                        $ts->sendMessage(1, $client['invokerid'], $lang['noWarps']);
                    }
                } elseif (!empty($command[8])) {
                    $data = json_decode(file_get_contents('cache/teleport.json'), true);
                    if (!empty($data)) {
                        $i = 1;
                        foreach ($data as $channel => $group) {
                            if ($i == $command[8]) {
                                $ts->clientMove($client['invokerid'], $channel);
                                $ts->sendMessage(1, $client['invokerid'], str_replace(['[group_name]', '[user]'], [qBot::getGroupName($ts, $group), "[url=client://0/".$client['invokeruid']."]klik[/url]"], $lang['moved']));
                                $data[$client['invokerid']] = $channel;
                                return $data;
                            }
                            $i++;
                        }
                        if (!isset($data[$client['invokerid']])) {
                            $ts->sendMessage(1, $client['invokerid'], $lang['notExistingWarp']);
                        }
                    } else {
                        $ts->sendMessage(1, $client['invokerid'], $lang['notExistingWarp']);
                    }
                } else {
                    $ts->sendMessage(1, $client['invokerid'], $lang['usageList']);
                }
            } else {
                $ts->sendMessage(1, $client['invokerid'], $lang['notAuthorized']);
            }
        }
    }
}
