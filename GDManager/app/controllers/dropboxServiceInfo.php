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
		$RedirectUri = $this->getRedirectUri();//"https://gdmanager.local.com/DAuthFinish";
		echo $RedirectUri;
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
	public function AuthStart(){
		$WA = $this->webAuth;
		return Redirect::to($WA->start());
	}
	public function AuthFinish(){
		$data = $_GET;
		$WA = $this->webAuth;
		list($accessToken, $uid) = $WA->finish($data);
		$DBoxUser = DBoxInfo::where('user_id',Session::get('user_id'))->get()->count();

		var_dump(Session::get('user_id'));
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

		return Redirect::to('/DClient');
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
<<<<<<< HEAD

=======
<<<<<<< HEAD
>>>>>>> f1742e31be3f959aa6c76aa1590fc9e0e7d06288
			//$info = $client->metaData('/Public', true);

			//print_r($info['contents']);
			
			$folderMetadata = $client->getMetadataWithChildren("/");
<<<<<<< HEAD
			print_r($folderMetadata);

		foreach ($folderMetadata['body']->contents as $fileObject) {
     	 $fileName = basename($fileObject->path);
      	$fileSize = $fileObject->size;
      	$fullFileName = $fileObject->path;
      	echo('          <li class="fileListItem"><span class="fileImage">&nbsp;</span><span class="fileName">' .
                          $fileName . '</span><span class="fileSize">' . $fileSize . "</span></li>\n");
  }
			//var_dump($clientInfo);
			echo "<br><br>";
			//var_dump($_SERVER);

			return folderMetadata;

=======
print_r($folderMetadata);

			//var_dump($clientInfo);
			echo "<br><br>";
			//var_dump($_SERVER);
=======
			return $client;
>>>>>>> 1257f5784a902b25ab93388723545da0ecea32e5
>>>>>>> f1742e31be3f959aa6c76aa1590fc9e0e7d06288
		} catch(Dropbox\Exception_InvalidAccessToken $e){
			return Redirect::to('/DAuthStart');
		}

	}



}
