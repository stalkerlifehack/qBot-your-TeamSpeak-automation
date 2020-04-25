<?php

/**********************************************

         Plik: writeHelpProvided.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class writeHelpProvided
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents('cache/helpProvided.json'), true);

        if (is_array($config['adminGroups']) && !empty($config['adminGroups'])) {
            foreach ($config['adminGroups'] as $group) {
                foreach ($ts->serverGroupClientList($group)['data'] as $admin) {
                    if (array_key_exists('cldbid', $admin)) {
                        $admins[] = $admin['cldbid'];
                    }
                }
            }
        }



        foreach ($data as $cldbid => $value) {
            if (is_array($admins) && in_array($cldbid, $admins)) {
                $count[$cldbid] = [
                'all' => count($value),
                'monthly' => 0,
                'weekly' => 0,
                'daily' => 0
              ];

                foreach ($value as $date) {

                    if(date('Y', $date).date('z', $date) ==  date('Y').date('z')){
                      $count[$cldbid]['daily']++;
                    }
                    if(date('Y', $date).date('W', $date) ==  date('Y').date('W')){
                      $count[$cldbid]['weekly']++;
                    }
                    if(date('Y', $date).date('m', $date) ==  date('Y').date('m')){
                      $count[$cldbid]['monthly']++;
                    }

                }

                $simpleVars = ['[all]', '[monthly]', '[weekly]', '[daily]', '[nick]'];
                $vars = [$count[$cldbid]['all'], $count[$cldbid]['monthly'], $count[$cldbid]['weekly'], $count[$cldbid]['daily'], $ts->clientGetNameFromDbid($cldbid)['data']['name']];
                $config['topDesc'] .= str_replace($simpleVars, $vars, $config['desc']);
            }
        }
        $config['topDesc'] .= $config['footer'];
        $ts->channelEdit($config['channelId'], [
          'channel_description' => $config['topDesc']
        ]);
    }
}
