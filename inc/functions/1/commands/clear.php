<?php

/**********************************************

         Plik: clear.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

  class clear
  {
      public function start($ts, $config, $client, $lang)
      {
          preg_match('/!clear/', $client['msg'], $matches);
          if (@$matches[0] == '!clear') {
              if (array_intersect(qBot::getGroupsFromId($ts, $client['invokerid']), $config['allowedGroups'])) {
                  $ts->sendMessage(1, $client['invokerid'], "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n.");
              } else {
                  $ts->sendMessage(1, $client['invokerid'], $lang['notAuthorized']);
              }
          }
      }
  }
