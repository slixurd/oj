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


//==========================================//
//	登录注册模块
//==========================================//
	var isLogOpen = false;
	var usernameUnique = true;
	var emailUnique = true;
	$('#login').on("click",function(){
		$(".login-popup").fadeToggle("fast");
		isLogOpen = !isLogOpen;
	});
	$(".wrapper").on("click",function(){
		if(isLogOpen){
			$(".login-popup").fadeToggle("fast");
			isLogOpen = !isLogOpen;
		}
	});

	$(".login-popup input").on("click",function(){
		$(".login-popup input").tooltip("hide");
	});
	$(".login-popup").on("click",'.tooltip',function(){
		$(".login-popup input").tooltip("hide");
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
			if(!usernameUnique || !emailUnique ||email.length>50||username.length<3||pass.length<6||pass.length>32||!isEmail(email))
				return false;
			return true;
		})();
		if(pass!=passConf){
			check.preventDefault();
			$("#paconf-status").text("*密码前后不一致");
			$("input#paconf-reg").css({'border-color':"#FA9290"});
			//return false;
		}
		if(!checkit){
			if(!isEmail(email)){
				//$("#email").attr('data-original-title',"邮箱格式错误").tooltip("show");
			}
				//$("#email").attr('data-original-title',"邮箱不能为空").tooltip("show");
				//check.preventDefault();		
			if(pass.length>32){
				$("#paconf-status").text("密码过长");
				check.preventDefault();
				//$("#password").attr('data-original-title','密码不能为空').tooltip("show");
			}
			if(!usernameUnique || !emailUnique){
				check.preventDefault();
			}

		}
	});


//检测用户名是否已经使用
	$("input#username-reg").on("focusout",function(){
		if($("input#username-reg").val().length>=4)
			$.post('check_unique_username',{"username":$("input#username-reg").val()}).done(function(data) {
				var json = eval('(' + data + ')'); 
				if(json.username == 1){
					$("#username-status").text("此用户名已被占用");
					usernameUnique = false;
				}else if(json.username == 0)
					$("#username-status").text("此用户名可以使用");
					usernameUnique = true;
			});
		else if($("input#username-reg").val().length > 0 && $("input#username-reg").val().length < 4){
				$("#username-status").text("用户名含有非法字符或者长度不足4");
				usernameUnique = false;
		}
	});
//检测密码是否匹配
	function checkPass(){
		if($("input#paconf-reg").val().length >= 6 && $("input#pa-reg").val().length >= 6)
			if($("input#paconf-reg").val()!=$("input#pa-reg").val()){
				$("#paconf-status").text("*密码前后不一致");
				$("input#paconf-reg").css({'border-color':"#FA9290"});
			}
			else {
				$("input#paconf-reg").css({'border-color':"#ddd"});
				$("#paconf-status").text("密码匹配成功");
			}
		else if( $("input#pa-reg").val().length < 6　&&　$("input#pa-reg").val().length > 0){
				$("#paconf-status").text("密码长度不足");
				$("input#paconf-reg").css({'border-color':"#FA9290"});
		}
	}
	$("input#paconf-reg").on("focusout",function(){
		checkPass();
	});
	$("input#pa-reg").on("focusout",function(){
		checkPass();
	});
//检测邮箱是否使用
	$("input#email-reg").on("focusout",function(){
		var email = $("input#email-reg").val();
		if(isEmail(email) && email.length > 0){
			$.post('check_unique_email',{"email":$("input#email-reg").val()}).done(function(data) {
				var json = eval('(' + data + ')'); 
				if(json.email == 1){
					$("#email-status").text("此邮箱已被占用");
					emailUnique = false;
				}else if(json.email == 0){
					$("#email-status").text("此邮箱可以使用");
					emailUnique = true;
				}
			});

		}else if(!isEmail(email)&& email.length > 0){
			$("#email-status").text("请输入正确邮箱格式");
		}
		
	});


 			$(function(){$('.i-b').navUnderlineBuild($('.main-nav'));});
	      $(".i-b").css({left:($(".main-nav .active").index()-1)*130+66,width: $(".main-nav .active").width()});
	      console.log();

(function($, undefined) {
	$.fn.extend({
		navUnderlineBuild : function($nav_parent) {

		  if (typeof $nav_parent !== 'object' || typeof $nav_parent.length === 'undefined')
		  	return;

		  var $nav_underline = $(this),
          	$nav = $nav_parent.find('> li'),
          	index = $nav_parent.find('.active').index()-1;
		  //处理下划线移动
	      var underlineMove = function(i){
	        var tmp_width = $nav.eq(i).width(),
	            position = $nav.eq(i).position(),
	            move_time = 500;
	        $nav_underline.animate({left:position.left, width: tmp_width}, move_time);
	      }
	      //无法获取此处的宽度,$(".main-nav > span").width()
	      //导航点击监听
	      $('.main-nav').delegate('li','mouseover', function(){
	        if($nav_underline.is(":animated")){ $nav_underline.stop(); }
	        underlineMove($nav.index($(this)));
	        return false;
	      }).mouseleave(function(){
	        if($nav_underline.is(":animated")){ $nav_underline.stop(); }
	        underlineMove(index);
	      });
	    }
	});
})(jQuery);	


	
});


