<?php

/**********************************************

         Plik: dataCopy.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class dataCopy
{
    public function start($ts, $config)
    {
        if (file_exists($config['path'])) {
            foreach (scandir($config['path']) as $key => $value) {
                if (is_numeric($value) && time() - $value > $config['maxDays'] * 3600 * 24) {
                    shell_exec('rm -rf '.$config['path']."/".$value);
                }
                if (is_numeric($value) && time() - $value < 3600 * 24) {
                    $if = false;
                } else {
                    $if = true;
                }
            }
            if ($if) {
                shell_exec('cp -r cache '.$config['path']."/".time());
            }
        } else {
            shell_exec('mkdir -p '.$config['path']);
        }
    }
}
