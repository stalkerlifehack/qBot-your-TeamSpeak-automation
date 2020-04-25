<?php

/**********************************************

         Plik: groupOnlineComm.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

  class groupOnlineComm
  {
      public function start($ts, $config, $client, $lang)
      {
          preg_match('/((!groupOnline)(.)(add)(.)([0-9]*)(.)([0-9]*)(.)(.*))|((!groupOnline)(.)(remove)(.)([0-9]*)(.)([0-9]*))|((!groupOnline)(.)(list|help))/', $client['msg'], $command);
          if (strstr($client['msg'], "!groupOnline") !== false) {
              if (array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                  if (@$command[4] == 'add' && !empty($command[6]) && !empty($command[8]) && !empty($command[10])) {
                      $data = json_decode(file_get_contents("cache/groupOnline.json"), true);
                      if (empty($data[$command[6]])) {
                          $data[$command[6]] = [
                            'sgid' => $command[8],
                            'name' => substr($command[10], 1, -1)
                          ];
                          file_put_contents("cache/groupOnline.json", json_encode($data));
                          $ts->sendMessage(1, $client['invokerid'], $lang['addedEntry']);
                      } else {
                          $ts->sendMessage(1, $client['invokerid'], $lang['existingEntry']);
                      }
                  } elseif (@$command[14] == 'remove' || !empty($command[16]) || !empty($command[18])) {
                      $data = json_decode(file_get_contents("cache/groupOnline.json"), true);
                      if (!empty($data[$command[16]])) {
                          unset($data[$command[16]]);
                          file_put_contents("cache/groupOnline.json", json_encode($data));
                          $ts->sendMessage(1, $client['invokerid'], $lang['removedEntry']);
                      } else {
                          $ts->sendMessage(1, $client['invokerid'], $lang['notExistingEntry']);
                      }
                  } elseif (@$command[22] == 'list') {
                      $data = json_decode(file_get_contents("cache/groupOnline.json"), true);
                      $ts->sendMessage(1, $client['invokerid'], $lang['listOfEntries']);
                      foreach ($data as $channel => $group) {
                          $ts->sendMessage(1, $client['invokerid'], str_replace(['[channel]', '[group]'], [$channel, $group], $lang['entryInfo']));
                      }
                  } elseif (@$command[22] == 'help') {
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
