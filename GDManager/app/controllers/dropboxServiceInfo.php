<?php

class dropboxServiceInfo extends \BaseController {

	private $webAuth;
	private $appInfo;
	private $appName;
	private $csrfTokenStore;

	public function __construct(){
		session_start();
		Session::put('user_id', 1);
		$APPDIR = dirname(__DIR__);
		$ROOT = dirname($APPDIR);
		$dropboxKey = "06ns3j97428llck";
		$dropboxSecret = "kefp7hysoeirdx6";
		$RedirectUri = "https://gdmanager.local/DAuthFinish";
		$this->csrfTokenStore = new Dropbox\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
		$this->appInfo =new Dropbox\AppInfo($dropboxKey, $dropboxSecret);/*::loadFromJsonFile($ROOT.'/dropbox-key.json');*/
		$this->appName = "DboxManager142";
		$this->webAuth = new Dropbox\WebAuth($this->appInfo, $this->appName, $RedirectUri, $this->csrfTokenStore);
	}
	public function AuthStart(){
		$WA = $this->webAuth;
		return Redirect::to($WA->start());
	}
	public function AuthFinish(){
		$data = $_GET;
		$WA = $this->webAuth;
		list($accessToken, $uid) = $WA->finish($data);
		echo "<br>".$uid;*/
		$DBoxUser = DBoxInfo::where('user_id',Session::get('user_id'))->get()->count();

		/*var_dump($DBoxUser === 0);*/
		var_dump(Session::get('user_id'));
		if($DBoxUser === 0){
			$info = [
				'user_id' => Session::get('user_id'),
				'token' => $accessToken,
				'expired_date' => null];
			DBoxInfo::create($info);
			echo "1 row inserted";
		} else if($DBoxUser === 1){
			$info = DBoxInfo::where('user_id',Session::get('user_id'))
					->update(array('token' => $accessToken));
					echo "1 row update";
			
		} else{
			echo "something went wrong. please contact to DB Manager";
		}

		return Redirect::to('/');
	}


}
