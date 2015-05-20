
<?php include (base_path('app/views/header.blade.php')); ?>

<div class="content">
	<div class="section">
		<div class="selection">
			Choose: &nbsp; &nbsp;
			<button id="Dchoose" class="btn btn-lg btn-primary">DManager</button>
			<button id="Gchoose" class="btn btn-lg btn-primary">GManager</button>
		</div>
		<hr>
		<div class="gManager">
		<div>
				Path: 
				<input  id="GpathVal" type = "text">
			</div>
		@if(isset($Gclient))
			<?php
					function showGFolder($Gclient, $id){					
						$children = $Gclient->children->listChildren($id, array());
						$items = $children['items'];
						foreach ($items as $item) {
							$params = array();
							$data;
							$Item_id=$item['id'];
							$file = $Gclient->files->get($Item_id, $params);
							$mimeType = $file->getMimeType();


							if($mimeType === 'application/vnd.google-apps.folder'){
								?>
								<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> 
								&nbsp; &nbsp; &nbsp;<a class="folder" > {{ $file->getTitle().'<br>'  }} </a>
								<div class="subfolder" >
								<?php

								showGFolder($Gclient, $Item_id);
								?>
								</div>
								<?php
							}
							else{
							?>
								
								<span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp; &nbsp; &nbsp;<a class="file"  href="#"> {{ $file->getTitle().'<br>' }}</a> 
							<?php
							}
						}
					}

				?>
			<?php showGFolder($Gclient, 'root'); ?>
		@endif				

		<form method="post" action="/GUpload" name="submit" enctype="multipart/form-data">
			  <input type="file" id="Gfilename" name="GfileField" style="display: inline-block">
			  <input type="text" id="Gfilepath" name="Gpath" style="display: none" >
			  <input type="text" id="Gname" name="Gname" style="display: none" >
			  <button type="submit" id="Gtestbtn" name="submit">Upload</button>
		</form>
				
					
		</div>
		<div class="dManager">
			<div>
				Path: 
				<input  id="pathVal" type = "text">
			</div>
			<div>
				@if(isset($client))
				<?php
					function showFolder($content, $client, $x,$y){					
					
					if($content['is_dir']){				
				?>			
				
					<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> 				

    &nbsp; &nbsp; &nbsp;<a class="folder" id={{ $content['path'] }}> {{ substr($content['path'].'<br>', $x+1)  }} </a>

				<?php
					$x =  strlen($content['path']);
					$y=$content['path'];
					$subfolder = $client->getMetadataWithChildren($content['path']);
				?>

					<div class = "subfolder" style ="display:none">						
						@foreach($subfolder['contents'] as $subcontent )
						 	<?php
							 showFolder($subcontent, $client, $x,$y);
							 ?>						
						@endforeach
					</div>					
				<?php
					}
					else{
				?>
						<span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp; &nbsp; &nbsp;<a class="file"  href="#"> {{ substr($content['path'].'<br>', $x+1) }}</a> 
				<?php
					}
					 
				}
				?>					
				
				<?php $folderMetadata = $client->getMetadataWithChildren("/");  ?>
					@foreach($folderMetadata['contents'] as $content)
						<?php
						$x = 0; 
						$y="$";
						showFolder($content, $client, $x,$y); ?>

					@endforeach


					@endif
    		</div>

    		
			<form method="post" action="/DClient" name="submit" enctype="multipart/form-data">
			  <input type="file" id="filename" name="fileField" style="display: inline-block">
			  <input type="text" id="filepath" name="path" style="display: none" >
			  <button type="submit" id="testbtn" name="submit">Upload</button>
			</form>
		</div>					
	</div>


	<div class="preview">
			<embed src="http://faculty.ksu.edu.sa/metwally/IS%20335/Elm04_14.pdf" width="700" height="700">
	</div>
</div>

<?php include (base_path('app/views/footer.blade.php'));
 ?>
