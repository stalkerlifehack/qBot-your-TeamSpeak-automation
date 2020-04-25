<?php

/**********************************************

         Plik: autoPoke.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class autoPoke
{
    public function start($ts, $config, $lang)
    {
        foreach ($config['cfg'] as $cfg) {
            foreach ($ts->clientList('-groups -uid -away -voice')['data'] as $client) {
                if ($client['cid'] == $cfg['channelId']) {
                    if (!array_intersect(explode(",", $client['client_servergroups']), $cfg['adminGroups']) && !array_intersect(explode(",", $client['client_servergroups']), $cfg['ignoredGroups'])) {
                        if ($client['client_input_muted'] == 0 && $client['client_output_muted'] == 0 && $client['client_away'] == 0 && $client['client_input_hardware'] == 1) {
                            if (!array_intersect(explode(",", $client['client_servergroups']), $cfg['blockedGroups'])) {
                                if (strlen(str_replace('[user]', "[url=client://0/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url]", $lang['adminPoke'])) <= 100) {
                                    foreach (qBot::getAdmins($cfg, $ts) as $admin) {
                                        $ts->clientPoke($admin, str_replace('[user]', "[url=client://0/".$client['client_unique_identifier']."]".$client['client_nickname']."[/url]", $lang['adminPoke']));
                                    } 
                                } else {
                                    foreach (qBot::getAdmins($cfg, $ts) as $admin) {
                                        $ts->clientPoke($admin, str_replace('[user]', "[url=client://0/".$client['client_unique_identifier']."]".substr($client['client_nickname'], 0, 10)."...[/url]", $lang['adminPoke']));
                                    }
                                }
                            } else {
                                $ts->clientKick($client['clid'], 'channel', $lang['disallowedUser']);
                                $ts->clientPoke($client['clid'], $lang['disallowedUser']);
                            }
                        } else {
                            $ts->clientKick($client['clid'], 'channel', $lang['inactiveMicrophone']);
                            $ts->clientPoke($client['clid'], $lang['inactiveMicrophone']);
                        }
                    }
                }
            }
        }
    }

}
