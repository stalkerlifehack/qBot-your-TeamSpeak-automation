<?php

/**********************************************

         Plik: removeOldChannels.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class removeOldChannels
{
    public function start($ts, $config)
    {
        $groupOnline = json_decode(file_get_contents("cache/groupOnline.json"), true);
        $clanGroup = json_decode(file_get_contents("cache/clanGroup.json"), true);
        $teleport = json_decode(file_get_contents("cache/teleport.json"), true);
        $adminStatusOnChannel = json_decode(file_get_contents("cache/adminStatusOnChannel.json"), true); //cldb => channelid






        if (is_array($groupOnline) && !empty($groupOnline)) {
            self::groupOnline($ts, $groupOnline);
        }
        if (is_array($clanGroup) && !empty($clanGroup)) {
            self::clanGroup($ts, $clanGroup);
        }
        if (is_array($teleport) && !empty($teleport)) {
            self::teleport($ts, $teleport);
        }
        if (is_array($adminStatusOnChannel) && !empty($adminStatusOnChannel)) {
            self::adminStatusOnChannel($ts, $adminStatusOnChannel);
        }
    }
    private static function groupOnline($ts, $groupOnline)
    {
        foreach (array_keys($groupOnline) as $channel) {
            if (!$ts->channelInfo($channel)['success']) {
                unset($groupOnline[$channel]);
            }
        }
        file_put_contents("cache/groupOnline.json", json_encode($groupOnline));
    }
    private static function clanGroup($ts, $clanGroup)
    {
        foreach (array_keys($clanGroup) as $channel) {
            if (!$ts->channelInfo($channel)['success']) {
                unset($clanGroup[$channel]);
            }
        }
        file_put_contents("cache/clanGroup.json", json_encode($clanGroup));
    }
    private static function teleport($ts, $teleport)
    {
        foreach (array_keys($teleport) as $channel) {
            if (!$ts->channelInfo($channel)['success']) {
                unset($teleport[$channel]);
            }
        }
        file_put_contents("cache/teleport.json", json_encode($teleport));
    }

    private static function adminStatusOnChannel($ts, $adminStatusOnChannel)
    {
        foreach ($adminStatusOnChannel as $channel) {
            if (!$ts->channelInfo($channel)['success']) {
                unset($teleport[$channel]);
            }
        }
        file_put_contents("cache/adminStatusOnChannel.json", json_encode($adminStatusOnChannel));
    }
}
