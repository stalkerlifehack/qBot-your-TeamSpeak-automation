<?php

/**********************************************

         Plik: generateBannerData.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class generateBannerData
{
    public function start($ts, $config)
    {
        $data = [];
        $online = 0;
        $admins = 0;
        foreach ($ts->clientList('-groups -ip')['data'] as $client) {
            if ($client['client_type'] == 0) {
                $data['clients'][md5($client['connection_client_ip'])] = $client['client_nickname'];
                $online++;
            }
            if (array_intersect(explode(",", $client['client_servergroups']), $config['adminGroups'])) {
                $admins++;
            }
        }
        $data['info']['online'] = $online;
        $data['info']['admins'] = $admins;

        file_put_contents('cache/bannerData.json', json_encode($data));

        if($config['genearatePath']){
            if (!file_exists($config['path'])) {
                $code =
            '
            <?php
            $permittedIp = '.$config['permittedIp'].';
            if(!in_array($_SERVER["REMOTE_ADDR"], $permittedIp)){
                exit("Nie masz dostępu do tej strony!");
            }
            else{
                echo file_get_contents("'.realpath("cache/bannerData.json").'");
            }
            ?>
            ';
                file_put_contents($config['path'], $code);
            }
        }
    }
}
