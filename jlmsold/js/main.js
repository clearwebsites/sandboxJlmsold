$(document).ready(function(){
	// $(function() {
	//     $( "#menu" ).menu();
	//   });
	$("#addAnother").click(function(){
		var e=$("input");
			e=e.length;
		var t="image"+e;
		$('<li><input type="file" name='+t+' class="file" ></li>').appendTo(".image")
	})
})