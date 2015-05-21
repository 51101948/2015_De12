

$(document).ready(function(){

    $(".folder").click(function(){
		$(this).next(".subfolder").toggle();
		$(this).prev().toggleClass( 'glyphicon-folder-open', 'glyphicon-folder-close');
		$("input#pathVal").val($(this).attr("id"));
		
	});

	$("#testbtn").click(function(){
		alert( $("input#pathVal").val() + "/" + $("input#filename").val() );
		$("input#filepath").val($("input#pathVal").val() + "/" + $("input#filename").val());
		alert($("input#filepath").val());
		
	

	});




		$("#DeleteFile").click(function()
	{
		
		

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
});

$("#Gtestbtn").click(function(){
		alert( $("input#GpathVal").val() + "/" + $("input#Gfilename").val() );
		$("input#Gfilepath").val($("input#GpathVal").val() + "/" + $("input#Gfilename").val());
		alert($("input#Gfilepath").val());
		$("input#Gname").val($("input#Gfilename").val());
	});

/*$("button#DDownload").click(function(){
		var Dpath=$("input#pathVal").val() + "/" + $("input#filename").val()
	    $.post('/test',
	    {
	        path: Dpath
	        
	    },
	    function($result)
		{
			$("a#DDownloadURL").attr("href", $result);
		});
});*/

	$(".file").click(function(){
		$(this).next(".transfer").toggle();
		
		$("input#subfilepath").val($(this).attr("id"));

		$("input#subfilename").val($(this).attr("name"));

		var Dpath=$("input#pathVal").val() + "/" + $("input#filename").val();
		
		$.post('/test',
	    {
	        path: Dpath
	        
	    },
	    function($result)
		{
			alert($result);
			$("a#DDownloadURL").attr("href", $result);
		});

	});



/*
	("button#deleteFile").click(function(){
		 var IdDel=$("input#Gfilepath").val();
	    $.post('/Delete',
	    {
	        id: IdDel
	        
	    },
	    function($result)
		{
			alert ($result);
		});
	});*/