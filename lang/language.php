<?php

/**********************************************

         Plik: language.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

$lang = [

     /*
          Core
     */
     'core' => [
          'author' => [
               'PL' => 'Autor',
               'EN' => 'Author',
          ],
          'version' => [
               'PL' => 'Wersja',
               'EN' => 'Version'
          ],
          'loadingFiles' => [
               'PL' => 'Ładowanie potrzebnych plików...',
               'EN' => 'Loading necessary files...',
          ],
          'checkCache' => [
               'PL' => "Sprawdzanie plików cache...",
               'EN' => "Checking cache files...",
          ],
          'newCache' => [
               'PL' => "Utworzono brakujące pliki cache!",
               'EN' => "Cache files created!",
          ],
          'instance' => [
               'PL' => "Wybrano instancje numer:",
               'EN' => "You choose instance number:",
          ],
          'notInstance' => [
               'PL' => "Podana instancja nie istnieje!",
               'EN' => "There instance doesnt exists!",
          ],
          'connSucc' => [
               'PL' => "Pomyślnie połączono z serwerem!",
               'EN' => "Successfully connected to server!",
          ],
          'querySucc' => [
               'PL' => "Pomyślnie zalogowano na query!",
               'EN' => "Successfully logged to query!",
          ],
          'selectSucc' => [
               'PL' => "Pomyślnie wybrano serwer!",
               'EN' => "Successfully selected server!",
          ],
          'selectErr' => [
               'PL' => "Bot nie mógł wybrać serwera!",
               'EN' => "Bot couldnt select server!",
          ],
          'prefix' => [
               'PL' => "Musisz wybrać prefix bota!",
               'EN' => "You have to select bot prefix",
          ],
          'tooLong' => [
               'PL' => "Nazwa bota jest za długa!",
               'EN' => "The bot name i too long!",
          ],
          'changeName' => [
               'PL' => "Bot zmienił nazwę na ",
               'EN' => "Bot changed his name to ",
          ],
          'notName' => [
               'PL' => "Bot nie mógł zmienić nazwy!",
               'EN' => "Bot couldnt change his name!",
          ],
          'channelChanged' => [
               'PL' => "Bot zmienił kanał na ",
               'EN' => "Bot changed channel to ",
          ],
          'notChanged' => [
               'PL' => "Bot nie mógł zmienić kanału!",
               'EN' => "Bot couldnt change the channel!",
          ],
          'queryErr' => [
               'PL' => "Bot nie mógł się zalogować na query!",
               'EN' => "Bot couldnt login to query!",
          ],
          'preview' => [
               'PL' => "Podgląd:",
               'EN' => "Preview:",
          ],
          'connectErr' => [
               'PL' => "Bot nie mógł się połączyć z serwerem!",
               'EN' => "Bot couldnt connect to server!",
          ],
          'loop' => [
               'PL' => "    Pętla wykonała sie w ",
               'EN' => "    Loop executed in ",
          ],

     ],


     /*
          classes
     */
     'weekName' => [
          'PL' => [
               1 => 'Poniedziałek',
               2 => 'Wtorek',
               3 => 'Środa',
               4 => 'Czwartek',
               5 => 'Piatek',
               6 => 'Sobota',
               0 => 'Niedziela',
          ],

          'EN' => [
               1 => 'Monday',
               2 => 'Tuesday',
               3 => 'Wednesday',
               4 => 'Thursday',
               5 => 'Friday',
               6 => 'Saturday',
               0 => 'Sunday',
          ],
     ],

     'monthName' => [
          'PL' => [
               1 => 'Stycznia',
               2 => 'Lutego',
               3 => 'Marca',
               4 => 'Kwietnia',
               5 => 'Maja',
               6 => 'Czerwca',
               7 => 'Lipca',
               8 => 'Sierpnia',
               9 => 'Września',
               10 => 'Pażdziernika',
               11 => 'Listopada',
               12 => 'Grudnia'
          ],

          'EN' => [
               1 => 'January',
               2 => 'February',
               3 => 'March',
               4 => 'April',
               5 => 'May',
               6 => 'June',
               7 => 'July',
               8 => 'August',
               9 => 'September',
               10 => 'October',
               11 => 'November',
               12 => 'December'
          ],
     ],

     'convertSecondsSecond' => [
          'PL' => [
               0 => 'mniej niż minuta',
               1 => ' godzina',
               2 => ' godziny',
               3 => ' godzin',
               4 => ' minuta',
               5 => ' minuty',
               6 => ' minut',
          ],
          'EN' => [
               0 => 'less than minute',
               1 => ' hour',
               2 => ' hours',
               3 => ' hours',
               4 => ' minute',
               5 => ' minutes',
               6 => ' minutes',
          ],
     ],

     'convertThirdSecond' => [
          'PL' => [
               0 => 'mniej niż minutę',
               1 => ' godzinę',
               2 => ' godziny',
               3 => ' godzin',
               4 => ' minutę',
               5 => ' minuty',
               6 => ' minut',
               7 => ' dzień',
               8 => ' dni',
               9 => ' godzinę',
               10 => ' godziny',
               11 => 'godzin'
          ],
          'EN' => [
               0 => 'less than minute',
               1 => ' hour',
               2 => ' hours',
               3 => ' hour',
               4 => ' minute',
               5 => ' minutes',
               6 => ' minute',
               7 => ' day',
               8 => ' days',
               9 => ' hour',
               10 => ' hours',
               11 => 'hour'
          ],
     ],




     /*
          Functions
     */
     'channelGroupNotify' => [
          'PL' => [
               'pokeMessage' => 'Użytkownik [user] oczekuje Twojej pomocy!',
          ],
          'EN' => [
               'pokeMessage' => 'User [user] is waiting for Your help!',
          ]
     ],
     'clanGroup' => [
          'PL' => [
               'addPokeMessage' => 'Ranga została nadana pomyślnie!',
               'removePokeMessage' => 'Ranga została odebrana pomyślnie!',
          ],
          'EN' => [
               'addPokeMessage' => 'Rank was added successfully!',
               'removePokeMessage' => 'Rank was removed successfully!',
          ]
     ],
     'getPrivateChannel' => [
          'PL' => [
               'alreadyOwner' => 'Nasz system wykrył, że posiadasz już u nas kanał!',
          ],
          'EN' => [
               'alreadyOwner' => 'Our system detected that you already have channel!',
          ]
     ],
     'moveWhenJoinChannel' => [
          'PL' => [
               'successfullyMoved' => 'Zostałeś pomyślnie przeniesiony na kanał! Odnajdź się -> [user]',
               'failureMoved' => 'Nie możesz korzystać z kanału do przenoszenia!'
          ],
          'EN' => [
               'successfullyMoved' => 'You were successfully moved to channel! Find yourself -> [user]',
               'failureMoved' => 'You cannot use channel to move!'
          ]
     ],
     'registerChannel' => [
          'PL' => [
               'successfullyAdded' => 'Zostałeś/aś poprawnie zarejestrowany/a!',
               'tooShortOnServer' => 'Jesteś zbyt krótko na serwerze!',
               'alreadyRegistered' => 'Posiadasz już grupę rejestracyjną!'
          ],
          'EN' => [
               'successfullyAdded' => 'You were successfully registered!',
               'tooShortOnServer' => 'You have not enough time on server!',
               'alreadyRegistered' => 'You are already registered!'
          ]
     ],
     'addToken' => [
          'PL' => [
               'tokenMessage' => 'Token to: [b][token][/b]',
               'disallowedGroup' => 'Nie możesz utworzyć klucza dla tej grupy!',
               'usage' => 'Użycie: [b]!addToken <group> <time_in_seconds>[/b]',
               'badCommand' => 'Niepoprawne użycie - użyj: !addToken help',
               'noPermits' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!'
          ],
          'EN' => [
               'tokenMessage' => 'Token is: [b][token][/b]',
               'disallowedGroup' => 'You cannot create key for this group!',
               'usage' => 'Usage: [b]!addToken <group> <time_in_seconds>[/b]',
               'badCommand' => 'Incorrect usage - use: !addToken help',
               'notAuthorized' => 'You are not authorized to use this command!'
          ]
     ],
     'clanGroupComm' => [
          'PL' => [
               'addedEntry' => 'Dodano wpis!',
               'existingEntry' => 'Już jest taki wpis!',
               'removedEntry' => 'Usunięto wpis!',
               'notExistingEntry' => 'Nie ma takiego wpisu!',
               'listOfEntries' => 'Lista wpisów:',
               'entryInfo' => '   ID kanału: [b][channel] [/b]przypisany do grupy: [b][group] [/b]',
               'availableCommands' => 'Dostępne komendy to:',
               'command1' => '[b]!clanGroup add <channelId> <groupId>[/b]            |    [i](Dodajemy wpis)[/i]',
               'command2' => '[b]!clanGroup remove <channelId> <groupId>[/b]     |    [i](Usuwamy wpis)[/i]',
               'command3' => '[b]!clanGroup list [/b]                                                        |    [i](Lista wszystkich wpisów)[/i]',
               'command4' => '[b]!clanGroup help [/b]                                                      |    [i](Info o dostępnych komendach)[/i]',
               'usage' => 'Użyj: !clanGroup help',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'addedEntry' => 'Added entry!',
               'existingEntry' => 'This entry is already existing!',
               'removedEntry' => 'Removed entry!',
               'notExistingEntry' => 'Incorrect entry!',
               'listOfEntries' => 'List of entries:',
               'entryInfo' => '   Channel ID: [b][channel] [/b]assigned to group: [b][group] [/b]',
               'availableCommands' => 'Available commands:',
               'command1' => '[b]!clanGroup add <channelId> <groupId>[/b]            |    [i](Adding entry)[/i]',
               'command2' => '[b]!clanGroup remove <channelId> <groupId>[/b]     |    [i](Removing entry)[/i]',
               'command3' => '[b]!clanGroup list [/b]                                                        |    [i](List of all entries)[/i]',
               'command4' => '[b]!clanGroup help [/b]                                                      |    [i](Info about all commands)[/i]',
               'usage' => 'Use: !clanGroup help',
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],

     'adminStatusOnChannelComm' => [
          'PL' => [
               'addedEntry' => 'Dodano wpis!',
               'existingEntry' => 'Już jest taki wpis!',
               'removedEntry' => 'Usunięto wpis!',
               'notExistingEntry' => 'Nie ma takiego wpisu!',
               'listOfEntries' => 'Lista wpisów:',
               'entryInfo' => '   ID kanału: [b][channel] [/b]przypisany do grupy: [b][group] [/b]',
               'availableCommands' => 'Dostępne komendy to:',
               'command1' => '[b]!adminStatusOnChannel add <channelId> <groupId>[/b]            |    [i](Dodajemy wpis)[/i]',
               'command2' => '[b]!adminStatusOnChannel remove <channelId> <groupId>[/b]     |    [i](Usuwamy wpis)[/i]',
               'command3' => '[b]!adminStatusOnChannel list [/b]                                                        |    [i](Lista wszystkich wpisów)[/i]',
               'command4' => '[b]!adminStatusOnChannel help [/b]                                                      |    [i](Info o dostępnych komendach)[/i]',
               'usage' => 'Użyj: !adminStatusOnChannel help',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'addedEntry' => 'Added entry!',
               'existingEntry' => 'This entry is already existing!',
               'removedEntry' => 'Removed entry!',
               'notExistingEntry' => 'Incorrect entry!',
               'listOfEntries' => 'List of entries:',
               'entryInfo' => '   Channel ID: [b][channel] [/b]assigned to group: [b][group] [/b]',
               'availableCommands' => 'Available commands:',
               'command1' => '[b]!adminStatusOnChannel add <channelId> <groupId>[/b]            |    [i](Adding entry)[/i]',
               'command2' => '[b]!adminStatusOnChannel remove <channelId> <groupId>[/b]     |    [i](Removing entry)[/i]',
               'command3' => '[b]!adminStatusOnChannel list [/b]                                                        |    [i](List of all entries)[/i]',
               'command4' => '[b]!adminStatusOnChannel help [/b]                                                      |    [i](Info about all commands)[/i]',
               'usage' => 'Use: !adminStatusOnChannel help',
               'notAuthorized' => 'You are not authorized to use this command!',
          ],
     ],
     'clear' => [
          'PL' => [
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],
     'groupOnlineComm' => [
          'PL' => [
               'addedEntry' => 'Dodano wpis!',
               'existingEntry' => 'Już jest taki wpis!',
               'removedEntry' => 'Usunięto wpis!',
               'notExistingEntry' => 'Nie ma takiego wpisu!',
               'listOfEntries' => 'Lista wpisów:',
               'entryInfo' => '   ID kanału: [b][channel] [/b]przypisany do grupy: [b][group] [/b]',
               'availableCommands' => 'Dostępne komendy to:',
               'command1' => '[b]!groupOnline add <channelId> <groupId> <channelPattern>[/b]            |    [i](Dodajemy wpis) np. [b]!groupOnline add 12 87 "[cspacer001]Online: [on]/[all]"[/i]',
               'command2' => '[b]!groupOnline remove <channelId> <groupId>[/b]                                       |    [i](Usuwamy wpis)[/i]',
               'command3' => '[b]!groupOnline list [/b]                                                                                         |    [i](Lista wszystkich wpisów)[/i]',
               'command4' => '[b]!groupOnline help [/b]                                                                                       |    [i](Info o dostępnych komendach)[/i]',
               'usage' => 'Użyj: !groupOnline help',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'addedEntry' => 'Added entry!',
               'existingEntry' => 'This entry is already existing!',
               'removedEntry' => 'Removed entry!',
               'notExistingEntry' => 'Incorrect entry!',
               'listOfEntries' => 'List of entries:',
               'entryInfo' => '   Channel ID: [b][channel] [/b]assigned to group: [b][group] [/b]',
               'availableCommands' => 'Available commands:',
               'command1' => '[b]!groupOnline add <channelId> <groupId> <channelPattern>[/b]            |    [i](Adding entry) e.g. [b]!groupOnline add 12 87 "[cspacer001]Online: [on]/[all]"[/i]',
               'command2' => '[b]!groupOnline remove <channelId> <groupId>[/b]                                       |    [i](Removing entry)[/i]',
               'command3' => '[b]!groupOnline list [/b]                                                                                         |    [i](List of all entries)[/i]',
               'command4' => '[b]!groupOnline help [/b]                                                                                       |    [i](Info about all commands)[/i]',
               'usage' => 'Use: !groupOnline help',
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],
     'meeting' => [
          'PL' => [
               'moved' => 'Zostałeś/aś przeniesiony/a na zebranie!',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'moved' => 'You were moved for meeting!',
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],
     'pokeAll' => [
          'PL' => [
               'pokedCount' => 'Zaczepiono [count] klientów!',
               'tooLongMessage' => 'Twoja wiadomość nie może być dłuższa niż 100 znaków!',
               'usage' => 'Użyj: !pokeAll "Twoja wiadomość"',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'pokedCount' => 'Poked [count] clients!',
               'tooLongMessage' => 'Your message cannot be longer than 100 signs!',
               'usage' => 'Use: !pokeAll "Your message"',
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],
     'pwAll' => [
          'PL' => [
               'messagedCount' => 'Wysłano [count] wiadomości!',
               'tooLongMessage' => 'Twoja wiadomość nie może być dłuższa niż 1024 znaków!',
               'usage' => 'Użyj: !pwAll "Twoja wiadomość"',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'pokedCount' => 'Sent to [count] clients!',
               'tooLongMessage' => 'Your message cannot be longer than 1024 signs!',
               'usage' => 'Use: !pwAll "Your message"',
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],
     'serverGroupProtectionComm' => [
          'PL' => [
               'addedEntry' => 'Dodano wpis!',
               'existingEntry' => 'Już jest taki wpis!',
               'removedEntry' => 'Usunięto wpis!',
               'notExistingEntry' => 'Nie ma takiego wpisu!',
               'listOfEntries' => 'Lista wpisów:',
               'entryInfo' => '   DatabaseId: [b][cldbid] [/b]  Grupy: [b][groups][/b] [i]([client_name])[/i]',
               'availableCommands' => 'Dostępne komendy to:',
               'command1' => '   [b]!serverGroupProtection add <databaseId> <groups>[/b]         | [i](Dodajemy wpis)',
               'command2' => '   [b]!serverGroupProtection remove <databaseId> <groups>[/b]  | [i](Usuwamy wpis)',
               'command3' => '   [b]!serverGroupProtection list[/b]                                                       | [i](Lista wpisów)',
               'command4' => '   [b]!serverGroupProtection help[/b]                                                     | [i](Dostępne komendy)',
               'example1' => '   [b]Przykład: !serverGroupProtection add 3 5,6,88',
               'example2' => '   [b]Przykład: !serverGroupProtection add 3 5',
               'usage' => 'Użyj: !serverGroupProtection help',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'addedEntry' => 'Added entry!',
               'existingEntry' => 'This entry is already existing!',
               'removedEntry' => 'Removed entry!',
               'notExistingEntry' => 'Incorrect entry!',
               'listOfEntries' => 'List of entries:',
               'entryInfo' => '   DatabaseId: [b][cldbid] [/b]  Groups: [b][groups][/b] [i]([client_name])[/i]',
               'availableCommands' => 'Available commands:',
               'command1' => '   [b]!serverGroupProtection add <databaseId> <groups>[/b]         | [i](Adding entry)',
               'command2' => '   [b]!serverGroupProtection remove <databaseId> <groups>[/b]  | [i](Removing entry)',
               'command3' => '   [b]!serverGroupProtection list[/b]                                                       | [i](List of entries)',
               'command4' => '   [b]!serverGroupProtection help[/b]                                                     | [i](Info about all commandy)',
               'example1' => '   [b]Example: !serverGroupProtection add 3 5,6,88',
               'example2' => '   [b]Example: !serverGroupProtection add 3 5',
               'usage' => 'Use: !serverGroupProtection help',
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],
     'teleport' => [
          'PL' => [
               'usage' => 'Użyj: !warp <numer_warpu>',
               'noWarps' => 'Brak warpów!',
               'moved' => 'Zostałeś przeniesiony na warp: [b][group_name][/b] Odnajdź się -> [user]',
               'notExistingWarp' => 'Podany warp nie istnieje!',
               'usageList' => 'Użyj: !warp list',
               'notAuthorized' => 'Nie jesteś uprawniony/a do korzystania z tej komendy!',
          ],
          'EN' => [
               'usage' => 'Use: !warp <warp_number>',
               'noWarps' => 'No warps!',
               'moved' => 'You were moved to warp: [b][group_name][/b] Find yourself -> [user]',
               'notExistingWarp' => 'Given warp does not exist!',
               'usageList' => 'Use: !warp list',
               'notAuthorized' => 'You are not authorized to use this command!',
          ]
     ],
     'banGuard' => [
          'PL' => [
               'pokeMessage' => 'Zablokowałeś zbyt dużo osób. Ranga została Ci odebrana!',
          ],
          'EN' => [
               'pokeMessage' => 'You have banned too much clients. Your rank was removed off you!',
          ]
     ],
     'descriptionGuard' => [
          'PL' => [
               'pokeMessage' => 'Nie możesz edytować opisu kanału głównego!',
          ],
          'EN' => [
               'pokeMessage' => 'You cannot edit main channel description!',
          ]
     ],
     'checkConnections' => [
          'PL' => [
               'kickMessage' => 'Możesz być połączyony maksymalnie [max_connections] razy z serwerem!',
          ],
          'EN' => [
               'kickMessage' => 'You can be connected to the server up to 3 times!',
          ]
     ],
     'notifyWhenJoin' => [
          'PL' => [
               'pokeMessage' => '[user] jest połączony z serwerem!',
          ],
          'EN' => [
               'PokeMessage' => '[user] is connected to the server!',
          ]
     ],
     'proxyChecker' => [
          'PL' => [
               'message' => 'Na serwerze obowiązuje zakaz używania programów do maskowania IP!',
          ],
          'EN' => [
               'message' => 'It is not allowed to use IP masking programs on the server!',
          ]
     ],
     'nickNameChecker' => [
          'PL' => [
               'pokeMessage' => 'Twój nick zawiera niedozwoloną frazę "[b][phrase][/b]"',
               'kickMessage' => 'Twój nick jest niezgodny z regulaminem!'
          ],
          'EN' => [
               'pokeMessage' => 'Your nick has forbidden phrase "[b][phrase][/b]"',
               'kickMessage' => 'Your nick is incompatible with the rules!'
          ]
     ],
     'serverGroupProtection' => [
          'PL' => [
               'pokeMessage' => 'Posiadasz grupę, do której nie jesteś upoważniony!',
               'kickMessage' => 'Posiadasz grupę, do której nie jesteś upoważniony! Została ona usunięta!'
          ],
          'EN' => [
               'pokeMessage' => 'You have a group that You are not authorized to!',
               'kickMessage' => 'You have a group that You are not authorized to! It was removed!'
          ]
     ],
     'autoPoke' => [
          'PL' => [
               'adminPoke' => 'Użytkownik: [user] potrzebuje Twojej pomocy!',
               'disallowedUser' => 'Nie możesz korzystać z centrum pomocy!',
               'inactiveMicrophone' => 'Prosimy aktywować mikrofon!'
          ],
          'EN' => [
               'adminPoke' => 'User: [user] needs Your help!',
               'disallowedUser' => 'You cannot use from help center!',
               'inactiveMicrophone' => 'Activate Your microphone, please!'
          ]
     ],
     'createClanChannels' => [
          'PL' => [
               'alreadyHaveChanel' => 'Nasz system wykrył, że posiadasz już kanał klanowy! Zostałeś na niego przeniesiony. Odnajdź się -> [user]',
               'notRemovedFromDb' => 'Twój kanał został usunięty, ale nie został usunięty z bazy!',
               'failureCreate' => 'Nie udało się stworzyć strefy!', #tego pierdolnika jest chyba z 4 razy w kodzie
               'failureCreateGroup' => 'Nie udało sie stworzyć kanału! Bot nie mógł stworzyć grupy serwera!',
               'repeatedChannelName' => 'Nie udało sie stworzyć kanału! Prawdopodobnie nazwa kanału sie powtórzyła!',
               'successfullyCreate' => 'Strefa została stworzona prawidłowo! Odnajdź się -> [user]',
          ],
          'EN' => [
               'alreadyHaveChanel' => 'Our system detected that You already have clan channel! You were moved to it. Find yourself -> [user]',
               'notRemovedFromDb' => 'Your channel was removed, but not removed from database!',
               'failureCreate' => 'Failure to create zone!', #tego pierdolnika jest chyba z 4 razy w kodzie
               'failureCreateGroup' => 'Failure to create zone! Bot could not create server group!',
               'repeatedChannelName' => 'Failure to create zone! Repeated channel name probably!',
               'successfullyCreate' => 'Zone was created successfuly! Find yourself -> [user]',
          ]
     ],
     'groupLimit' => [
          'PL' => [
               'message' => 'Nasz system wykrył, że posiadasz za dużo rang. Nadmiar został usunięty!',
          ],
          'EN' => [
               'message' => 'Our system detected that You have too much ranks. Excess was removed!',

          ]
     ],
     'levels' => [
          'PL' => [
               'message' => 'Gratulacje! Awansowałeś z poziomu [x] na [y]!',
          ],
          'EN' => [
               'message' => 'Congratulations! You have ranked up from level [x] to [y]!',
          ]
     ],
     'guildChat' => [
          'PL' => [
               'moreThan1' => '-> Masz więcej nię jedną grupę do czatowania! Muszisz wybrać gdzie chcesz czatować, wpisując [b]!switch <numer grupy>[/b] Zawsze będziesz mógl/mogła zmienić swój wybór tą komendą. Poniżej napiszę ci, które grupy masz do wyboru:',
               'noGroups' => '[i]Nie jesteś w żadnej grupie![/i]',
               'chatChanged' => '[i]Zmieniono czat![/i]',
               'errorSave' => '[i]Nie udało się zapisać czatu![/i]',
               'notExists' => '[i]Podany czat nie istnieje![/i]',
               'notForOneGroup' => '[i]Nie możesz używać tej komendy mając jedną grupę czatu![/i]',
               'mutedFor' => '[i]Wyciszyłeś/aś czat na "[seconds]" sekund![/i]',
               'mutedForever' => '[i]Wyciszyłeś/aś czat do momentu aż go wlączysz![/i]',
               'unmuted' => '[i]Odciszyłeś/aś czat![/i]',
               'turnedOnConnect' => '[i]Włączyłeś/aś wiadomość przy wejściu na serwer![/i]',
               'turnedOffConnect' => '[i]Wyłączyłeś/aś wiadomość przy wejściu na serwer![/i]',
               'allGroups' => '-> Poniżej przedstawiam Ci grupy, w których możesz czatować: Użycie: [i]!switch <numer>[/i]'

          ],
          'EN' => [
               'moreThan1' => '-> You have more than one group to chat in! You have to choose where You want to chat, saying [b]!switch <group_number>[/b] You can always change your choice with this command. Below I will write You which groups You have to choose:',
               'noGroups' => '[i]You are not in any group![/i]',
               'chatChanged' => '[i]Chat changed![/i]',
               'errorSave' => '[i]Could not save the chat![/i]',
               'notExists' => '[i]Given chat does not exist![/i]',
               'notForOneGroup' => '[i]You cannot use this command having only one chat group![/i]',
               'mutedFor' => '[i]You have muted chat for [seconds] seconds![/i]',
               'mutedForever' => '[i]You have muted chat until You will unmute it![/i]',
               'unmuted' => '[i]You have just unmuted chat![/i]',
               'turnedOnConnect' => '[i]You turned on message on connect to the server![/i]',
               'turnedOffConnect' => '[i]You turned off message on connect to the server![/i]',
               'allGroups' => '-> Below I will show you groups, where You can chat: Usage: [i]!switch <number>[/i]'
          ]
     ],
];
?>