<?php

/**********************************************

         Plik: clanGroupComm.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class clanGroupComm
{
    public function start($ts, $config, $client, $lang)
    {
        preg_match('/((!clanGroup)(.)(help|list))|((!clanGroup)(.)((add)|(remove))(.)([0-9]*)(.)([0-9]*))|((!clanGroup))/', $client['msg'], $command);
        if (strstr($client['msg'], "!clanGroup") !== false) {
            if (array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                if (@$command[9] == 'add' && !empty($command[12]) && !empty($command[14]) && empty($command[4])) {
                    $data = json_decode(file_get_contents("cache/clanGroup.json"), true);
                    if (empty($data[$command[12]])) {
                        $data[$command[12]] = $command[14];
                        file_put_contents("cache/clanGroup.json", json_encode($data));
                        $ts->sendMessage(1, $client['invokerid'], $lang['addedEntry']);
                    } else {
                        $ts->sendMessage(1, $client['invokerid'], $lang['existingEntry']);
                    }
                } elseif (@$command[8] == 'remove' && !empty($command[12]) && !empty($command[14]) && empty($command[4])) {
                    $data = json_decode(file_get_contents("cache/clanGroup.json"), true);
                    if (!empty($data[$command[12]])) {
                        unset($data[$command[12]]);
                        file_put_contents("cache/clanGroup.json", json_encode($data));
                        $ts->sendMessage(1, $client['invokerid'], $lang['removedEntry']);
                    } else {
                        $ts->sendMessage(1, $client['invokerid'], $lang['notExistingEntry']);
                    }
                } elseif ($command[4] == 'list') {
                    $data = json_decode(file_get_contents("cache/clanGroup.json"), true);
                    $ts->sendMessage(1, $client['invokerid'], $lang['listOfEntries']);
                    foreach ($data as $channel => $group) {
                        $ts->sendMessage(1, $client['invokerid'], str_replace(['[channel]', '[group]'], [$channel, $group], $lang['entryInfo']));
                    }
                } elseif ($command[4] == 'help') {
                    $ts->sendMessage(1, $client['invokerid'], $lang['availableCommands']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command1']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command2']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command3']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command4']);
                } else {
                    $ts->sendMessage(1, $client['invokerid'], $lang['usage']);
                }
            } else {
                $ts->sendMessage(1, $client['invokerid'], $lang['notAuthorized']);
            }
        }
    }
}
