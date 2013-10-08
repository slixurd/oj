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

	$('#login').on("click",function(){
		$(".login-popup").fadeToggle("fast");
	});

	function isEmail(val) {
		var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
		return reg.test(val);
	}

	$("#submit-reg").on('click',function(check){
		var email = $("input#email-reg").val();
		var pass = $("input#pa-reg").val();
		var passConf = $("input#paconf-reg").val();
		var username = $("input#username-reg").val();
		var checkit=(function(){
		    if(email.length>50||username.length<3||pass.length<6||pass.length>32||!isEmail(email))
		    	return false;
		    return true;
		})();
		if(pass!=passConf){
			check.preventDefault();
			return false;
		}
		if(!checkit){
			if(!isEmail(email)){
				//$("#email").attr('data-original-title',"邮箱格式错误").tooltip("show");
			}
			if(email.length==0){
				//$("#email").attr('data-original-title',"邮箱不能为空").tooltip("show");
			}			
			if(pass.length==0){
				//$("#password").attr('data-original-title','密码不能为空').tooltip("show");
			}else if(pass.length<6){
				//$("#password").attr('data-original-title','密码过短').tooltip("show");
			}else if(pass.length>32){
				//$("#password").attr('data-original-title','密码过长').tooltip('show');
			}
			check.preventDefault();
		}
	});

	$("input#username-reg").on("focusout",function(){
		$.post('/scutoj/index.php/user/check_unique_username',{"username":$("input#username-reg").val()}).done(function(data) {
		  var json = eval('(' + data + ')'); 
		  if(json.username == 1){
		  	$("#username-status").text("此用户名已被占用");
		  }else if(json.username == 0)
		  	$("#username-status").text("此用户名可以使用");
		});
	});
	$("input#email-reg").on("focusout",function(){
		$.post('/scutoj/index.php/user/check_unique_email',{"email":$("input#email-reg").val()}).done(function(data) {
		  var json = eval('(' + data + ')'); 
		  if(json.email == 1){
		  	$("#email-status").text("此邮箱已被占用");
		  }else if(json.email == 0)
		  	$("#email-status").text("此邮箱可以使用");
		});
	});

});