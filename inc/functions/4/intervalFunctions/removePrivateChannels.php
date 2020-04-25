<?php

/**********************************************

         Plik: removePrivateChannels.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class removePrivateChannels
{
    public function start($ts, $config)
    {
        $data = json_decode(file_get_contents("cache/getPrivateChannel.json"), true);
        foreach ($data as $index => $info) {

                # Po kolei id kanalu kazdego
            $channel = $ts->channelInfo($info['channelId'])['data'];

            # sprawdzamy czy kanal nie ma tematu urlop
            if (!empty($channel) && $channel['channel_topic'] != $config['holidayTopic']) {
                $topic = explode(".", $channel['channel_topic']);
                $time = mktime(0, 0, 0, $topic['1'], $topic['2'], $topic['0']);

                # Jeśli do usunięcia
                if (time()-$time > $config['removeDays']*24*3600) {
                    if ($ts->channelDelete($info['channelId'], 1)['success']) {
                        $remove[] = $index;
                    }
                }
            } elseif (time()-$time > $config['warnDays']*24*3600) { //jesli do warnu
                $ts->channelEdit($info['channelId'], array(
                  'channel_name' => str_replace('[num]', 1+$index, $config['toRemove'])
                ));
            }
        }

        if (@!empty($remove)) {
            unset($data);
            $data = json_decode(file_get_contents("cache/getPrivateChannel.json"), true);
            foreach ($remove as $index) {
                unset($data[$index]);
            }
            file_put_contents("cache/getPrivateChannel.json", json_encode(array_values($data)));

            unset($data);

            $data = json_decode(file_get_contents("cache/getPrivateChannel.json"), true);

            foreach ($data as $index => $value) {
                $name = explode(". ", $ts->channelInfo($value['channelId'])['data']['channel_name']);
                $ts->channelEdit($value['channelId'], array(
                  'channel_name' => str_replace(['[num]', '[name]'], [1+$index, $name[1]], $config['channelName'])
                ));
            }
        }
    }
}
