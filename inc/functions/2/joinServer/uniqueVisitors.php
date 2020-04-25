<?php

/**********************************************

         Plik: uniqueVisitors.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class uniqueVisitors
{
    public function start($ts, $config, $client)
    {
        $visitors = $ts->clientDbList(0, -1, true)['data'][0]['count'];
        $ts->channelEdit($config['channelId'], array(
           'channel_name' => str_replace('[visits]', $visitors, $config['channelName'])
        ));
    }
}
