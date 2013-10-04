$(document).ready(function(){
	$("#search-method > ul > li").on('click',function(){
		$("#search-method > span").text($(this).children("span").text());
		$(".search-wrapper > input").prop('name',$(this).children("span").prop('class'));
	});

});