<?php
/**********************************************

         Plik: monthAdminGroup.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class monthAdminGroup
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/helpProvided.json"), true);

        foreach ($data as $cldbid => $value) {
            $count['weekly'][$cldbid] = 0;
            $count['monthly'][$cldbid] = 0;

            foreach ($value as $time) {
                if (date('Y', $time).date('W', $time) ==  date('Y', strtotime('-1 week')).date('W', strtotime('-1 week'))) {
                    $count['weekly'][$cldbid]++;
                }
                if (date('Y', $time).date('m', $time) ==  date('Y', strtotime('-1 month')).date('m', strtotime('-1 month'))) {
                    $count['monthly'][$cldbid]++;
                }
            }
        }

        if (max($count['weekly']) != 0) {
            if (array_count_values($count['weekly'])[max($count['weekly'])] > 1) {
                foreach ($count['weekly'] as $cldbid => $value) {
                    if (max($count['weekly']) == $value) {
                        $top[$cldbid] = $count['monthly'][$cldbid];
                    }
                }
                foreach ($top as $cldbid => $value) {
                    if (max($top) == $value) {
                        $ts->serverGroupAddClient($config['monthAdminGroup'], $cldbid);
                        $ignored[] = $cldbid;
                    }
                }
                if (!empty($ignored)) {
                    foreach ($ts->serverGroupClientList($config['monthAdminGroup'])['data'] as $client) {
                        if (!in_array($client['cldbid'], $ignored)) {
                            $ts->serverGroupDeleteClient($config['monthAdminGroup'], $client['cldbid']);
                        }
                    }
                }
            } else {
                foreach ($count['weekly'] as $cldbid => $value) {
                    if (max($count['weekly']) == $value) {
                        $ts->serverGroupAddClient($config['monthAdminGroup'], $cldbid);
                        foreach ($ts->serverGroupClientList($config['monthAdminGroup'])['data'] as $client) {
                            if ($client['cldbid'] != $cldbid) {
                                $ts->serverGroupDeleteClient($config['monthAdminGroup'], $client['cldbid']);
                            }
                        }
                        break;
                    }
                }
            }
        }
    }
}
