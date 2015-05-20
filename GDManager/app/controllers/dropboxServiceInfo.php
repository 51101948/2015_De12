<?php

class dropboxServiceInfo extends BaseController {

	private $webAuth;
	private $appInfo;
	private $appName;
	private $csrfTokenStore;
	public function token()
  {
    return csrf_token();
  }



	public function __construct(){	
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


			


			



			return $client;
			//return $folderMetadata;

			/*			print_r($folderMetadata);

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
			*/	

>>>>>>> 06ea9990bc7861d453cf888cbf9033f0fe0f3bd1
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
			//return Redirect::to('/DClient');

			
			Redirect::to('/DClient');
		}
		catch(Dropbox\Exception_InvalidAccessToken $e){
			return Redirect::to('/DAuthStart');
		}

	}

	public function downloadFile(){
		$info = DBoxInfo::where('user_id',Session::get('user_id'))->get()->first();
		$count = DBoxInfo::where('user_id',Session::get('user_id'))->get()->count();
		$client = new Dropbox\Client($info->token, $this->appName, 'UTF-8');
			$fileMetadata = $client->getFile("/Test1/FileRac.txt", fopen(base_path('app/filerac.txt'), "a+"));
			print_r($fileMetadata);
	}



}
