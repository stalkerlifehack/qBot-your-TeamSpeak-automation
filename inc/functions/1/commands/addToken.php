<?php

/**********************************************

         Plik: addToken.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class addToken
{
    public function start($ts, $config, $client, $lang)
    {
        preg_match('/(!addToken)(.)([0-9]*)(.)([0-9]*)/', $client['msg'], $command);
        if (strstr($client['msg'], "!addToken") !== false) {
            if (array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                
                if (!empty($command[3]) && !empty($command[5])) {
                  if(!in_array($command[3], $config['disAllowedGroups'])){
                      $data = json_decode(file_get_contents('cache/generatedTokens.json'), true);

                      $token = $ts->privilegekeyAdd(0, $command[3], null);

                      if ($token['success']) {
                          $data[$token['data']['token']] = [
                            'group' => $command[3],
                            'time' => $command[5]
                          ];
                          $ts->sendMessage(1, $client['invokerid'], str_replace('[token]', $token['data']['token'], $lang['tokenMessage']));
                          file_put_contents('cache/generatedTokens.json', json_encode($data));
                      }
                    }
                    else{
                      $ts->sendMessage(1, $client['invokerid'], $lang['disallowedGroup']);
                    }


                } elseif ($client['msg'] == '!addToken help') {
                    $t = $ts->sendMessage(1, $client['invokerid'], $lang['usage']);
                } else {
                    $ts->sendMessage(1, $client['invokerid'], $lang['badCommand']);
                }
            } else {
                $ts->sendMessage(1, $client['invokerid'], $lang['noPermits']);
            }
        }
    }
}
