

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
		//alert($("input#filename").mozFullPath);
		//var tmpPath = URL.createObjectURL();
		//alert(tmpPath);
		/*var data = { path: $("input#pathVal").val() + "/" + $("input#filename").val() };
		 $.ajax({
        type: 'POST',
        url: '/DClient',
        data: data,
        success: function(data){
            alert('successful');
        	location.reload();
        }
*/
	

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
});

$("#Gtestbtn").click(function(){
		alert( $("input#GpathVal").val() + "/" + $("input#Gfilename").val() );
		$("input#Gfilepath").val($("input#GpathVal").val() + "/" + $("input#Gfilename").val());
		alert($("input#Gfilepath").val());
		$("input#Gname").val($("input#Gfilename").val());
	});

