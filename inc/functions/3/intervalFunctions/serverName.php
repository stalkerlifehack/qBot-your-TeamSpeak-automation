<?php

/**********************************************

         Plik: serverName.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class serverName
{
    public function start($ts, $config)
    {
        $server = $ts->serverInfo()['data'];
        $online = $server['virtualserver_clientsonline'] - $server['virtualserver_queryclientsonline'];
        $ts->serverEdit(array(
          'virtualserver_name' => str_replace(['[on]', '[max]', '[proc]'], [$online, $server['virtualserver_maxclients'], round($online/$server['virtualserver_maxclients']*100, 1)], $config['serverName'])
        ));
    }
}
