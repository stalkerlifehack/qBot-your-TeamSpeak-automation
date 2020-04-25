<?php

/**********************************************

         Plik: serverGroupProtection.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class serverGroupProtectionComm
{
    public function start($ts, $config, $client, $lang)
    {
        preg_match('/(!serverGroupProtection)(.)(add|remove)(.)([0-9]*)(.)(.*)/', $client['msg'], $command);
        if (strstr($client['msg'], "!serverGroupProtection") !== false) {
            if (array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                if (@$command[3] == 'add' && !empty($command[5]) && !empty($command[7])) {
                    $data = json_decode(file_get_contents('cache/serverGroupProtection.json'), true);
                    foreach (explode(",", $command[7]) as $group) {
                        if (!in_array($group, $data[$command[5]])) {
                            $data[$command[5]][] = $group;
                            $i = 1;
                        }
                    }
                    if (!empty($i)) {
                        $ts->sendMessage(1, $client['invokerid'], $lang['addedEntry']);
                    } else {
                        $ts->sendMessage(1, $client['invokerid'], $lang['existingEntry']);
                    }

                    file_put_contents('cache/serverGroupProtection.json', json_encode($data));
                } elseif (@$command[3] == 'remove' && !empty($command[5]) && !empty($command[7])) {
                    $data = json_decode(file_get_contents('cache/serverGroupProtection.json'), true);
                    foreach ($data[$command[5]] as $index => $group) {
                        if (in_array($group, explode(",", $command[7]))) {
                            unset($data[$command[5]][$index]);
                            $i = 1;
                        }
                    }
                    if (!empty($i)) {
                        $ts->sendMessage(1, $client['invokerid'], $lang['removedEntry']);
                    } else {
                        $ts->sendMessage(1, $client['invokerid'], $lang['notExistingEntry']);
                    }

                    file_put_contents('cache/serverGroupProtection.json', json_encode($data));
                } elseif ($client['msg'] == '!serverGroupProtection list') {
                    $data = json_decode(file_get_contents('cache/serverGroupProtection.json'), true);
                    $ts->sendMessage(1, $client['invokerid'], $lang['listOfEntries']);
                    foreach ($data as $cldbid => $groups) {
                        $ts->sendMessage(1, $client['invokerid'], str_replace(['[cldbid]', '[groups]', '[client_name]'], [$cldbid, implode(",", $groups), $ts->clientGetNameFromDbid($cldbid)['data']['name']], $lang['entryInfo']));
                    }
                } elseif ($client['msg'] == '!serverGroupProtection help') {
                    $ts->sendMessage(1, $client['invokerid'], $lang['availableCommands']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command1']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command2']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command3']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['command4']);
                    $ts->sendMessage(1, $client['invokerid'], " ");
                    $ts->sendMessage(1, $client['invokerid'], $lang['example1']);
                    $ts->sendMessage(1, $client['invokerid'], $lang['example2']);
                } else {
                    $ts->sendMessage(1, $client['invokerid'], $lang['usage']);
                }
            } else {
                $ts->sendMessage(1, $client['invokerid'], $lang['notAuthorized']);
            }
        }
    }
}
