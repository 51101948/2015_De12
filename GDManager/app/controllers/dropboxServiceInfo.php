<?php

class dropboxServiceInfo extends BaseController {

	private $webAuth;
	private $appInfo;
	private $appName;
	private $csrfTokenStore;
	private $client;
	
	public function token()
  {
    return csrf_token();
  }



	public function __construct(){
		if(!isset($_SESSION))
			session_start();
		
		$APPDIR = dirname(__DIR__);
		$ROOT = dirname($APPDIR);
		$dropboxKey = "06ns3j97428llck";
		$dropboxSecret = "kefp7hysoeirdx6";
		$RedirectUri = $this->getRedirectUri();//"https://gdmanager.local.com/DAuthFinish";
		
		$this->csrfTokenStore = new Dropbox\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
		$this->appInfo =new Dropbox\AppInfo($dropboxKey, $dropboxSecret);/*::loadFromJsonFile($ROOT.'/dropbox-key.json');*/
		$this->appName = "GDManager";
		$this->webAuth = new Dropbox\WebAuth($this->appInfo, $this->appName, $RedirectUri, $this->csrfTokenStore);
	}


	private function getRedirectUri(){
		$result = "";
		if(isset($_SERVER['HTTPS'])){
			if($_SERVER['HTTPS']=="on"){
				$resutl = "https://" . $_SERVER['HTTP_HOST'] . "/DAuthFinish";
				return $resutl;
			}
		}
		else{
			return $result = "http://" . $_SERVER['HTTP_HOST'] . "/DAuthFinish";
		}
	}

	public function getClient(){
		$info = DBoxInfo::where('user_id',Session::get('user_id'))->get()->first();
		$count = DBoxInfo::where('user_id',Session::get('user_id'))->get()->count();
		if ($count === 0) {
			return Redirect::to('/DAuthStart');
		}
		try{
			$this->client = new Dropbox\Client($info->token, $this->appName, 'UTF-8');
			return $this->client;
		} catch(Dropbox\Exception_InvalidAccessToken $e){
			return Redirect::to('/GAuthStart');
		}
	}

	public function AuthStart(){

		if( null == (Session::get('user_id'))){
			return Redirect::to('login')->withFlashMessage('You mush login before view this page');
		}

		else{

			$WA = $this->webAuth;
			return Redirect::to($WA->start());
		} 
	}

	public function AuthFinish(){
		$data = $_GET;
		$WA = $this->webAuth;
		list($accessToken, $uid) = $WA->finish($data);
		$DBoxUser = DBoxInfo::where('user_id',Session::get('user_id'))->get()->count();

		if($DBoxUser === 0){
			$info = [
				'user_id' => Session::get('user_id'),
				'token' => $accessToken];
			DBoxInfo::create($info);
			echo "1 row inserted";
		} else if($DBoxUser === 1){
			$info = DBoxInfo::where('user_id',Session::get('user_id'))
					->update(array('token' => $accessToken));
					echo "1 row update";
		} else{
			echo "something went wrong. please contact to DB Manager";
		}

		return Redirect::to('/GAuthStart');
	}

	public function getDropboxClient(){
		$info = DBoxInfo::where('user_id',Session::get('user_id'))->get()->first();
		$count = DBoxInfo::where('user_id',Session::get('user_id'))->get()->count();
		if ($count === 0) {
			return Redirect::to('/DAuthStart');
		}
		try{
			$client = new Dropbox\Client($info->token, $this->appName, 'UTF-8');
			$clientInfo = $client->getAccountInfo();
			return  View::make('home')->with( 'client',$client );
		} catch(Dropbox\Exception_InvalidAccessToken $e){
			return Redirect::to('/DAuthStart');
		}

	}


	public function uploadFile()
	{
		$info = DBoxInfo::where('user_id',Session::get('user_id'))->get()->first();
		$count = DBoxInfo::where('user_id',Session::get('user_id'))->get()->count();
		$client = new Dropbox\Client($info->token, $this->appName, 'UTF-8');
		$clientInfo = $client->getAccountInfo();
		try{
		/*$path = $_POST('path');*/
		//var_dump($_POST['path']);
		
		
		$uploadPath = $_POST['path'];
		//var_dump($uploadPath);
		$f = fopen($_FILES['fileField']['tmp_name'], "rb");
		//var_dump($_FILES['fileField']['tmp_name']);
		$content = file_get_contents($_FILES['fileField']['tmp_name']);
		//echo $content;
		$result = $client->uploadFile($uploadPath, Dropbox\WriteMode::add(), $f);
			fclose($f);
			print_r($result);

		} catch(Dropbox\Exception_InvalidAccessToken $e){
			return Redirect::to('/DAuthStart');
		}

	}



}
