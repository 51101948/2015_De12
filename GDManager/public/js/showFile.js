

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

	$(".file").click(function(){
		$(this).next(".transfer").toggle();
	});
});
