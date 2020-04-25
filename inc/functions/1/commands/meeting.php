<?php

/**********************************************

         Plik: meeting.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

  class meeting
  {
      public function start($ts, $config, $client, $lang)
      {
          if ($client['msg'] == '!meeting') {
              if (array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                  foreach ($ts->clientList()['data'] as $user) {
                      $data[$user['client_database_id']] = $user['clid'];
                  }
                  foreach ($config['adminGroups'] as $group) {
                      foreach ($ts->serverGroupClientList($group)['data'] as $admin) {
                          $ts->clientMove(@$data[$admin['cldbid']], $config['channelId']);
                          $data[$client['invokerid']] = $config['channelId'];

                          if (@$data[$admin['cldbid']] != $client['invokerid']) {
                              $ts->clientPoke(@$data[$admin['cldbid']], $lang['moved']);
                          }
                      }
                  }
                  return $data;
              }
              else {
                  $ts->sendMessage(1, $client['invokerid'], $lang['notAuthorized']);
              }
          }
      }
  }
