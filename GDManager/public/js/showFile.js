

$(document).ready(function(){

    $(".folder").click(function(){
		$(this).next(".subfolder").toggle();
		$(this).prev().toggleClass( 'glyphicon-folder-open', 'glyphicon-folder-close');
		$("input#pathVal").val($(this).attr("id"));
	});

	$("#testbtn").click(function(){
		alert( $("input#pathVal").val() + "/" + $("input#filename").val() );
		//alert($("input#filename").mozFullPath);
		var tmpPath = URL.createObjectURL();
		alert(tmpPath);
		var data = { path: $("input#pathVal").val() + "/" + $("input#filename").val() };
		 $.ajax({
        type: 'POST',
        url: '/DClient',
        data: data,
        success: function(data){
            alert('successful');
        	location.reload();
        }

	});

});
	});