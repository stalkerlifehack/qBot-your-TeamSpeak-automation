<?php

/**********************************************

         Plik: removeNewUsersToday.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class removeNewUsersToday
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/newUsersToday.json"), true);

        foreach ($data as $id => $value) {
            if ($value['date'] != date('Y-m-d')) {
                unset($data[$id]);
            }
        }
        file_put_contents("cache/newUsersToday.json", json_encode($data));
    }
}
