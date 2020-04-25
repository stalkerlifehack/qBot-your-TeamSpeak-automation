<?php

/**********************************************

         Plik: saveLastClientTime.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class saveLastClientTime
{
    public function start($ts, $cldbid, $config)
    {
        $data = json_decode(file_get_contents("cache/saveLastClientTime.json"), true);
        var_dump($cldbid);

        $data[$cldbid] = date('Y-m-d H:i');

        file_put_contents("cache/saveLastClientTime.json", json_encode($data));

    }
}
