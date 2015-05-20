<?php

class googleDriveServiceInfo extends \BaseController {
	private $client;
	private $redirectUri;
	private $service;

	const FOLDER = 'application/vnd.google-apps.folder';
	const PDF = 'application/pdf';
	const DOC = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	const JPG = 'image/jpeg';
	const XLS = 'application/vnd.google-apps.spreadsheet';
	const FORM = 'application/vnd.google-apps.form';
	const RAR = 'application/rar';

	public function __construct(){
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
		//$URL = 'http://'.$_SERVER['SERVER_NAME'].'/GClient';
		return Redirect::to('/GClient');

	}

	public function getGoogleService(){
		$info = GDriveInfo::where('user_id',Session::get('user_id'))->get()->first();
		$strAccess = $info->token;
		$info = json_decode($strAccess,true);
		$AccessToken=$info['access_token'];
		Session::put('access_token',$AccessToken);
		
		$url = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$AccessToken;
    	$temp = curl_init($url);
    	var_dump(Session::get('user_id'));
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
			$Gservice = new Google_Service_Drive($Client);
			

			/*$this->getAllFiles($Gservice, 'root');*/
			//$children = $Gservice->children->get('0B-A0IKSrpg6VaXRadTI1M3BFR00', array());
			//echo self::FOLDER;
			//$this->getAllFiles($Gservice,'0B-A0IKSrpg6VaXRadTI1M3BFR00');
			
			$f_content = file_get_contents(base_path('app/exercise1.docx'));
			echo $f_content.'<br><br>';

			$file = $Gservice->files->get('0B-A0IKSrpg6VT1YwUG9tV1phNHM', array());
			$downloadUrl = $file->getDownloadUrl();
			$request = new Google_Http_Request($downloadUrl, 'GET', null, null);
			    $httpRequest = $Gservice->getClient()->getAuth()->authenticatedRequest($request);
			    if ($httpRequest->getResponseHttpCode() == 200) {
			        $data=$httpRequest->getResponseBody();
			        echo $data;
			    }

			if($f_content===$data){
				echo "<br><br>NOI DUNG GIONG NHAU";
			}
			else{
				echo "<br><br>NOI NO DUNG GIONG NHAU";	
			}

			/*$params = array();
			$data;
			$file = $Gservice->files->get('0B-A0IKSrpg6VbDZQOGFkbjE4cGs', $params);
			var_dump($file->getMimeType());*/
			
			//var_dump($file);

			/*download file to variable*/
			/*$downloadUrl = $file->getDownloadUrl();
			if ($downloadUrl) {
			    $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
			    $httpRequest = $Gservice->getClient()->getAuth()->authenticatedRequest($request);
			    if ($httpRequest->getResponseHttpCode() == 200) {
			        $data=$httpRequest->getResponseBody();
			        //$data = file_get_contents(base_path('app/test.txt'));
			        //var_dump($httpRequest);
			        
			        $mimeType=$file->getMimeType();

			        //upload test
					$fileUp = new Google_Service_Drive_DriveFile($Client);
					$fileUp->setTitle('ABCBACBACBCBAC.docx');
					$fileUp->setMimeType($mimeType);
					$fileUp->setEditable(true);

					$createdFile = $Gservice->files->insert($fileUp, array('data'=>$data,'uploadType'=>'media'));
					//var_dump($createdFile);
			        echo '<br>1234';
			    } else {
			      // An error occurred.
			    	echo $httpRequest->getResponseHttpCode();
			    	echo 'chua lay duoc data<br>';
			      return null;
			    }
			} else {
				echo '<br>7890';
			}*/
		}

	}

	public function getAllFiles($Gservice, $f_id){
		$children = $Gservice->children->get($f_id, array());
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
				$this->getAllFiles($Gservice, $id);
			}
			else{
				echo $id."                 ";
				echo $file->getTitle();
				echo '<br>';
			}
			
		}
	}

}
