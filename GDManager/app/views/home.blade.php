
<?php include (base_path('app/views/header.blade.php')); ?>

<div class="content">
	<div class="section">
		<div class="gManager">						
		</div>
		<div class="dManager">
			<div>
				Path: 
				<input  id="pathVal" type = "text">
			</div>
			<ul>
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



    		</ul>

    		
			<form method="post" name="submit" enctype="multipart/form-data">
			  <input type="file" id="filename" name="fileField" style="display: inline-block">
			  <button type="button" id="testbtn" name="submit">Upload</button>
			</form>
		</div>					
	</div>


	<div class="preview">
			<embed src="https://www.dropbox.com/home?preview=MT11KH1_KSK.pdf" width="700" height="700">
	</div>
</div>

<?php include (base_path('app/views/footer.blade.php'));
 ?>
