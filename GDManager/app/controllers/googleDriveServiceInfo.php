<?php

class googleDriveServiceInfo extends \BaseController {
	private $client;
	private $redirectUri;
	private $service;
	
	public function __construct(){
		session_start();
		Session::put('user_id',1);
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
			
			//var_dump($Gservice->children->get('root', array()));
			//var_dump($Gservice->files->get('11w-ncO6s6ri-QztZ7FEHdpE3eTtZjukaZuL10zTFs6A'));

			/*$children = $Gservice->children->get('root', array());
			var_dump($children);*/

			$params = array();
			$data;
			//$params['Authorization'] = 'Bearer '.$AccessToken;
			//$file = $Gservice->files->get('0B3eaUYuGRDUqQ2l5eFg4eE5UODc0NnZvbko3NDhEYVVTeS1R', $params);
			/*get file infomation*/
			$file = $Gservice->files->get('0B3eaUYuGRDUqfllzS2UxdDBrUTZ4UFd3NTlReGFrU3BWUXR3eDNVVHg4NVJDNmtiQU9CTnc', $params);
			var_dump($file->getMimeType());
			echo '<br>application/vnd.openxmlformats-officedocument.wordprocessingml.document';
			//var_dump($file);

			/*download file to variable*/
			$downloadUrl = $file->getDownloadUrl();
			if ($downloadUrl) {
			    $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
			    $httpRequest = $Gservice->getClient()->getAuth()->authenticatedRequest($request);
			    if ($httpRequest->getResponseHttpCode() == 200) {
			        //var_dump($httpRequest);
			        $data=$httpRequest->getResponseBody();
			        /*$fp = fopen(base_path('app/MYDOC.txt'),'w');
			        fwrite($fp, $data);*/
			        //$data = file_get_contents(base_path('app/test.txt'));
			        //var_dump($httpRequest);
			        
			        $mimeType='application/vnd.openxmlformats-officedocument.wordprocessingml.document';
			        //$mimeType = 'text/plain';
			        echo '<br><br>';
			        //echo($data);

			        /*upload test*/
					$fileUp = new Google_Service_Drive_DriveFile($Client);
					$fileUp->setTitle('uploadDOCTEST.docx');
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
			}
		}

	}

	public function getAllFiles(){
		$service = $this->getGoogleService();
		var_dump($service);
		/*$Gservice = $this->getGoogleService();
		$rootAlias = 'root';
		$pageToken = NULL;
		do{
			try{
				$parameters = array();
				if($pageToken){
					$parameters['pageToken']=$pageToken;
				}
				$children = $Gservice->children->listChildren($rootAlias, $parameters);
				foreach ($children->getItems() as $child) {
					var_dump(child);
					echo '<br><br>';
				}
				$pageToken = $children->getNextPageToken();
			} catch (Exception $e){
				echo $e->getMessage();
				$pageToken = NULL;
			}
		} while($pageToken);


		
		*/
	}

}
