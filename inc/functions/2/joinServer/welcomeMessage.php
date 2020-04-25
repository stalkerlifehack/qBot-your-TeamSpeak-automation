<?php

/**********************************************

         Plik: welcomeMessage.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class welcomeMessage
{
    public function start($ts, $config, $client)
    {
        if ($client['client_totalconnections'] <= $config['maxConnections'] || !$config['enabledMaxConnections']) {
            if (!array_intersect(explode(',', $client['client_servergroups']), $config['ignoredGroups'])) {
                $server = $ts->serverInfo()['data'];
                $simpleVars = ['[nick]', '[uptime]', '[on]', '[max]'];
                $vars = [$client['client_nickname'], qBot::convertThirdSecond($server['virtualserver_uptime']), $server['virtualserver_clientsonline']-$server['virtualserver_queryclientsonline'], $server['virtualserver_maxclients']];
                foreach ($config['msg'] as $cfg) {
                    $ts->sendMessage(1, $client['clid'], str_replace($simpleVars, $vars, $cfg));
                }
            }
        }
    }
}
