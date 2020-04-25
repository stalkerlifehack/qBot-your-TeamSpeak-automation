<?php

/**********************************************

              Plik: core.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/
system('clear');
require_once('inc/configs/config.php');
require_once('lang/language.php');


# Deklaracja stałych
date_default_timezone_set('Europe/Warsaw');
define("version", "4.1");
define("author", "Stalker");
define("name", "qBot");
define("telegram", "@Stal_ker");
define("ts", "Jutuby.net");
define("SP", " ");
define("PREF", "\e[92m[->]\e[0m");
define("ERR", "\e[91m[ERROR] \e[0m");
define("WARN", "\e[94m[WARN] \e[0m");
define("ENDC", "\e[0m");
define("GREEN", "\e[92m");
define("RED", "\e[91m");
define("ORAN", "\e[33m");
define("MAG", "\e[95m");
define("BLUE", "\e[34m");
define("DARKRED", "\e[38;5;88m");

echo DARKRED.
"                                   ____        _
                              __ _| __ )  ___ | |_
                             / _` |  _ \ / _ \| __|
                            | (_| | |_) | (_) | |_
                             \__, |____/ \___/ \__|
                                |_|
".ENDC.PHP_EOL;


echo
"                             ".$lang['core']['author'][$config['lang']].":  ".author."                      ".PHP_EOL;
echo
"                             ".$lang['core']['version'][$config['lang']].":  ".version."                        ".PHP_EOL;
echo
"                             Telegram:  ".telegram."                 ".PHP_EOL;
echo
"                             TS:  ".ts."                      ".PHP_EOL;

echo "\n";

# get instance number
$instance = getopt("i:");

# Ładowanie potrzebnych plików
echo PREF.$lang['core']['loadingFiles'][$config['lang']].PHP_EOL;
require_once('inc/classes/teamspeak.class.php');
require_once('inc/classes/qBot.class.php');

# Checking cache files
echo PREF.$lang['core']['checkCache'][$config['lang']].PHP_EOL;
$new = 0;
foreach(qBot::cacheFiles() as $file){
  if(!file_exists('cache/'.$file)){
    file_put_contents('cache/'.$file, '[]');
    $new++;
  }
}
if($new != 0){
  echo PREF.$lang['core']['newCache'][$config['lang']].PHP_EOL;
}

echo PREF.$lang['core']['instance'][$config['lang']].ORAN.$instance['i'].ENDC.PHP_EOL;

# Logi
if ($config['logs']) {
    ini_set('error_log', 'logs/error_'.date('Y-m-d').'_log_'.$instance['i'].'.log');
}
error_reporting($config['errors']);

# Sprawdzanie numeru instancji
if (empty($config[$instance['i']])) {
    exit(ERR.$lang['core']['notInstance'][$config['lang']].PHP_EOL);
}

# Połczenie z ts3
$ts = new teamspeak($config[$instance['i']]['conn']['ip'], $config[$instance['i']]['conn']['queryPort'], "\e[91m[ERROR] \e[0m");
if ($ts->connect()) {
    echo PREF.$lang['core']['connSucc'][$config['lang']].PHP_EOL;
    if ($ts->login($config[$instance['i']]['conn']['login'], $config[$instance['i']]['conn']['passwd'])['success']) {
        echo PREF.$lang['core']['querySucc'][$config['lang']].PHP_EOL;
        if ($ts->selectServer($config[$instance['i']]['conn']['voicePort'])['success']) {
            echo PREF.$lang['core']['selectSucc'][$config['lang']].PHP_EOL;
        } else {
            exit(ERR.$lang['core']['selectErr'][$config['lang']].PHP_EOL);
        }
        switch($config[$instance['i']]['conn']['prefix']){
          case 1:
            $botName = "qBot".$config[$instance['i']]['conn']['botName'];
            break;
    
          case 2:
            $botName = "(qBot)".$config[$instance['i']]['conn']['botName'];
            break;
    
          case 3:
            $botName = "q-Bot".$config[$instance['i']]['conn']['botName'];
            break;
    
          case 4:
            $botName = "(q-Bot)".$config[$instance['i']]['conn']['botName'];
            break;
    
          case 5:
            $botName = $config[$instance['i']]['conn']['botName']."(qBot)";
            break;
    
          case 6:
            $botName = $config[$instance['i']]['conn']['botName']."(q-Bot)";
            break;
    
          default:
            exit(ERR.$lang['core']['prefix'][$config['lang']].PHP_EOL);
        }
        if (strlen($botName) > 30) {
            exit(ERR.$lang['core']['tooLong'][$config['lang']].PHP_EOL);

        }
        if ($ts->setName($botName)) {
            echo PREF.$lang['core']['changeName'][$config['lang']].ORAN.$botName.ENDC.PHP_EOL;
        } else {
            echo WARN.$lang['core']['notName'][$config['lang']].PHP_EOL;
        }
        $cid = $ts->clientInfo($ts->whoAmI()['data']['client_id'])['data']['cid'];
        if ($cid != $config[$instance['i']]['conn']['channelId']) {
            if ($ts->clientMove($ts->whoAmI()['data']['client_id'], $config[$instance['i']]['conn']['channelId'])['success']) {
                echo PREF.$lang['core']['channelChanged'][$config['lang']].ORAN.$config[$instance['i']]['conn']['channelId'].ENDC.PHP_EOL;
            } else {
                echo WARN.$lang['core']['notChanged'][$config['lang']].PHP_EOL;
            }
        }
    } else {
        exit(ERR.$lang['core']['queryErr'][$config['lang']].PHP_EOL);
    }

    echo $lang['core']['preview'][$config['lang']].PHP_EOL;

    # include functions
    foreach($config[$instance['i']]['functions'] as $mode => $functions){
      foreach($functions as $function => $value){
        if(isset($value['enabled']) && $value['enabled']){
          $enabled[$mode][$function] = $value;
          require_once('inc/functions/'.$instance['i'].'/'.$mode."/".$function.".php");
          $$function = new $function();
        }
      }
    }

    # get socket
    $socket = $ts->runtime['socket'];

    switch($instance['i']){

      case 1:
        # When user change channel or admin send command or token used
        qBot::sendCommand($socket, 'servernotifyregister event=channel id=0');
        qBot::sendCommand($socket, 'servernotifyregister event=textprivate');
        qBot::sendCommand($socket, 'servernotifyregister event=textchannel');
        qBot::sendCommand($socket, 'servernotifyregister event=tokenused');

        # get ignored channels
        $ignoredChannels = qBot::ignoredChannels($config[1]['functions']['changeChannel']);

        # get client channels
        foreach($ts->clientList()['data'] as $client){
          if($client['client_type'] == 0){
            if(in_array($client['cid'], $ignoredChannels)){
              $ts->clientKick($client['clid'], 'channel');
              $channels[$client['clid']] = qBot::getDefaultChannelId($ts);
            }
            else{
              $channels[$client['clid']] = $client['cid'];
            }
          }
        }

        # loop
        while(1){

          # get data from socket
          $client = qBot::getData($socket);
          

          # if client tokenused
          if(array_key_exists('notifytokenused', $client) && isset($enabled['tokenUsed'])){
            if($client['cldbid'] != 1){
              foreach($enabled['tokenUsed'] as $function => $value){
                @$$function->start($ts, $value, $client, $lang[$function][$config['lang']]);
              }
            }
          }

          # if client join server
          if(array_key_exists('notifycliententerview', $client) && isset($enabled['joinServer'])){
            $channels[$client['clid']] = $client['ctid'];
            if($client['client_type'] == 0){
              foreach($enabled['joinServer'] as $function => $value){
                @$$function->start(
                  $ts, 
                  $value, 
                  array_merge($ts->clientInfo($client['clid'])['data'], ['clid' => $client['ctid'], 'clid' => $client['clid']]), 
                  $lang[$function][$config['lang']]
                );
              }
            }
          }

          # if client change channel
          if(array_key_exists('notifyclientmoved', $client) && isset($enabled['changeChannel'])){

            $control = 1;
            foreach($enabled['changeChannel'] as $function => $value){
              @$channel = $$function->start(
                $ts, 
                array_merge($ts->clientInfo($client['clid'])['data'], 
                ['clid' => $client['ctid'], 'clid' => $client['clid'], 'invokerid' => $client['invokerid']]), 
                 $value, 
                 $channels[$client['clid']], 
                 $lang[$function][$config['lang']]
              );
                                          
              if (!empty($channel)) {
                  $channels[$client['clid']] = $channel;
                  $control = 0;
              }
            }
            if ($control) {
                $channels[$client['clid']] = $client['ctid'];
            }
          }

          # if admin send a message
          if(array_key_exists('notifytextmessage', $client) && isset($enabled['commands'])){
            foreach($enabled['commands'] as $function => $value){
              @$channel = $$function->start($ts, $value, $client, $lang[$function][$config['lang']]);
              if (is_array($channel)) {
                  $channels = array_replace($channels, $channel);
              }
            }
          }

          # if client left server
          if(array_key_exists('notifyclientleftview', $client)){
            unset($channels[$client['clid']]);
          }

          $ts->version($socket);
          
        }

      case 2:
        # when user join/left server or send message
        qBot::sendCommand($socket, 'servernotifyregister event=channel id=0');
        qBot::sendCommand($socket, 'servernotifyregister event=textprivate');
        qBot::sendCommand($socket, 'servernotifyregister event=textchannel');

        $cldbid = [];

        # save database id
        foreach($ts->clientList()['data'] as $client){
          if($client['client_type'] == 0){
            $cldbid[$client['clid']] = $client['client_database_id'];
          }
        }

        while(1){

          # get data from socket
          $client = qBot::getData($socket);
          

          # if client join
          if(array_key_exists('notifycliententerview', $client) && isset($enabled['joinServer'])){

            if($client['client_type'] == 0){
              foreach($enabled['joinServer'] as $function => $value){
                $clientInfo = $ts->clientInfo($client['clid']);
                if($clientInfo['success']){
                  @$$function->start(
                   $ts, 
                   $value, 
                   array_merge($clientInfo['data'], ['clid' => $client['ctid'], 'clid' => $client['clid']]), 
                   $lang[$function][$config['lang']]
                  );
                }
              }
              $cldbid[$client['clid']] = $client['client_database_id'];
            }
          }

          # if channel edited
          if(array_key_exists('notifychanneledited', $client) && isset($enabled['channelEdit'])){
            if(!empty($cldbid[$client['invokerid']])){
              $clientInfo = $ts->clientInfo($client['invokerid'])['data'];
              $clientInfo['clid'] = $client['invokerid'];
              foreach($enabled['channelEdit'] as $function => $value){
                @$$function->start($ts, $value, $clientInfo, $client['cid'], $lang[$function][$config['lang']]);
              }
            }
          }

          # if client leave
          if(array_key_exists('notifyclientleftview', $client)){
            if(!empty($cldbid[$client['clid']])){
              if(!array_key_exists('invokerid', $client) && isset($enabled['leftServer'])){
                foreach($enabled['leftServer'] as $function => $value){
                  @$$function->start($ts, $cldbid[$client['clid']], $value, $lang[$function][$config['lang']]);
                }

              }
              else{

                # if client kicked from server
                if($client['reasonid'] == 5 && isset($enabled['kickFromServer'])){
                  if(array_key_exists('kickFromServer', $enabled)){
                    foreach($enabled['kickFromServer'] as $function => $value){
                      @$$function->start($ts, $value, $client, $lang[$function][$config['lang']]);
                    }
                  }
                }

                # if client banned from server
                elseif($client['reasonid'] == 6 && isset($enabled['banClient'])){
                  if(array_key_exists('banClient', $enabled)){
                    foreach($enabled['banClient'] as $function => $value){
                      @$$function->start($ts, $value, $client, $lang[$function][$config['lang']]);
                    }
                  }
                }
              }
            }
            unset($cldbid[$client['clid']]);

          }

          $ts->version($socket);

          
        }

      case 3:
        while(1){

          

          if(isset($enabled['intervalFunctions'])){
            foreach($enabled['intervalFunctions'] as $function => $value){
              if(empty($interval{$function}) || $interval{$function} < time()){
                @$$function->start($ts, $value, $lang[$function][$config['lang']]);
                $interval{$function} = $value['interval'] + time();
                echo BLUE."    - ".$function.ENDC.PHP_EOL;
              }
            }
          }

          if(isset($enabled['fastFunctions'])){
            foreach($enabled['fastFunctions'] as $function => $value){
              @$$function->start($ts, $value, $lang[$function][$config['lang']]);
            }
          }

          
          usleep($config[3]['conn']['delay']);
        }

      case 4:
        while(1){

          

          if(isset($enabled['intervalFunctions'])){
            foreach($enabled['intervalFunctions'] as $function => $value){
              if(empty($interval{$function}) || $interval{$function} < time()){
                @$$function->start($ts, $value, $lang[$function][$config['lang']]);
                $interval{$function} = $value['interval'] + time();
                echo BLUE."    - ".$function.ENDC.PHP_EOL;
              }
            }
          }

          if(isset($enabled['fastFunctions'])){
            foreach($enabled['fastFunctions'] as $function => $value){
              @$$function->start($ts, $value, $lang[$function][$config['lang']]);
            }
          }

          
          usleep($config[4]['conn']['delay']);
        }

      case 5:

        # when user send message and join
        qBot::sendCommand($socket, 'servernotifyregister event=textprivate');
        qBot::sendCommand($socket, 'servernotifyregister event=channel id=0');

        while(1){

          # get data from socket
          $client = qBot::getData($socket);
          

          # if admin send a message
          if(array_key_exists('notifytextmessage', $client) && isset($enabled['commands'])){
            foreach($enabled['commands'] as $function => $value){
              @$channel = $$function->start($ts, $value, $client, $lang[$function][$config['lang']]);
              if (is_array($channel)) {
                  $channels = array_replace($channels, $channel);
              }
            }
          }

          # if client join
          if(array_key_exists('notifycliententerview', $client) && isset($enabled['joinServer'])){
            if($client['client_type'] == 0){
              foreach($enabled['joinServer'] as $function => $value){
                @$$function->start(
                  $ts, 
                  $value, 
                  array_merge($ts->clientInfo($client['clid'])['data'], ['clid' => $client['ctid'], 'clid' => $client['clid']]),
                  $lang[$function][$config['lang']]
                );
              }
            }
          }

          $ts->version($socket);

          
        }
    }



} else {
    echo ERR.$lang['core']['connectErr'][$config['lang']].PHP_EOL;
}
