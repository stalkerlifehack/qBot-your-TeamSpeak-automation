<?php
/**********************************************

         Plik: qBteamspeakot.class.php.php
              Autor: Stalker
              TS: Jutuby.Net
          Mail: kontakt@jutuby.net

***********************************************/

class teamspeak{

  public $runtime = [];

  function __construct($host, $queryPort, $errorPrefix){
    $this->runtime['queryPort'] = $queryPort;
    $this->runtime['host'] = $host;
    $this->runtime['timeOut'] = 10;
    $this->errorPrefix = $errorPrefix;
  }

  # Connect/Disconnect to server
  function connect(){
    $this->runtime['socket'] = @fsockopen($this->runtime['host'], $this->runtime['queryPort'], $errnum, $errstr, $this->runtime['timeOut']);

    if(!$this->runtime['socket']){
      exit($this->errorPrefix."Nie można się połączyć z serwerem! Error: $errstr".PHP_EOL);
    }
    else{
      if(strpos(fgets($this->runtime['socket']), 'TS3') !== false){
        $this->runtime['socket'] = $this->runtime['socket'];
        return true;
      }
      else{
        exit($this->errorPrefix."Nie możesz połączyć sie z serwerem! Host nie jest instancją teamspeak!".PHP_EOL);
      }
    }
  }
  function login($username, $password){
    return $this->getData('boolean', "login ".$this->escapeText($username)." ".$this->escapeText($password));
  }
  function selectServer($port){
    return $this->getData('boolean', "use port=$port");
  }
  function setName($name){
		return $this->getData('boolean', 'clientupdate client_nickname='.$this->escapeText($name));
	}
  function logout() {
		return $this->getData('boolean', 'logout');
	}

  # Functions there return data

  function privilegekeyList(){
    return $this->getData('multi', 'privilegekeylist');
  }
  function whoAmI(){
    return $this->getData('array', 'whoami');
  }
  function clientMove($clid, $cid, $cpw = null){
		return $this->getData('boolean', 'clientmove clid='.$clid.' cid='.$cid.(!empty($cpw) ? ' cpw='.$this->escapeText($cpw) : ''));
	}
  function clientList($params = null){

		if(!empty($params)) { $params = ' '.$params; }

		return $this->getData('multi', 'clientlist'.$params);
	}
  function privilegekeyAdd($tokentype, $tokenid1, $tokenid2, $description ='', $customFieldSet = array()){

		if(!empty($description)) { $description = ' tokendescription=' . $this->escapeText($description); }

		if($tokentype == '0') { $tokenid2 = '0'; }

		if(count($customFieldSet)) {
			$settingsString = array();

			foreach($customFieldSet as $key => $value) {
				$settingsString[] = 'ident='.$this->escapeText($key).'\svalue='.$this->escapeText($value);
			}

			$customFieldSet = ' tokencustomset='.implode('\p', $settingsString);
		}else{
			$customFieldSet = '';
		}

		return $this->getData('array', 'privilegekeyadd tokentype='.$tokentype.' tokenid1='.$tokenid1.' tokenid2='.$tokenid2.$description.$customFieldSet);
  }
  function clientInfo($clid){
		return $this->getData('array', 'clientinfo clid='.$clid);
	}
  function channelClientList($cid, $params = null){

		if(!empty($params)) { $params = ' '.$params; }

		$result = $this->getData('multi', 'clientlist'.$params);

    if($result['success'])
    {
      $clients = array();

      if(count($result['data']) > 0)
      {
        foreach($result['data'] as $client)
        {
          if($client['cid'] == $cid)
          {
            $clients[] = $client;
          }
        }
      }

      return $this->generateOutput(true, null, $clients);
    }
    else
    {
      return $result;
    }
	}
  function channelCreate($data){

		$propertiesString = '';

		foreach($data as $key => $value) {
			$propertiesString .= ' '.strtolower($key).'='.$this->escapeText($value);
		}

		return $this->getData('array', 'channelcreate '.$propertiesString);
	}
  function channelEdit($cid, $data){

		$settingsString = '';

		foreach($data as $key => $value) {
			$settingsString .= ' '.strtolower($key).'='.$this->escapeText($value);
		}

		return $this->getData('boolean', 'channeledit cid='.$cid.$settingsString);
	}
  function serverInfo(){
		return $this->getData('array', 'serverinfo');
	}
  function serverGroupClientList($sgid, $names = false) {
		if($names) { $names = ' -names'; }else{ $names = ''; }
		return $this->getData('multi', 'servergroupclientlist sgid='.$sgid.$names);
	}
  function channelList($params = null) {
		if(!empty($params)) { $params = ' '.$params; }

		return $this->getData('multi', 'channellist'.$params);
	}
  function serverGroupList() {
		return $this->getData('multi', 'servergrouplist');
	}
  function clientGetDbIdFromUid($cluid) {
		return $this->getData('array', 'clientgetdbidfromuid cluid='.$cluid);
	}
  function clientDbInfo($cldbid) {
		return $this->getData('array', 'clientdbinfo cldbid='.$cldbid);
	}
  function channelInfo($cid) {
    return $this->getData('array', 'channelinfo cid='.$cid);
  }
  function clientDbList($start = 0, $duration = -1, $count = false) {
		return $this->getData('multi', 'clientdblist'.($start != 0 ? ' start='.$start : '').($duration != -1 ? ' duration='.$duration : '').($count ? ' -count' : ''));
	}
  function clientGetNameFromDbid($cldbid) {
		return $this->getData('array', 'clientgetnamefromdbid cldbid='.$cldbid);
	}
  function banList() {

		return $this->getData('multi', 'banlist');
	}
  function channelClientPermList($cid, $cldbid, $permsid = false) {

		return $this->getData('multi', 'channelclientpermlist cid='.$cid.' cldbid='.$cldbid.($permsid ? ' -permsid' : ''));
	}
  function channelFind($pattern) {

		return $this->getData('multi', 'channelfind pattern='.$this->escapeText($pattern));
	}
  function channelGroupAdd($name, $type = 1) {

		return $this->getData('array', 'channelgroupadd name='.$this->escapeText($name).' type='.$type);
	}
  function channelGroupClientList($cid = NULL, $cldbid = NULL, $cgid = NULL) {

		return $this->getData('multi', 'channelgroupclientlist'.(!empty($cid) ? ' cid='.$cid : '').(!empty($cldbid) ? ' cldbid='.$cldbid : '').(!empty($cgid) ? ' cgid='.$cgid : ''));
	}
  function channelGroupCopy($scgid, $tcgid, $name, $type = 1) {
		return $this->getData('array', 'channelgroupcopy scgid='.$scgid.' tcgid='.$tcgid.' name='.$this->escapeText($name).' type='.$type);
	}
  function channelGroupList() {

		return $this->getData('multi', 'channelgrouplist');
	}
  function channelGroupPermList($cgid, $permsid = false) {
		return $this->getData('multi', 'channelgrouppermlist cgid='.$cgid.($permsid ? ' -permsid' : ''));
	}
  function channelGroupRename($cgid, $name) {
		return $this->getData('boolean', 'channelgrouprename cgid='.$cgid.' name='.$this->escapeText($name));
	}
  function channelPermList($cid, $permsid = false) {
		return $this->getData('multi', 'channelpermlist cid='.$cid.($permsid ? ' -permsid' : ''));
	}
  function clientDbFind($pattern, $uid = false) {

		return $this->getData('multi', 'clientdbfind pattern='.$this->escapeText($pattern).($uid ? ' -uid' : ''));
	}
  function clientFind($pattern) {
		return $this->getData('multi', 'clientfind pattern='.$this->escapeText($pattern));
	}
  function clientGetIds($cluid) {
		return $this->getData('multi', 'clientgetids cluid='.$cluid);
	}
  function clientGetNameFromUid($cluid) {
		return $this->getData('array', 'clientgetnamefromuid cluid='.$cluid);
	}
  function clientPermList($cldbid, $permsid = false) {
		return $this->getData('multi', 'clientpermlist cldbid='.$cldbid.($permsid ? ' -permsid' : ''));
	}
  function clientSetServerQueryLogin($username) {
		return $this->getData('array', 'clientsetserverquerylogin client_login_name='.$this->escapeText($username));
	}
  function complainList($tcldbid = null) {
		if(!empty($tcldbid)) { $tcldbid = ' tcldbid='.$tcldbid; }
		return $this->getData('multi', 'complainlist'.$tcldbid);
	}
  function customInfo($cldbid) {
		return $this->getData('multi', 'custominfo cldbid='.$cldbid);
	}
  function customSearch($ident, $pattern) {
		return $this->getData('multi', 'customsearch ident='.$this->escapeText($ident).' pattern='.$this->escapeText($pattern));
	}
  function customSet($cldbid, $ident, $value) {
		return $this->getData('boolean', 'customset cldbid='.$cldbid.' ident='.$this->escapeText($ident).' value='.$this->escapeText($value));
	}
  function execOwnCommand($mode, $command) {
		if($mode == '0') {
			return $this->getData('boolean', $command);
		}
		if($mode == '1') {
			return $this->getData('array', $command);
		}
		if($mode == '2') {
			return $this->getData('multi', $command);
		}
		if($mode == '3') {
			return $this->getData('plain', $command);
		}
	}
  function hostInfo() {
		return $this->getData('array', 'hostinfo');
	}
  function instanceInfo() {
		return $this->getData('array', 'instanceinfo');
	}
  function logAdd($logLevel, $logMsg) {
		if($logLevel >=1 and $logLevel <= 4) {
			if(!empty($logMsg)) {
				return $this->getData('boolean', 'logadd loglevel='.$logLevel.' logmsg='.$this->escapeText($logMsg));
			}
		}
	}
  function logView($lines, $reverse = 0, $instance = 0, $begin_pos = 0) {
		if($lines >=1 and $lines <=100) {
			return $this->getData('multi', 'logview lines='.$lines.' reverse='.($reverse == 0 ? '0' : '1').' instance='.($instance == 0 ? '0' : '1').' begin_pos='.($begin_pos == 0 ? '0' : $begin_pos));
		}
	}
  function messageGet($messageID) {
    return $this->getData('array', 'messageget msgid='.$messageID);
	}
  function messageList() {
    return $this->getData('array', 'messagelist');
	}
  function messageUpdateFlag($messageID, $flag = 1) {
    return $this->getData('boolean', 'messageupdateflag msgid='.$messageID.' flag='.$flag);
	}
  function permFind($perm) {
    return $this->getData('multi', 'permfind '.(is_int($perm) || ctype_digit($perm) ? 'permid=' : 'permsid=').$perm);
  }
  function permGet($perm) {
    return $this->getData('array', 'permget '.(is_int($perm) || ctype_digit($perm) ? 'permid=' : 'permsid=').$perm);
  }
  function permIdGetByName($permsids) {
		$permissionArray = array();

		if(count($permsids) > 0) {
			foreach($permsids AS $value) {
				$permissionArray[] = 'permsid='.$value;
			}
			return $this->getData('multi', 'permidgetbyname '.$this->escapeText(implode('|', $permissionArray)));
		}
	}
  function permissionList($new = false) {
		if($new === true) {
			$groups = array();
			$permissions = array();

			$response = $this->getData('multi', 'permissionlist -new')['data'];

			$gc = 1;

			foreach($response as $field) {
				if(isset($field['group_id_end'])) {
					$groups[] = array('num' => $gc, 'group_id_end' => $field['group_id_end']);
					$gc++;
				}else{
					$permissions[] = $field;
				}
			}

			$counter = 0;

			for($i = 0; $i < count($groups); $i++) {
				$rounds = $groups[$i]['group_id_end'] - $counter;
				$groups[$i]['pcount'] = $rounds;
				for($j = 0; $j < $rounds; $j++) {
					$groups[$i]['permissions'][] = array('permid' => ($counter + 1), 'permname' => $permissions[$counter]['permname'], 'permdesc' => $permissions[$counter]['permdesc'], 'grantpermid' => ($counter + 32769));
					$counter++;
				}
			}

			return $groups;

		}else{
			return $this->getData('multi', 'permissionlist');
		}
	}
  function permOverview($cid, $cldbid, $permid='0', $permsid=false ) {

    if($permsid) { $additional = ' permsid='.$permsid; }else{ $additional = ''; }

    return $this->getData('multi', 'permoverview cid='.$cid.' cldbid='.$cldbid.($permsid == false ? ' permid='.$permid : '').$additional);
  }
  function permReset() {
    return $this->getData('array', 'permreset');
  }
  function serverGroupCopy($ssgid, $tsgid, $name, $type = 1) {
		return $this->getData('array', 'servergroupcopy ssgid='.$ssgid.' tsgid='.$tsgid.' name='.$this->escapeText($name).' type='.$type);
	}
  function serverGroupDelete($sgid, $force = 1) {
		return $this->getData('boolean', 'servergroupdel sgid='.$sgid.' force='.$force);
	}
  function serverGroupPermList($sgid, $permsid = false) {
		if($permsid) { $additional = ' -permsid'; }else{ $additional = ''; }
		return $this->getData('multi', 'servergrouppermlist sgid='.$sgid.$additional);
	}
  function serverGroupRename($sgid, $name) {
		return $this->executeCommand('servergrouprename sgid='.$sgid.' name='.$this->escapeText($name));
	}
  function serverGroupsByClientID($cldbid) {
		return $this->getData('multi', 'servergroupsbyclientid cldbid='.$cldbid);
	}
  function serverIdGetByPort($port) {
		return $this->getData('array', 'serveridgetbyport virtualserver_port='.$port);
	}








  # Functions there don't return data
  function clientPoke($clid, $msg){
    $this->executeCommand('clientpoke clid='.$clid.' msg='.$this->escapeText($msg));
	}
  function sendMessage($mode, $target, $msg){
		return $this->executeCommand('sendtextmessage targetmode='.$mode.' target='.$target.' msg='.$this->escapeText($msg));
	}
  function clientKick($clid, $kickMode = "server", $kickmsg = ""){
		if($kickMode == 'server') {
      $from = '5';
    }
		if($kickMode == 'channel') {
      $from = '4';
    }
		if(!empty($kickmsg)) {
      $msg = ' reasonmsg='.$this->escapeText($kickmsg);
    } else{
      $msg = '';
    }
		return $this->executeCommand('clientkick clid='.$clid.' reasonid='.$from.$msg);
	}
  function banClient($clid, $time = 0, $banreason = NULL) {
		if(!empty($banreason)){
      $msg = ' banreason='.$this->escapeText($banreason);
    } else {
      $msg = '';
    }
		$result = $this->executeCommand('banclient clid='.$clid.' time='.$time.$msg);
	}
  function banAddByIp($ip, $time = 0, $banreason = NULL) {
		if(!empty($banreason)){
      $msg = ' banreason='.$this->escapeText($banreason);
    } else {
      $msg = NULL;
    }

		return $this->executeCommand('banadd ip='.$ip.' time='.$time.$msg);
	}
  function serverEdit($data){

		$settingsString = '';

		foreach($data as $key => $value) {
			$settingsString .= ' '.strtolower($key).'='.$this->escapeText($value);
		}

		return $this->executeCommand('serveredit'.$settingsString);
	}
  function serverGroupAddClient($sgid, $cldbid){
		return $this->executeCommand('servergroupaddclient sgid='.$sgid.' cldbid='.$cldbid);
	}
  function serverGroupDeleteClient($sgid, $cldbid){
		return $this->executeCommand('servergroupdelclient sgid='.$sgid.' cldbid='.$cldbid);
	}
  function clientEdit($clid, $data){

		$settingsString = '';

		foreach($data as $key => $value) {
			$settingsString .= ' '.strtolower($key).'='.$this->escapeText($value);
		}

		return $this->executeCommand('clientedit clid='.$clid.$settingsString);
	}
  function version(){
		return $this->executeCommand('version');
	}
  function setClientChannelGroup($cgid, $cid, $cldbid) {
		return $this->executeCommand('setclientchannelgroup cgid='.$cgid.' cid='.$cid.' cldbid='.$cldbid);
	}
  function channelDelete($cid, $force = 1) {
		return $this->executeCommand('channeldelete cid='.$cid.' force='.$force);
	}
  function banAddByUid($uid, $time = 0, $banreason = NULL) {

		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = NULL; }

		return $this->executeCommand('banadd uid='.$uid.' time='.$time.$msg);
	}
  function banAddByName($name, $time = 0, $banreason = NULL) {

		if(!empty($banreason)) { $msg = ' banreason='.$this->escapeText($banreason); } else { $msg = NULL; }

		return $this->executeCommand('banadd name='.$this->escapeText($name).' time='.$time.$msg);
	}
  function banDelete($banID) {
		return $this->executeCommand('bandel banid='.$banID);
	}
  function banDeleteAll() {
		return $this->executeCommand('boolean', 'bandelall');
	}
  function channelAddPerm($cid, $permissions) {


		if(count($permissions) > 0) {
			//Permissions given

			//Errorcollector
			$errors = array();

			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);

			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();

				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value;
				}

				$result = $this->executeCommand('channeladdperm cid='.$cid.' '.implode('|', $command_string));
			}
		}
	}
  function channelClientAddPerm($cid, $cldbid, $permissions) {


		if(count($permissions) > 0) {
			//Permissions given

			//Errorcollector
			$errors = array();

			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);

			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();

				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value;
				}

				$result = $this->executeCommand('channelclientaddperm cid='.$cid.' cldbid='.$cldbid.' '.implode('|', $command_string));

			}
		}
	}
  function channelClientDelPerm($cid, $cldbid, $permissions) {

		$permissionArray = array();

		if(count($permissions) > 0) {
			foreach($permissions AS $value) {
				$permissionArray[] = is_numeric($value) ? 'permid='.$value : 'permsid='.$value;
			}
			return $this->executeCommand('channelclientdelperm cid='.$cid.' cldbid='.$cldbid.' '.implode('|', $permissionArray));
		}
	}
  function channelDelPerm($cid, $permissions) {

		$permissionArray = array();

		if(count($permissions) > 0) {
			foreach($permissions AS $value) {
				$permissionArray[] = (is_numeric($value) ? 'permid=' : 'permsid=').$value;
			}
			return $this->executeCommand('channeldelperm cid='.$cid.' '.implode('|', $permissionArray));
		}
	}
  function channelGroupAddPerm($cgid, $permissions) {


    if(count($permissions) > 0) {
      //Permissions given

      //Errorcollector
      $errors = array();

      //Split Permissions to prevent query from overload
      $permissions = array_chunk($permissions, 50, true);

      //Action for each splitted part of permission
      foreach($permissions as $permission_part)
      {
        //Create command_string for each command that we could use implode later
        $command_string = array();

        foreach($permission_part as $key => $value)
        {
          $command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value;
        }

        $result = $this->executeCommand('channelgroupaddperm cgid='.$cgid.' '.implode('|', $command_string));
      }
    }
  }
  function channelGroupDelete($cgid, $force = 1) {
		return $this->executeCommand('channelgroupdel cgid='.$cgid.' force='.$force);
	}
  function channelGroupDelPerm($cgid, $permissions) {

		$permissionArray = array();

		if(count($permissions) > 0) {
			foreach($permissions AS $value) {
				$permissionArray[] = (is_numeric($value) ? 'permid=' : 'permsid=').$value;
			}
			return $this->executeCommand('channelgroupdelperm cgid='.$cgid.' '.implode('|', $permissionArray));
		}
	}
  function channelMove($cid, $cpid, $order = null) {
		return $this->executeCommand('channelmove cid='.$cid.' cpid='.$cpid.($order != null ? ' order='.$order : ''));
	}
  function clientAddPerm($cldbid, $permissions) {


		if(count($permissions) > 0) {
			//Permissions given

			//Errorcollector
			$errors = array();

			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);

			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();

				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$this->escapeText($value[0]).' permskip='.$this->escapeText($value[1]);
				}

				$result = $this->executeCommand('clientaddperm cldbid='.$cldbid.' '.implode('|', $command_string));
			}
		}
	}
  function clientDbDelete($cldbid) {
		return $this->executeCommand('clientdbdelete cldbid='.$cldbid);
	}
  function clientDbEdit($cldbid, $data) {

		$settingsString = '';

		foreach($data as $key => $value) {
			$settingsString .= ' '.strtolower($key).'='.$this->escapeText($value);
		}

		return $this->executeCommand('clientdbedit cldbid='.$cldbid.$settingsString);
	}
  function clientDelPerm($cldbid, $permissionIds) {

		$permissionArray = array();

		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = (is_numeric($value) ? 'permid=' : 'permsid=').$value;
			}
			return $this->executeCommand('clientdelperm cldbid='.$cldbid.' '.implode('|', $permissionArray));
		}
	}
  function clientUpdate($data) {
		$settingsString = '';

		foreach($data as $key => $value) {
			$settingsString .= ' '.strtolower($key).'='.$this->escapeText($value);
		}
		return $this->executeCommand('clientupdate '.$settingsString);
	}
  function complainAdd($tcldbid, $msg) {
		return $this->executeCommand('complainadd tcldbid='.$tcldbid.' message='.$this->escapeText($msg));
	}
  function complainDelete($tcldbid, $fcldbid) {
		return $this->executeCommand('complaindel tcldbid='.$tcldbid.' fcldbid='.$fcldbid);
	}
  function complainDeleteAll($tcldbid) {
		return $this->executeCommand('boolean', 'complaindelall tcldbid='.$tcldbid);
	}
  function customDelete($cldbid, $ident) {
		return $this->executeCommand('customdelete cldbid='.$cldbid.' ident='.$this->escapeText($ident));
	}
  function ftCreateDir($cid, $cpw = null, $dirname) {
		return $this->executeCommand('ftcreatedir cid='.$cid.' cpw='.$this->escapeText($cpw).' dirname='.$this->escapeText($dirname));
	}
  function ftDeleteFile($cid, $cpw = '', $files) {

		$fileArray = array();

		if(count($files) > 0) {
			foreach($files AS $file) {
				$fileArray[] = 'name='.$this->escapeText($file);
			}
			return $this->executeCommand('ftdeletefile cid='.$cid.' cpw='.$this->escapeText($cpw).' '.implode('|', $fileArray));
		}
	}
  function gm($msg) {
		return $this->executeCommand('gm msg='.$this->escapeText($msg));
	}
  function instanceEdit($data) {
		if(count($data) > 0) {
			$settingsString = '';

			foreach($data as $key => $val) {
				$settingsString .= ' '.strtolower($key).'='.$this->escapeText($val);
			}
			return $this->executeCommand('instanceedit '.$settingsString);
		}
	}
  function messageAdd($cluid, $subject, $message) {
    return $this->executeCommand('messageadd cluid='.$cluid.' subject='.$this->escapeText($subject).' message='.$this->escapeText($message));
	}
  function messageDelete($messageID) {
    return $this->executeCommand('messagedel msgid='.$messageID);
	}
  function serverGroupAdd($name, $type = 1) {
		return $this->executeCommand('servergroupadd name='.$this->escapeText($name).' type='.$type);
	}
  function serverGroupAddPerm($sgid, $permissions) {


		if(count($permissions) > 0) {
			//Permissions given

			//Errorcollector
			$errors = array();

			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);

			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();

				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value[0].' permskip='.$value[1].' permnegated='.$value[2];
				}

				$result = $this->executeCommand('servergroupaddperm sgid='.$sgid.' '.implode('|', $command_string));
			}
		}
	}
  function serverGroupAutoAddPerm($sgtype, $permissions) {


		if(count($permissions) > 0) {
			//Permissions given

			//Errorcollector
			$errors = array();

			//Split Permissions to prevent query from overload
			$permissions = array_chunk($permissions, 50, true);

			//Action for each splitted part of permission
			foreach($permissions as $permission_part)
			{
				//Create command_string for each command that we could use implode later
				$command_string = array();

				foreach($permission_part as $key => $value)
				{
					$command_string[] = (is_numeric($key) ? "permid=" : "permsid=").$this->escapeText($key).' permvalue='.$value[0].' permskip='.$value[1].' permnegated='.$value[2];
				}

				$result = $this->executeCommand('servergroupautoaddperm sgtype='.$sgtype.' '.implode('|', $command_string));

			}
		}
	}
  function serverGroupAutoDeletePerm($sgtype, $permissions) {

		$permissionArray = array();

		if(count($permissions) > 0) {
			foreach($permissions AS $value) {
				$permissionArray[] = is_numeric($value) ? 'permid='.$value : 'permsid='.$this->escapeText($value);
			}
			return $this->executeCommand('servergroupautodelperm sgtype='.$sgtype.' '.implode('|', $permissionArray));
		}
	}
  function serverGroupDeletePerm($sgid, $permissionIds) {

		$permissionArray = array();

		if(count($permissionIds) > 0) {
			foreach($permissionIds AS $value) {
				$permissionArray[] = is_numeric($value) ? 'permid='.$value : 'permsid='.$this->escapeText($value);
			}
			return $this->executeCommand('servergroupdelperm sgid='.$sgid.' '.implode('|', $permissionArray));
		}
	}
  function serverSnapshotCreate() {
		return $this->getData('plain', 'serversnapshotcreate');
	}










  private function escapeText($text){
 		$text = str_replace("\t", '\t', $text);
		$text = str_replace("\v", '\v', $text);
		$text = str_replace("\r", '\r', $text);
		$text = str_replace("\n", '\n', $text);
		$text = str_replace("\f", '\f', $text);
		$text = str_replace(' ', '\s', $text);
		$text = str_replace('|', '\p', $text);
		$text = str_replace('/', '\/', $text);
		return $text;
	}
  private function getData($mode, $command){

		$validModes = array('boolean', 'array', 'multi', 'plain');

		$fetchData = $this->executeCommand($command, debug_backtrace());

		$fetchData['data'] = str_replace(array('error id=0 msg=ok', chr('01')), '', $fetchData['data']);

		if($fetchData['success']) {
			if($mode == 'boolean') {
				return $this->generateOutput(true, array(), true);
			}

			if($mode == 'array') {
				if(empty($fetchData['data'])) { return $this->generateOutput(true, array(), array()); }
				$datasets = explode(' ', $fetchData['data']);

				$output = array();

				foreach($datasets as $dataset) {
					$dataset = explode('=', $dataset);

					if(count($dataset) > 2) {
						for($i = 2; $i < count($dataset); $i++) {
							$dataset[1] .= '='.$dataset[$i];
						}
						$output[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
					}else{
						if(count($dataset) == 1) {
							$output[$this->unEscapeText($dataset[0])] = '';
						}else{
							$output[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
						}

					}
				}
				return $this->generateOutput(true, array(), $output);
			}
			if($mode == 'multi') {
				if(empty($fetchData['data'])) { return $this->generateOutput(true, array(), array()); }
				$datasets = explode('|', $fetchData['data']);

				$output = array();

				foreach($datasets as $datablock) {
					$datablock = explode(' ', $datablock);

					$tmpArray = array();

					foreach($datablock as $dataset) {
						$dataset = explode('=', $dataset);
						if(count($dataset) > 2) {
							for($i = 2; $i < count($dataset); $i++) {
								$dataset[1] .= '='.$dataset[$i];
							}
							$tmpArray[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
						}else{
							if(count($dataset) == 1) {
								$tmpArray[$this->unEscapeText($dataset[0])] = '';
							}else{
								$tmpArray[$this->unEscapeText($dataset[0])] = $this->unEscapeText($dataset[1]);
							}
						}
					}
					$output[] = $tmpArray;
				}
				return $this->generateOutput(true, array(), $output);
			}
			if($mode == 'plain') {
				return $fetchData;
			}
		}else{
			return $this->generateOutput(false, $fetchData['errors'], false);
		}
	}
  private function executeCommand($command, $tracert = null){
		$data = '';

		$splittedCommand = str_split($command, 1024);

		$splittedCommand[(count($splittedCommand) - 1)] .= "\n";

		foreach($splittedCommand as $commandPart)
		{
			if(!(@fputs($this->runtime['socket'], $commandPart)))
			{
				exit("Nie nawiązano połączenia! (Socket closed)".PHP_EOL);
			}
		}
		do {
			$data .= @fgets($this->runtime['socket'], 4096);

			if(empty($data))
			{
				exit("Nie nawiązano połączenia! (Socket closed)".PHP_EOL);
			}
			else if(strpos($data, 'error id=3329 msg=connection') !== false) {
				exit("Flood Ban!".PHP_EOL);
			}

		} while(strpos($data, 'msg=') === false or strpos($data, 'error id=') === false);

		if(strpos($data, 'error id=0 msg=ok') === false) {
			$splittedResponse = explode('error id=', $data);
			$chooseEnd = count($splittedResponse) - 1;

			$cutIdAndMsg = explode(' msg=', $splittedResponse[$chooseEnd]);

			if($tracert != null)


			return $this->generateOutput(false, array('ErrorID: '.$cutIdAndMsg[0].' | Message: '.$this->unEscapeText($cutIdAndMsg[1])), false);
		}else{
			return $this->generateOutput(true, array(), $data);
		}
	}
  private function generateOutput($success, $errors, $data){
		return array('success' => $success, 'errors' => $errors, 'data' => $data);
	}
  private function unEscapeText($text){
 		$escapedChars = array("\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/");
 		$unEscapedChars = array('', '', '', '', '', ' ', '|', '/');
		$text = str_replace($escapedChars, $unEscapedChars, $text);
		return $text;
	}

}
 ?>
