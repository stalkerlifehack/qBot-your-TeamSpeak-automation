<?php

/**********************************************

         Plik: pwAll.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class pwAll
{
    public function start($ts, $config, $client, $lang)
    {
        preg_match('/(!pwAll)(.)(.*)/', $client['msg'], $command);
        if (strstr($client['msg'], "!pwAll") !== false) {
            if (array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                if (!empty($command[3])) {
                    if (strlen($command[3]) <= 1024) {
                        $count = 0;
                        foreach ($ts->clientList()['data'] as $index => $user) {
                            if ($user['client_type'] == 0 && $user['clid'] != $client['invokerid']) {
                                $count++;
                                $ts->sendMessage(1, $user['clid'], $command[3]);
                            }
                        }
                        $ts->sendMessage(1, $client['invokerid'], str_replace('[count]', $count, $lang['messagedCount']));
                    } else {
                        $ts->sendMessage(1, $client['invokerid'], $lang['tooLongMessage']);
                    }
                } else {
                    $ts->sendMessage(1, $client['invokerid'], $lang['usage']);
                }
            } else {
                $ts->sendMessage(1, $client['invokerid'], $lang['notAuthorized']);
            }
        }
    }
}
