

$(document).ready(function(){

    $(".folder").click(function(){
		$(this).next(".subfolder").toggle();
		$(this).prev().toggleClass( 'glyphicon-folder-open', 'glyphicon-folder-close');
		$("input#pathVal").val($(this).attr("id"));
		
	});


	$("#testbtn").click(function(){
		$("input#filepath").val($("input#pathVal").val() + "/" + $("input#filename").val());

	});


	$(document).on("click",".file",function(event) {
		event.preventDefault();
		$(this).next(".transfer").toggle();
		
		$("input#subfilepath").val($(this).attr("id"));

		$("input#subfilename").val($(this).attr("name"));

		var Dpath=$("input#DSFpath").val();
		$.post('/DropboxDownload',
	    {
	        path: Dpath
	        
	    },
	    function(result)
		{
			$("a#DDownloadURL").attr("href", result);
		});
	
	});
	


	$(".fileGDtive").click(function()
	{
		$(this).next(".transfertoDrop").toggle();
		$("input#Gfilepath").val($(this).attr("id"));
		$("input#Gfilename").val($(this).attr("name"));

	})

	$("#Dchoose").click(function(){
		
		$(".dManager").show();
		$(".gManager").hide();
		$("#Dchoose").attr("disabled", true);
		$("#Gchoose").attr("disabled", false);
		

	});
	$("#Gchoose").click(function(){
		
		$(".gManager").show();
		$(".dManager").hide();
		$("#Gchoose").attr("disabled", true);
		$("#Dchoose").attr("disabled", false);
		
	});
	$("#menuDp").click(function(){
		
		$(".dManager").show();
		$(".gManager").hide();
		$("#Dchoose").attr("disabled", true);
		$("#Gchoose").attr("disabled", false);
		

	});
	$("#menuGd").click(function(){
		
		$(".gManager").show();
		$(".dManager").hide();
		$("#Gchoose").attr("disabled", true);
		$("#Dchoose").attr("disabled", false);
		
	});

<<<<<<< HEAD
	$("#Gtestbtn").click(function(){
		alert( $("input#GpathVal").val() + "/" + $("input#Gfilename").val() );
=======
$("#Gtestbtn").click(function(){
>>>>>>> 2be2584b392c58b4cd450660466d10f8dc70484b
		$("input#Gfilepath").val($("input#GpathVal").val() + "/" + $("input#Gfilename").val());
		$("input#Gname").val($("input#Gfilename").val());
	});

<<<<<<< HEAD
	

	$("button#deleteFileDrop").click(function()
	{
		var DelFileDrop=$("input#subfilepath").val();
		$.post('/DelFileDrop',
			{	DropId : DelFileDrop
			},
			function(result)
			{
				alert (result);
			});
		location.reload();
	});
});

$("button#deleteFile").click(function(){

		 var IdDel=$("input#Gfilepath").val();
	    $.post('/Delete',
	    {
	        id: IdDel
	        
	    },

	    function(result){
	        alert(result);
	    });
	    location.reload();
	});

	   
=======
	$(".file").click(function(){
		$(this).next(".transfer").toggle();
		
		$("input#subfilepath").val($(this).attr("id"));

		$("input#subfilename").val($(this).attr("name"));

		var Dpath=$("input#DSFpath").val();
		$.post('/test',
	    {
	        path: Dpath
	        
	    },
	    function(result)
		{
			$("a#DDownloadURL").attr("href", result);
		});

	});
>>>>>>> 2be2584b392c58b4cd450660466d10f8dc70484b
