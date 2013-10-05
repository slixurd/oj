$(document).ready(function(){
	$("#search-method > ul > li").on('click',function(){
		$("#search-method > span").text($(this).children("span").text());
		$(".search-wrapper > input").prop('name',$(this).children("span").prop('class'));
	});

	var sel=$(".table-sel select");
	var result=$(".sel-title");
	var x;
	sel.on('change',function(){
		var opt=$("option");
		var len=opt.length;
		for(i=0;i<len;i++){
			if(opt[i].selected==true){
				x=$(opt[i]).text();
			}
		}
		result.text(x);
	})

});