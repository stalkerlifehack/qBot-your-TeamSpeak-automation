<?php
/**********************************************

         File: index.php
              Author: Stalker
              TS: Jutuby.Net
          Telegram: @Stal_ker

***********************************************/

date_default_timezone_set('Europe/Warsaw');


require_once('lib/lib.php');
require_once('config/config.php');

if($config['errors']){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if ($config['logs']) {
    if(!is_dir('logs')){
      mkdir('logs', 0700);
    }
    ini_set('error_log', 'logs/error_'.date('Y-m-d').'log');
}


session_start();

$remove = json_decode(file_get_contents('cache/check.json'), true);

if (empty($remove) || $remove + 24*60*60 < time()) {
    foreach (scandir('cache') as $key => $file) {
        if ($key > 1 && time() - filemtime('cache/'.$file) > $config['removeCache']) {
            unlink('cache/'.$file);
            echo 2;
        }
    }

    file_put_contents('cache/check.json', json_encode(time()));
}



  # get info from server
    $data = json_decode(file_get_contents($config['dataUrl']), true);


    $clientNickName = $data['clients'][md5($_SERVER['REMOTE_ADDR'])];

      # create image
    $im = imagecreatefrompng($config['bannerBackground']);

    imagealphablending($im, true);

    $cfg = $config['settings'];

    # put time on banner
    if($config['settings'][0]['enabled']){
        centerAlignText(
            $im,
            $cfg[0]['size'],
            0,
            $cfg[0]['x'],
            $cfg[0]['y'],
            imagecolorallocate($im, $cfg[0]['color'][0], $cfg[0]['color'][1], $cfg[0]['color'][2]),
            $cfg[0]['font'],
            date('H:i')
        );
    }

    # put online clients on banner
    if($config['settings'][1]['enabled']){
        centerAlignText(
            $im,
            $cfg[1]['size'],
            0,
            $cfg[1]['x'],
            $cfg[1]['y'],
            imagecolorallocate($im, $cfg[1]['color'][0], $cfg[1]['color'][1], $cfg[1]['color'][2]),
            $cfg[1]['font'],
            $data['info']['online']
        );
    }

    # put online admins
    if($config['settings'][2]['enabled']){
        centerAlignText(
            $im,
            $cfg[2]['size'],
            0,
            $cfg[2]['x'],
            $cfg[2]['y'],
            imagecolorallocate($im, $cfg[2]['color'][0], $cfg[2]['color'][1], $cfg[2]['color'][2]),
            $cfg[2]['font'],
            $data['info']['admins']
        );
    }

      # put random text
      if($config['settings'][4]['enabled']){
        centerAlignText(
            $im,
            $cfg[4]['size'],
            0,
            $cfg[4]['x'],
            $cfg[4]['y'],
            imagecolorallocate($im, $cfg[4]['color'][0], $cfg[4]['color'][1], $cfg[4]['color'][2]),
            $cfg[4]['font'],
            $config['randomMessage'][rand(0, count($config['randomMessage'])-1)]
        );
    }

    # put text with nickname
    if($config['settings'][3]['enabled']){
        imagettftext(
            $im,
            $cfg[3]['size'],
            0,
            $cfg[3]['x'],
            $cfg[3]['y'],
            imagecolorallocate($im, $cfg[3]['color'][0], $cfg[3]['color'][1], $cfg[3]['color'][2]),
            $cfg[3]['font'],
            "$clientNickName"
        );
    }

    if (!empty($_SERVER['REMOTE_ADDR'])) {
        if (!file_exists('cache/'.md5($_SERVER['REMOTE_ADDR'])) || filemtime('cache/'.md5($_SERVER['REMOTE_ADDR'])) + $config['weatherInterval'] < time()) {

        # get data from IP
            $info = json_decode(file_get_contents('http://ip-api.com/json/'.$_SERVER['REMOTE_ADDR'].'?fields=status,city,lat,lon'), true);

            if ($info['status'] == 'success') {
                $weather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=".$info['lat']."&lon=".$info['lon']."&units=metric&lang=pl&appid=".$config['apiKey']), true);

                $info['city_name'] = $info['city'];

                file_put_contents('cache/'.md5($_SERVER['REMOTE_ADDR']), serialize(array_merge($info, $weather)));

                # put temperature
                if($config['settings'][5]['enabled']){
                    centerAlignText(
                        $im,
                        $cfg[5]['size'],
                        0,
                        $cfg[5]['x'],
                        $cfg[5]['y'],
                        imagecolorallocate($im, $cfg[5]['color'][0], $cfg[5]['color'][1], $cfg[5]['color'][2]),
                        $cfg[5]['font'],
                        round($weather['main']['temp']).'°C'
                    );
                }

                # put city
                if($config['settings'][6]['enabled']){
                    centerAlignText(
                        $im,
                        $cfg[6]['size'],
                        0,
                        $cfg[6]['x'],
                        $cfg[6]['y'],
                        imagecolorallocate($im, $cfg[6]['color'][0], $cfg[6]['color'][1], $cfg[6]['color'][2]),
                        $cfg[6]['font'],
                        $info['city']
                    );
                }
            }
        } else {
            $info = unserialize(file_get_contents('cache/'.md5($_SERVER['REMOTE_ADDR'])));

            # put temperature
            if($config['settings'][5]['enabled']){
                centerAlignText(
                    $im,
                    $cfg[5]['size'],
                    0,
                    $cfg[5]['x'],
                    $cfg[5]['y'],
                    imagecolorallocate($im, $cfg[5]['color'][0], $cfg[5]['color'][1], $cfg[5]['color'][2]),
                    $cfg[5]['font'],
                    round($info['main']['temp']).'°C'
                );
            }

            # put city
            if($config['settings'][6]['enabled']){
                centerAlignText(
                    $im,
                    $cfg[6]['size'],
                    0,
                    $cfg[6]['x'],
                    $cfg[6]['y'],
                    imagecolorallocate($im, $cfg[6]['color'][0], $cfg[6]['color'][1], $cfg[6]['color'][2]),
                    $cfg[6]['font'],
                    $info['city_name']
                );
            }
        }
    } else {
        # put temperature
        if($config['settings'][5]['enabled']){
            centerAlignText(
                $im,
                $cfg[5]['size'],
                0,
                $cfg[5]['x'],
                $cfg[5]['y'],
                imagecolorallocate($im, $cfg[5]['color'][0], $cfg[5]['color'][1], $cfg[5]['color'][2]),
                $cfg[5]['font'],
                "NaN".'°C'
            );
        }
    }

    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);
