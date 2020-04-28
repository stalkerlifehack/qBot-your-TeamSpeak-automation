# Requirements/Wymagania
 1. php 7.2
 2. php7.2-cli
 3. php7.2-curl
 4. screen
 5. apache2 (When banner is on the same vps/Dla baneru, ktory jest na tym samym vps)
 
# Installation/Instalacja
```sh
$ cd /home
$ wget https://github.com/stalkerlifehack/qBot-your-TeamSpeak-automation/archive/master.zip
$ unzip master.zip
$ mv qBot-your-TeamSpeak-automation-master qBot_v4.1
$ cd qBot_v4.1
$ chmod 0775 run 
$ cd inc/configs
```
For english config file:
```sh
$ cp config.php.SAMPLE_EN config.php
```
Dla polskiego pliku konfiguracyjnego:
```sh
$ cp config.php.SAMPLE_PL config.php
```
For banner on the same vps/Dla baneru na tym samym vps
```sh
$ cd /home/qBot
$ mv banner /var/www/html/banner
```


# Commands/Komendy
```sh
$ ./run start
$ ./run stop
$ ./run restart 
$ ./run daemon
```

# Help/Pomoc
Telegram: https://telegram.me/Stal_ker (@Stal_ker)
Forum: https://egcforum.pl/ (Stalker)
