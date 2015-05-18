<?php

class googleDriveServiceInfo extends \BaseController {
	private $client;
	private $redirectUri;
	private $service;
	
	public function __construct(){
		//session_start();
		//Session::put('user_id',1);
		$tmpClient = new Google_Client();
		$tmpClient->setClientId('517840277924-5mel67o1r46o48t37hko3kntrqfm3gt7.apps.googleusercontent.com');
		$tmpClient->setClientSecret('Bm1CiTT2VR5DtDEcRGAr7elf');
		$tmpClient->addScope('https://www.googleapis.com/auth/drive.file',
						    'https://www.googleapis.com/auth/drive.readonly',
						    'https://www.googleapis.com/auth/drive.metadata.readonly',
						    'https://www.googleapis.com/auth/drive.appdata',
						    'https://www.googleapis.com/auth/drive.apps.readonly',
						    "https://www.googleapis.com/auth/drive",
						    "https://www.googleapis.com/auth/drive.appfolder");
		$this->redirectUri="http://".$_SERVER['SERVER_NAME']."/GAuthFinish";
		/*$this->redirectUri="http://localhost";*/
		$tmpClient->setRedirectUri($this->redirectUri);
		$this->client=$tmpClient;/*createAuthUrl*/
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

		echo "<br>".$this->client->getAccessToken()."<br>";

		echo "<br>".$accessToken."<br>";

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
		$URL = 'http://'.$_SERVER['SERVER_NAME'].'/GClient';
		return Redirect::to($URL);

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
			$Client->setUseObjects(true);
			$Gservice = new Google_Service_Drive($Client);
			$this->service = $Gservice;
			return $Gservice;
		}

	}

	public function getAllFiles(){
		/*$Gservice = $this->service;
		$result = array();
		$pageToken = NULL;

		do{
			try{
				$parameters = array();
				if($pageToken){
					$parameters['pageToken']=$pageToken;
				}
				$files = $service->files->listFiles($parameters);

				$result = array_merge($result, $files->getItems());
				$pageToken = $files->getNextPageToken();
			} catch (Exception $e){
				echo "An error occurred: " . $e->getMessage();
				$pageToken=NULL;
			}
		} while($pageToken);
		var_dump($result);*/

		$Gservice = $this->getGoogleService();
		$parentFolder = $Gservice->getRootFolderId();
		echo $parentFolder;
	}

}
