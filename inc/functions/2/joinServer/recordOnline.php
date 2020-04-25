<?php

/**********************************************

         Plik: recordOnline.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net
{"record":131,"time":1557316688}
***********************************************/

class recordOnline
{
    public function start($ts, $config, $client, $lang)
    {
        $server = $ts->serverInfo()['data'];
        $online = $server['virtualserver_clientsonline'] - $server['virtualserver_queryclientsonline'];

        $data = json_decode(file_get_contents('cache/recordOnline.json'), true);

        if ($data['best']['record'] < $online) {

            $data['best']['record'] = $online;
            $data['best']['time'] = time();


            if(!$config['moreRecords']['enabled']){
              $ts->channelEdit($config['channelId'], array(
                'channel_name' => str_replace('[rekord]', $online, $config['channelName']),
                'channel_description' => $config['topDesc'].str_replace(['[rekord]', '[date]'], [$data['best']['record'], qBot::convertDate($data['best']['time'], 0)], $config['desc']).$config['footer'],
              ));
            }
        }



        if($config['moreRecords']['enabled']){
          if(!empty($data['moreRecords']) && is_array($data['moreRecords'])){
            if(!empty($data['moreRecords'][date('Y').date('W')])){
              if($data['moreRecords'][date('Y').date('W')]['record'] < $online){

                $data['moreRecords'][date('Y').date('W')]['record'] = $online;
                $data['moreRecords'][date('Y').date('W')]['time'] = time();

                $desc = $config['topDesc'].str_replace(['[rekord]', '[date]'], [$data['best']['record'], qBot::convertDate($data['best']['time'], 0)], $config['desc']).$config['secondDesc'];
                krsort($data['moreRecords']);

                $i = 0;
                foreach($data['moreRecords'] as $week => $value){
                  if($i == $config['moreRecords']['numberOfRecords']){
                    break;
                  }
                  $desc .= str_replace(['[weekRecord]', '[weekTime]', '[dayName]'], [$value['record'], qBot::convertDate($value['time'], 0), qBot::weekName(date('w', $value['time']))], $config['thirdDesc']);

                  $i++;
                }
                $desc .= $config['footer'];

                $ts->channelEdit($config['channelId'], array('channel_description' => $desc));
              }
            }
            else{
              $data['moreRecords'][date('Y').date('W')]['record'] = $online;
              $data['moreRecords'][date('Y').date('W')]['time'] = time();
            }
          }
          else{
            $data['moreRecords'][date('Y').date('W')]['record'] = $online;
            $data['moreRecords'][date('Y').date('W')]['time'] = time();
          }

        }

        file_put_contents('cache/recordOnline.json', json_encode($data));

    }
}
