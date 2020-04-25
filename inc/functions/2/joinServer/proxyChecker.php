<?php

/**********************************************

         Plik: proxyChecker.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class proxyChecker
{
    public function start($ts, $config, $client, $lang)
    {
        $data = json_decode(file_get_contents("cache/proxyChecker.json"), true);

        if ($client['client_type'] == 0) {
            if (!array_intersect(explode(",", $client['client_servergroups']), $config['ignoredGroups']) && !in_array($client['connection_client_ip'], $config['ignoredIp'])) {
                if (!in_array($client['connection_client_ip'], $data['goodIp'])) {
                    if (!in_array($client['connection_client_ip'], $data['badIp'])) {

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,"http://v2.api.iphub.info/ip/".$client['connection_client_ip']);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Key: ".$config['apiKey']]);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $proxy = json_decode(curl_exec($ch), true);
                        curl_close ($ch);

                        if (!empty($proxy['block'])) {
                            if ($proxy['block'] == 0) {
                                $data['goodIp'][] = $client['connection_client_ip'];
                            } elseif ($proxy['block'] == 1) {
                                $data['badIp'][] = $client['connection_client_ip'];
                                $ts->clientPoke($client['clid'], $lang['message']);
                                $ts->clientKick($client['clid'], 'server', $lang['message']);
                            }
                        }
                    } else {
                        $ts->clientPoke($client['clid'], $lang['message']);
                        $ts->clientKick($client['clid'], 'server', $lang['message']);
                    }
                }
            }
        }
        file_put_contents("cache/proxyChecker.json", json_encode($data));
    }
}
