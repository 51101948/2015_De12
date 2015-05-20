<?php

class FilesController extends \BaseController {

	private $GClient;
	private $DClient;

	public function __construct(){
		session_start();
		$G = new googleDriveServiceInfo();
		$D = new dropboxServiceInfo();
		$this->DClient = $D->getClient();
		$this->GClient = $G->getClient();
	}

	public function testClient(){
		var_dump($this->DClient);

		echo '<br><br>';
		$fileInfo = $this->dropboxGetFileContent('/Bodokocananhgoc.png','pic.png');
		var_dump($fileInfo);
		echo '<br><br>';
		$f = file_get_contents($fileInfo['localPath']);
		echo $f;
	}


	public function dropboxGetFileContent($dropbox_path, $filename){
		$local_path = base_path('app/'.$filename);
		$fileMetadata = $this->DClient->getFile($dropbox_path, fopen($local_path, "a+"));
		$result=array();
		$result=[
				'mimeType' => $fileMetadata['mime_type'],
				'fileName' => $filename,
				'localPath' => $local_path
				];
		return $result;
	}

}