<?php

class googleDriveServiceInfo extends \BaseController {
	private $client;
	private $redirectUri;
	private $service;

	const  FOLDER = 'application/vnd.google-apps.folder';
	const  PDF = 'application/pdf';
	const  DOC = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	const  JPG = 'image/jpeg';
	const  XLS = 'application/vnd.google-apps.spreadsheet';
	const  FORM = 'application/vnd.google-apps.form';
	const  RAR = 'application/rar';
	
	public function __construct(){
		if(!isset($_SESSION))
			session_start();
		
		$tmpClient = new Google_Client();
		$tmpClient->setClientId('517840277924-5mel67o1r46o48t37hko3kntrqfm3gt7.apps.googleusercontent.com');
		$tmpClient->setClientSecret('Bm1CiTT2VR5DtDEcRGAr7elf');
		$tmpClient->addScope('https://www.googleapis.com/auth/drive',
	 						 'https://www.googleapis.com/auth/drive.file',
							 'https://www.googleapis.com/auth/drive.readonly',
							 /*'https://www.googleapis.com/auth/drive.metadata.readonly',*/
							 'https://www.googleapis.com/auth/drive.appdata',
							 'https://www.googleapis.com/auth/drive.metadata',
							 'https://www.googleapis.com/auth/drive.apps.readonly',
							 'https://www.googleapis.com/auth/drive.appfolder');
		//$this->redirectUri="http://".$_SERVER['SERVER_NAME']."/GAuthFinish";
		/*$this->redirectUri="http://localhost";*/
		$tmpClient->setRedirectUri($this->getRedirectUri());
		$this->client=$tmpClient;/*createAuthUrl*/
	}
	
	private function getRedirectUri(){
		$result = "";
		if(isset($_SERVER['HTTPS'])){
			if($_SERVER['HTTPS']=="on"){
				$resutl = "https://" . $_SERVER['HTTP_HOST'] . "/GAuthFinish";
				return $resutl;
			}
		}
		else{
			return $result = "http://" . $_SERVER['HTTP_HOST'] . "/GAuthFinish";
		}
	}

	public function AuthStart(){
		$authUrl = $this->client->createAuthUrl();
		return Redirect::to($authUrl);
	}

	public function AuthFinish(){
		$authCode = $_GET['code'];
		$accessToken = $this->client->authenticate($authCode);

		/*$accessInfo = (json_decode($accessInfo, true));
		$accessToken = $accessInfo['access_token'];*/
		$GDriveUser = GDriveInfo::where('user_id',Session::get('user_id'))->get()->count();

		if($GDriveUser === 0){
			$info = [
				'user_id' => Session::get('user_id'),
				'token' => $accessToken];
			GDriveInfo::create($info);
			echo "1 row inserted";
		} else if($GDriveUser === 1){
			$info = GDriveInfo::where('user_id',Session::get('user_id'))
					->update(array('token' => $accessToken));
			echo "1 row update";
			
		} else{
			echo "something went wrong. please contact to DB Manager";
		}
		return Redirect::to('/GClient');

	}

	public function getClient(){
		$info = GDriveInfo::where('user_id',Session::get('user_id'))->get()->first();
		$strAccess = $info->token;
		$info = json_decode($strAccess,true);
		$AccessToken=$info['access_token'];
		Session::put('access_token',$AccessToken);
		
		$url = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$AccessToken;
    	$temp = curl_init($url);
		//curl_setopt($temp, CURLOPT_POST, 1);
		//curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($temp), true);
		if(array_key_exists('error', $response)){
			return Redirect::to('/GAuthStart');
		}
		else{ 
			$Client = new Google_Client();
			$Client->setAccessToken($strAccess);
			$Client->addScope('https://www.googleapis.com/auth/drive',
	 						 'https://www.googleapis.com/auth/drive.file',
							 'https://www.googleapis.com/auth/drive.readonly',
							 /*'https://www.googleapis.com/auth/drive.metadata.readonly',*/
							 'https://www.googleapis.com/auth/drive.appdata',
							 'https://www.googleapis.com/auth/drive.metadata',
							 'https://www.googleapis.com/auth/drive.apps.readonly',
							 'https://www.googleapis.com/auth/drive.appfolder');
			return $Client;
		}
	}

	public function getGoogleService(){
		$info = GDriveInfo::where('user_id',Session::get('user_id'))->get()->first();
		$strAccess = $info->token;
		$info = json_decode($strAccess,true);
		$AccessToken=$info['access_token'];
		
		$url = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$AccessToken;
    	$temp = curl_init($url);
		//curl_setopt($temp, CURLOPT_POST, 1);
		//curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($temp), true);
		if(array_key_exists('error', $response)){
			return Redirect::to('/GAuthStart');
		}
		else{ 
			$Client = new Google_Client();
			$Client->setAccessToken($strAccess);
			$Client->addScope('https://www.googleapis.com/auth/drive',
	 						 'https://www.googleapis.com/auth/drive.file',
							 'https://www.googleapis.com/auth/drive.readonly',
							 /*'https://www.googleapis.com/auth/drive.metadata.readonly',*/
							 'https://www.googleapis.com/auth/drive.appdata',
							 'https://www.googleapis.com/auth/drive.metadata',
							 'https://www.googleapis.com/auth/drive.apps.readonly',
							 'https://www.googleapis.com/auth/drive.appfolder');
			$Gservice = new Google_Service_Drive($Client);
			return Redirect::to('/');
		}
	}

	public function showAllFile(){
		$client = $this->getClient();
		$service = new Google_Service_Drive($client);
		$this->getAllFiles($service, 'root');

	}


	public function getAllFiles($Gservice, $f_id){
		$children = $Gservice->files->listFiles(array());//($f_id, array());
		$items=$children['items'];
		foreach($items as $item){
			$params = array();
			$data;
			$id=$item['id'];
			$file = $Gservice->files->get($id, $params);
			//var_dump($file->getMimeType)
			if ($file->getMimeType()===self::FOLDER){
				echo $file->getTitle();
				echo ' CO : <br>';
				//$this->getAllFiles($Gservice, $id);
			}
			else{
				echo $id."                 ";
				echo $file->getTitle();
				echo '<br>';
			}
		}
		var_dump($children);
	}

}
