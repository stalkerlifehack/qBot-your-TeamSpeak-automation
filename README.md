# Requirements/Wymagania
 1. php 7.2
 2. php7.2-cli
 3. php7.2-curl
 4. screen
 5. apache2 (When banner is on the same vps/Dla baneru, ktory jest na tym samym vps)

# Packet installation/Instalacja pakietów
Jeżeli Twoja maszyna wirtualna posiada wgrany pakiet PHP7.2 >= pomiń krok pierwszy i drugi
1. Aktualizacja repozytoriów:
```sh
$ apt-get update && apt-get upgrade -y
```
2. Dodanie repo PHP
dla ubuntu
```sh
$ apt-get install python-software-properties
$ add-apt-repository ppa:ondrej/php
$ apt-get update
$ apt-get install php7.2
```
dla debian
```sh
$ apt -y install lsb-release apt-transport-https ca-certificates
$ wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
$ echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php7.2.list  //tutaj zamiast php7.2.list
$ można zastąpić inną wersją, minimalnie 7.2 (np. php7.4.list)
$ apt-get update
$ apt-get install php7.2
```
Instalacja wymaganych pakietów: (jeżeli zainstalowałeś wersję inną niż 7.2 zastąp pakiety PHPa swoją wersją, jeśli jej nie znasz wprowadź polecenie: php -v [zwraca ono wersję PHPa])
 ```sh
$ apt-get install php7.2-cli php7.2-curl
$ apt-get install screen
```

 
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





