<?php

/**********************************************

         Plik: checkTokens.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class checkTokens
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents('cache/timeToken.json'), true);

        if (!empty($data) && is_array($data)) {
            foreach ($data as $token => $value) {
                if ($value['time'] < time()) {
                    $ts->serverGroupDeleteClient($value['group'], $value['cldbid']);
                    unset($data[$token]);
                    file_put_contents('cache/timeToken.json', json_encode($data));
                }
            }
        }

        self::clearTokens($ts);
    }

    private static function clearTokens($ts)
    {
        $token = $ts->privilegekeyList()['data'];


        if (!empty($token)) {
            foreach ($token as $value) {
                $tokens[] = $value['token'];
            }
        }

        $data = json_decode(file_get_contents('cache/generatedTokens.json'), true);

        if (!empty($data)) {
            foreach (array_keys($data) as $token) {
                if (isset($tokens) && !in_array($token, $tokens)) {
                    unset($data[$token]);
                }
            }
        }
        file_put_contents('cache/generatedTokens.json', json_encode($data));
    }
}
