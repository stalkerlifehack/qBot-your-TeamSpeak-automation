<?php

/**********************************************

         Plik: guildChat.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class guildChat
{
    public function start($ts, $config, $client, $lang)
    {
        if (self::checkRank($ts, $config, $client)) {
            if (strstr($client['msg'], "!switch") !== false) {
                self::switch($ts, $config, $client);
            } elseif (strstr($client['msg'], "!mute") !== false) {
                self::mute($ts, $config, $client);
            } elseif (strstr($client['msg'], "!unmute") !== false) {
                self::unmute($ts, $config, $client);
            } elseif (strstr($client['msg'], "!help") !== false) {
                self::help($ts, $config, $client);
            } elseif (strstr($client['msg'], "!chat list") !== false) {
                self::chatList($ts, $config, $client);
            } elseif (strstr($client['msg'], "!chat help") !== false) {
                self::chatHelp($ts, $config, $client);
            } else {
                self::chat($ts, $config, $client);
            }
        }
    }

    private function chat($ts, $config, $command)
    {
        foreach ($ts->clientList()['data'] as $user) {
            $all[$user['client_database_id']] = $user['clid'];
        }

        $groups = qBot::getClanData();

        $settings = json_decode(file_get_contents('cache/guildChatSettings.json'), true);

        $data = json_decode(file_get_contents('cache/guildChat.json'), true);

        $client = $ts->clientInfo($command['invokerid'])['data'];

        if (array_intersect($groups, explode(",", $client['client_servergroups']))) {


        # grupy ktore ma uzytkownik do czatu
            $chatGroups = array_values(array_intersect($groups, explode(",", $client['client_servergroups'])));



            # jesli klient jest tylko w 1 grupie do pisania
            $count = count($chatGroups);

            if ($count == 1) {

                foreach ($ts->serverGroupClientList($chatGroups[0])['data'] as $user) {
                    if (is_array($user) && !empty($user)) {
                        if ($user['cldbid'] == $client['client_database_id']) {
                            $send = $user['cldbid'];
                        }

                        if (@self::checkMute($ts, $data, $command, $settings, $send, null)) {

                            # zeby do siebie nie wysylal
                            if (@$user['cldbid'] != $client['client_database_id']) {
                                if (empty($data[$user['cldbid']]) || $chatGroups[0] == $data[$user['cldbid']]) {
                                    if (self::checkMute($ts, $data, $command, $settings, null, $user['cldbid'])) {
                                        @$ts->sendMessage(1, $all[$user['cldbid']], '[color=blue]['.qBot::getGroupName($ts, $chatGroups[0]).'][/color] [color=red]['.$command['invokername'].']:[/color]: '.$command['msg']);
                                    }
                                }
                            }
                        }
                    }
                    unset($send);
                }
            }
            #jesli wiecej
            else {
                # jesli nie ma klienta w pliku
                if (empty($data[$client['client_database_id']])) {
                    $ts->sendMessage(1, $command['invokerid'], $lang['moreThan1']);

                    foreach ($chatGroups as $chatGroup) {
                        foreach ($ts->serverGroupList()['data'] as $servergroup) {
                            if ($servergroup['sgid'] == $chatGroup) {
                                $ts->sendMessage(1, $command['invokerid'], "[i][b]".$chatGroup."[/b] - ".$servergroup['name']."/[i]");
                            }
                        }
                    }
                } else {
                    foreach ($ts->serverGroupClientList($data[$client['client_database_id']]) as $user) {
                        if (is_array($user) && !empty($user)) {
                            if (self::checkMute($ts, $data, $command, $settings, $client['client_database_id'], null)) {
                                foreach ($user as $usr) {
                                    if (@$usr['cldbid'] != $client['client_database_id']) {
                                        if (empty($data[$usr['cldbid']]) || $data[$client['client_database_id']] == $data[$usr['cldbid']]) {
                                            if (self::checkMute($ts, $data, $command, $settings, null, $usr['cldbid'])) {
                                                @$ts->sendMessage(1, $all[$usr['cldbid']], '[color=blue]['.qBot::getGroupName($ts, $data[$client['client_database_id']]).'][/color] [color=red]['.$command['invokername'].']:[/color] '.$command['msg']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $ts->sendMessage(1, $command['invokerid'], $lang['noGroups']);
        }
    }

    private function switch($ts, $config, $command)
    {
        $client = $ts->clientInfo($command['invokerid'])['data'];
        $groups = qBot::getClanData();
        $chatGroups = array_values(array_intersect($groups, explode(",", $client['client_servergroups'])));
        $count = count($chatGroups);

        if ($count != 1) {
            preg_match('/(!switch)(.)([0-9]*)/', $command['msg'], $matches);

            if (@in_array($matches[3], $groups) && in_array($matches[3], explode(",", $client['client_servergroups']))) {
                $data = json_decode(file_get_contents('cache/guildChat.json'), true);

                $data[$client['client_database_id']] = $matches[3];

                file_put_contents('cache/guildChat.json', json_encode($data));

                if (!empty($data[$client['client_database_id']])) {
                    $ts->sendMessage(1, $command['invokerid'], $lang['chatChanged']);
                } else {
                    $ts->sendMessage(1, $command['invokerid'], $lang['errorSave']);
                }
            } else {
                $ts->sendMessage(1, $command['invokerid'], $lang['notExists']);
            }
        } else {
            $ts->sendMessage(1, $command['invokerid'], $lang['notForOneGroup']);
        }
    }

    private function checkRank($ts, $config, $command)
    {
        $groups = qBot::getClanData();

        $client = $ts->clientInfo($command['invokerid'])['data'];

        $data = json_decode(file_get_contents('cache/guildChat.json'), true);

        if (@!in_array($data[$client['client_database_id']], explode(",", $client['client_servergroups']))) {
            unset($data[$client['client_database_id']]);
        }

        file_put_contents('cache/guildChat.json', json_encode($data));

        if (!array_intersect($groups, explode(",", $client['client_servergroups']))) {
            $ts->sendMessage(1, $command['invokerid'], $lang['noGroups']);
            return false;
        } else {
            return true;
        }
    }

    private function mute($ts, $config, $command)
    {
        $client = $ts->clientInfo($command['invokerid'])['data'];
        $data = json_decode(file_get_contents('cache/guildChatSettings.json'), true);
        $group = json_decode(file_get_contents('cache/guildChat.json'), true);

        preg_match('/(!mute)(.)([0-9]*)/', $command['msg'], $matches);

        # mutowanie na czas
        if (!empty($matches[3]) && is_numeric($matches[3])) {
            @$data[$group[$client['client_database_id']]][$client['client_database_id']]['mute'] = time() + $matches[3];
            file_put_contents('cache/guildChatSettings.json', json_encode($data));
            $ts->sendMessage(1, $command['invokerid'], str_replace('[seconds]', $matches[3], $lang['mutedFor']));
        } else {
            @$data[$group[$client['client_database_id']]][$client['client_database_id']]['mute'] = -1;
            file_put_contents('cache/guildChatSettings.json', json_encode($data));
            $ts->sendMessage(1, $command['invokerid'], $lang['mutedForever']);
        }
    }

    private function unmute($ts, $config, $command)
    {
        $client = $ts->clientInfo($command['invokerid'])['data'];
        $data = json_decode(file_get_contents('cache/guildChatSettings.json'), true);
        $group = json_decode(file_get_contents('cache/guildChat.json'), true);

        $data[$group[$client['client_database_id']]][$client['client_database_id']]['mute'] = 0;

        $ts->sendMessage(1, $command['invokerid'], $lang['unmuted']);

        file_put_contents('cache/guildChatSettings.json', json_encode($data));
    }

    private function checkMute($ts, $data, $command, $settings, $sender, $reciever)
    {
        if (@!empty($settings[$data[$sender]][$sender])) {
            if (@$settings[$data[$sender]][$sender]['mute'] != -1) {
                if (@$settings[$data[$sender]][$sender]['mute'] - time() <= 0) {
                    return true;
                } else {
                    @$time = $settings[$data[$sender]][$sender]['mute']-time();
                    $ts->sendMessage(1, $command['invokerid'], str_replace('[seconds]', $time, $lang['mutedFor']));
                    return false;
                }
            } else {
                $ts->sendMessage(1, $command['invokerid'], $lang['mutedForever']);
                return false;
            }
        } elseif (@!empty($settings[$data[$reciever]][$reciever])) {
            if (@$settings[$data[$reciever]][$reciever]['mute'] != -1) {
                if (@$settings[$data[$reciever]][$reciever]['mute'] - time() <= 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    private function enableChatMessage($ts, $config, $command)
    {
        $client = $ts->clientInfo($command['invokerid'])['data'];

        $data = json_decode(file_get_contents('cache/guildChatMessageStatus.json'), true);

        if ($command['msg'] == '!chat message on') {
            $data[$client['client_database_id']] = 1;
            $ts->sendMessage(1, $command['invokerid'], $lang['turnedOnConnect']);
        } elseif ($command['msg'] == '!chat message off') {
            $data[$client['client_database_id']] = 0;
            $ts->sendMessage(1, $command['invokerid'], $lang['turnedOffConnect']);
        }

        file_put_contents('cache/guildChatMessageStatus.json', json_encode($data));
    }

    private function help($ts, $config, $command)
    {
        foreach ($config['help'] as $msg) {
            $ts->sendMessage(1, $command['invokerid'], $msg);
        }
    }

    private function chatList($ts, $config, $command)
    {
        $groups = qBot::getClanData();

        $client = $ts->clientInfo($command['invokerid'])['data'];
        $chatGroups = array_values(array_intersect($groups, explode(",", $client['client_servergroups'])));

        $ts->sendMessage(1, $command['invokerid'], $lang['allGroups']);

        foreach ($chatGroups as $chatGroup) {
            foreach ($ts->serverGroupList()['data'] as $servergroup) {
                if ($servergroup['sgid'] == $chatGroup) {
                    $ts->sendMessage(1, $command['invokerid'], "[i]   [b]$chatGroup [/b] - ".$servergroup['name']);
                }
            }
        }
    }

}
