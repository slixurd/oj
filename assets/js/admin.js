//判断是否为闰年
function isLeapYear(year) {
	return ((year % 4 === 0 && year % 100 != 0) || year % 400 === 0);
}

//根据年份月份判断最大的日期是多少
function maxDate(year,month) {
	switch(month) {
		case 1:
		case 3:
		case 5:
		case 7:
		case 8:
		case 10:
		case 12: {
			return 31;
		}

		case 4:
		case 6:
		case 9:
		case 11: {
			return 30;
		}

		case 2: {
			if(isLeapYear(year)) {
				return 29;
			}else {
				return 28;
			}
		}
		default:;
	}
}

//自动加载合适日期的函数
function loadDate(year,month,select_date) {
	select_date.empty();
	for(var i = 1;i <= maxDate(year,month);i++) {
		select_date.append('<option value='+i+'>'+i+'</option>');
	}
}

$(function() {

	compat_layout();
	if(navigator.appName.toLowerCase() == 'microsoft internet explorer')
		cancel_check();
//绑定表单提交验证
	$('form').bind('submit',check_ness);
	$('form').bind('submit',check_students);
	$('form').bind('submit',check_num);
	$('form').bind('submit',check_pwd);
	$('form').bind('submit',check_box);

	$('input[type="text"],input[type="password"],textarea[id!="students"]').bind('keydown', function(event) {
		if(event.shiftKey) {
			$(this).next('i.popTip').fadeOut('slow', function() {
				$(this).next('i.popTip').remove();
			});
			return;
		}
		var charCode = event.keyCode;
		if(charCode == 32 || 
			(charCode >= 48 && charCode <= 57) || 
			(charCode >= 65 && charCode <= 90) || 
			(charCode >= 97 && charCode <= 122)){
			$(this).next('i.popTip').fadeOut('slow', function() {
				$(this).next('i.popTip').remove();
			});
		}

		var id = $(this).parents('.tab-pane')[0].id;
		var nav_tab = $('a[rel="#' + id + '"]').parent();
		$(nav_tab[0]).next('i.popTip').fadeOut('slow', function() {
			$(nav_tab[0]).next('i.popTip').remove();
		});
	});

//载入时间控件

	//首先载入年份与月份以及日期
	for(var i = 2000;i <= 2100;i++) {
		$('select.year').append('<option value='+i+'>'+i+'</option>');
	}
	for(var i = 1;i <= 12;i++) {
		$('select.month').append('<option value='+i+'>'+i+'</option>');
	}

	//加载时间并自动选择当前时间
	var now = new Date();
	loadDate(now.getFullYear(),now.getMonth()+1,$('select.date'));
	for(var i = 0;i <= 23;i++) {
		$('select.hour').append('<option value='+i+'>'+i+'</option>');
	}
	for(var i = 1;i <= 59;i++) {
		$('select.minute').append('<option value='+i+'>'+i+'</option>');
	}
	$('select.year option[value='+now.getFullYear()+']').attr('selected','true');
	$('select.month option[value='+(now.getMonth()+1)+']').attr('selected','true');
	$('select.date option[value='+now.getDate()+']').attr('selected','true');
	$('select.hour option[value='+now.getHours()+']').attr('selected','true');
	$('select.minute option[value='+now.getMinutes()+']').attr('selected','true');
	$('span.select-down-span.year').html(now.getFullYear()+' 年<i class="down"></i>');
	$('span.select-down-span.month').html(now.getMonth()+1+' 月<i class="down"></i>');
	$('span.select-down-span.date').html(now.getDate()+' 日<i class="down"></i>');
	$('span.select-down-span.hour').html(now.getHours()+' 时<i class="down"></i>');
	$('span.select-down-span.minute').html(now.getMinutes()+' 分<i class="down"></i>');



//实现下拉列表动作
	$("div.select-down > select.select-down-select").change(function() {
		var value = this.value;
		var text = $(this).find("option[value="+value+"]").text();
		$(this).siblings("span.select-down-span").text(text)
		.append("<i class='down'></i>").removeClass("placeholder");
	})

//实现选项卡点击切换动作
	$("ul.nav-tabs > li").click(function() {
		$(this).addClass("active").siblings().removeClass("active");
		var targetPane = $(this).children(":first").attr("rel");
		$(targetPane).addClass("active").siblings().removeClass("active");
	})

//年份改变时对日期作相应的更新（平年闰年切换时有必要）
	$('select.year').change(function() {
		var year = parseInt($(this).val());
		var month = parseInt($(this).parent().siblings().children('select.month').val());
		var select_date = $(this).parent().siblings().children('select.date');
		var date_old = select_date.val();
		loadDate(year,month,select_date);
		var date_max = maxDate(year,month);
		if(date_old > date_max) {
			$(this).parent().siblings().children('span.date')
			.html('1 日<i class="down"></i>');
		}else {
			select_date.children('option[value='+date_old+']').attr("selected","true");
		}
	})

//月份改变时对日期作相应的更新
	$('select.month').change(function() {
		var year = parseInt($(this).parent().siblings().children('select.year').val());
		var month = parseInt($(this).val());
		var select_date = $(this).parent().siblings().children('select.date');
		var date_old = select_date.val();
		loadDate(year,month,select_date);
		var date_max = maxDate(year,month);
		if(date_old > date_max) {
			$(this).parent().siblings().children('span.date')
			.html('1 日<i class="down"></i>');
		}else {
			select_date.children('option[value='+date_old+']').attr("selected","true");
		}
	})

//点击改变checkbox背景
	$('input[type="checkbox"]').change(function() {
		if($(this).prop('checked') == true || $(this).prop('checked') == "checked") {
			$(this).parent().css('background', 'url("img/right.jpg") no-repeat 3px 6px');
		}else {
			$(this).parent().css('background', 'white');
		}
	});

//表单重置时触发checkbox的change事件（以便去掉背景）
	$('form').bind('reset', function() {
		$(this).find('input:checked').prop('checked', false).trigger('change');
	});

//触发file的点击事件
	$('a#excel').click(function() {
		$('input[type="file"]#excel').trigger('click');
	});

//将选择的文件名呈现在input中
	$('input[type="file"]#excel').change(function() {
		var file = $(this).val();
		var fileNames = file.split('\\');
		var fileName = fileNames[fileNames.length - 1];
		$('input[type="text"]#excel').val(fileName);
	});
})

//检验checkbox是否至少选中一个
function check_box() {
	if($('input[type="checkbox"]').length > 0 && 
		$('input[type="checkbox"][checked="checked"]').length == 0) {
		$('table').siblings('i.popTip').remove();
		popTip($('table')[1],'请至少选择一个选项','top');
		return false;
	}
	return true;
}


//验证密码两次输入的一致性
function check_pwd() {
	if($('#pwd')[0] && $('#conf')[0]) {
		var pwd = $('#pwd').val(),conf = $('#conf').val();
		var regPwd = /^[\x00-\x7F]*$/; //检验密码只含ASCII字符
		if(pwd !== conf) {
			$('#pwd').siblings('i.popTip').remove();
			$('#conf').siblings('i.popTip').remove();
			popTip($('#pwd')[0],'密码输入不一致','top','permanent');
			popTip($('#conf')[0],'密码输入不一致','top','permanent');
			return false;
		}else {
			if(pwd.length < 6 || pwd.length > 16) {
				$('#pwd').siblings('i.popTip').remove();
				$('#conf').siblings('i.popTip').remove();
				popTip($('#pwd')[0],'密码长度须为6-16位','top','permanent');
				popTip($('#conf')[0],'密码长度须为6-16位','top','permanent');
				return false;
			}
		}
	}
	$('#pwd').siblings('i.popTip').remove();
	$('#conf').siblings('i.popTip').remove();
	return true;
}

//验证input，textarea必填域是否已填写
function check_ness() {
	var ness = $('input[type="text"],input[type="password"]'),rev = true;
	for(var i = 0;i < ness.length;i++) {
		if(ness[i].value === '' && ness[i].id != 'excel') {
			$(ness[i]).siblings('i.popTip').remove();
			popTip(ness[i],'此项必须填写','top','permanent');
			rev = false;
		}
	}

	ness = $('textarea[id!="students"]');
	for(var i = 0;i < ness.length;i++) {
		if($(ness[i]).val()=='') {
			if($(ness[i]).parents('.tab-pane').length==0) {
				$(ness[i]).siblings('i.popTip').remove();
				popTip(ness[i],'此项必须填写','top','permanent');
				rev = false;
			}else {
				var id = $(ness[i]).parents('.tab-pane')[0].id;
				var nav_tab = $('a[rel="#' + id + '"]').parent();
				$(nav_tab[0]).next('i.popTip').remove();
				popTip(nav_tab[0],'此项必填','top','permanent');
			}
		}
	}
	return rev;
}

//验证是否有学生名单
function check_students() {
	if($('#students')[0] && $('#excel')[0]) {
		if($('#students').val() === '' && $('#excel').val() === '') {
			if($('#students').parent().siblings('i.popTip').length==0) {
				$('#students').siblings('i.popTip').remove();
				popTip($('#students')[0].parentNode,'未导入学生名单','top','permanent');
			}
			return false;
		}

		var regE = /^((\d{12}[ \t(\r\n)]+)+)$/;
		//var str = $('#students').val().trim() + ' ';
		var str = $.trim($('#students').val()) + ' ';
		if(!regE.test(str)) {
			$('#students').parent().siblings('i.popTip').remove();
			popTip($('#students')[0],'学生名单格不正确','top','permanent');
			return false;
		}else {
			$('#students').siblings('i.popTip').remove();
			$('#students').parent().siblings('i.popTip').remove();
		}
	}
	return true;
}

//验证内存和时间限制输入必须为正整数
function check_num() {
	var rev = true;
	if($('#memory-limit')[0] && $('#time-limit')[0]) {
		if(+($('#memory-limit').val())) {
			if(+($('#memory-limit').val()) < 0) {
				$('#memory-limit').next('i.popTip').remove();
				popTip($('#memory-limit')[0],'请填写正整数','top','permanent');
				rev = false;
			}
		}else if($('#memory-limit').val()=='') {
			rev = false;
		}else {
			$('#memory-limit').next('i.popTip').remove();
			popTip($('#memory-limit')[0],'请填写正整数','top','permanent');
			rev = false;
		}

		if(+($('#time-limit').val())) {
			if(+($('#time-limit').val()) < 0) {
				$('#time-limit').next('i.popTip').remove();
				popTip($('#time-limit')[0],'请填写正整数','top','permanent');
				rev = false;
			}
		}else if($('#time-limit').val()=='') {
			rev = false;
		}else {
			$('#time-limit').next('i.popTip').remove();
			popTip($('#time-limit')[0],'请填写正整数','top','permanent');
			rev = false;
		}
	}
	return rev;

}

//在obj元素旁边弹出提示框
function popTip(obj,str) {
	var parent,tip,position,permanent,BROWER;
	switch(navigator.appName.toLowerCase()) {
		case 'netscape':
			BROWER = 'ns';
		break;
		case 'microsoft internet explorer':
		default:
			BROWER = 'ie';
		break;
	}
	position = arguments[2] ? arguments[2] : 'top';
	permanent = arguments[3] ? arguments[3] : 'temp';
	parent = obj.parentNode.tagName.toLowerCase() == 'html' ? 'body' : obj.parentNode;
	parent = $(parent);
	tip = $('<i class="popTip"></i>');
	if(parent.css('position').toLowerCase() == 'static')
		parent.css('position', 'relative');
	tip.fadeoutStep = 10;
	tip.currentStep = tip.fadeoutStep;
	tip.fadeTime = 3000;
	tip.opacity = 0.6;
	tip.max_width = $(obj).innerWidth();
	if(permanent == 'permanent') {
		tip.showTime = 9000000;
	}else {
		tip.showTime = 2000;
	}

	tip.myFadeout = function() {
		if(tip.currentStep > tip.fadeTime) {
			clearTimeout(tip.fadeTimer);
			tip.remove();
			parent.css('position','static');
		}else {
			tip.fadeTo(tip.fadeoutStep, tip.opacity-tip.currentStep/tip.fadeTime, function() {
				tip.currentStep += tip.fadeoutStep;
			});
			if(tip.fadeTimer) clearTimeout(tip.fadeTimer);
			tip.fadeTimer = setTimeout(tip.myFadeout,tip.fadeoutStep);
		}
	}

/////////////////////////////////
/////////////////////////////////

	tip.text(str);
	tip.css({
		'background': 'black',
		'color': 'white',
		'position': 'absolute',
		'font-size': '14px',
		'max-width': tip.max_width - 10 + 'px',
		'opacity': tip.opacity,
		'border-radius': '4px',
		'padding': '0 5px',
		'display': 'none',
		'line-height': '1.5em',
		'z-index': '10000'
	});
	tip.insertAfter($(obj));
	tip.append(tip.pointer);

	switch(position) {
		case 'top': {
			tip.left = obj.offsetLeft + (obj.offsetWidth-tip.innerWidth())/2;
			
			tip.top = obj.offsetTop + (obj.offsetHeight - tip.innerHeight())/2;
			tip.css({
				'left': tip.left + 'px',
				'top': tip.top + 'px'
			});
		}break;
		default: {
		}
	}
/******************************************************/
	tip.close = $('<i class="close"></i>');

	tip.close.css({
		'display': 'block',
		'width': '256px',
		'height': '256px',
		'opacity': tip.opacity,
		'background': 'url("img/close.png") no-repeat',
		'position': 'absolute',
		'left': -256/2 + tip.innerWidth() + 'px',
		'top': -256/2 + 'px'
	});

	switch(BROWER) {
		case 'ns': {
			tip.close.css({
				'-webkit-transform': 'scale(0.08)',
				'-moz-transform': 'scale(0.08)',
				'-ms-transform': 'scale(0.08)',
				'-o-transform': 'scale(0.08)',
				'transform': 'scale(0.08)'
			});
		}break;
		case 'ie':
		default: {
			tip.close.css({
				'zoom': '0.08',
				'width': '20px',
				'height': '20px',
				'left': tip.innerWidth()/0.08 + 'px',
				'top': '0'
			});

			tip.css('padding-right', '30px');
		}break;
	}

	tip.append(tip.close);

	switch(BROWER) {
		case 'ns': {
			tip.close.bind('mouseout', function(event) {
				tip.close.css('opacity', tip.opacity);
			});

			tip.close.bind('mouseover', function(event) {
				tip.close.css('opacity', '1');
			});
		}break;
		case 'ie':
		default: {
			tip.close.bind('mouseout', function(event) {
				tip.close.css({
					'opacity': tip.opacity,
					'zoom': '0.08'
				});
			});

			tip.close.bind('mouseover', function(event) {
				tip.close.css({
					'opacity': '1',
					'zoom': '0.08'
				});
			});
		}break;
	}

	tip.close.bind('click', function(event) {
		clearTimeout(tip.fadeTimer);
		tip.fadeOut('fast', function() {
			tip.remove();
		});
	});
/******************************************************/
	
	tip.fadeIn(tip.fadeTime);
	if(tip.fadeTimer) clearTimeout(tip.fadeTimer);
	tip.fadeTimer = setTimeout(tip.myFadeout,tip.showTime);

	if(permanent != 'permanent') {
		tip.bind('mouseover', function(event) {
			if(tip.fadeTimer) {
				clearTimeout(tip.fadeTimer);
			}
			tip.fadeTo(tip.currentStep, tip.opacity, function() {
				tip.currentStep = tip.fadeoutStep;
			});
		});

		tip.bind('mouseout', function(event) {
			if(tip.fadeTimer) {
				clearTimeout(tip.fadeTimer);
				tip.fadeTimer = setTimeout(tip.myFadeout,tip.showTime);
			}
		});
	}
}

function getTop(obj) {
	var parent = obj,top = obj.offsetTop;
	while(parent = parent.offsetParent) {
		top += parent.offsetTop;
	}
	return top;
}

function getLeft(obj) {
	var parent = obj,left = obj.offsetLeft;
	while(parent = parent.offsetParent) {
		left += parent.offsetLeft;
	}
	return left;
}

function compat_layout() {
	var BROWER = navigator.appName.toLowerCase();
	switch(BROWER) {
		case 'netscape':
			BROWER = 'ns';
		break;
		case 'microsoft internet explorer':
		default: 
			BROWER = 'ie';
		break;
	}
	switch(BROWER) {
		case 'ns': {

		}break;
		case 'ie':
		default: {
			var inputs = $('input[type="text"],input[type="password"]');
			for(var i = 0;i < inputs.length;i++) {
				$(inputs[i]).css('line-height', $(inputs[i]).innerHeight()+'px');
			}

			var selects = $('select');
			for(var i = 0;i < selects.length;i++) {
				$(selects[i]).css('opacity', '0');
			}

			var checkboxs = $('input[type="checkbox"]');
			for(var i = 0;i < checkboxs.length;i++) {
				$(checkboxs[i]).css('opacity', '0');
			}
		}
	}
}

//刷新网页后取消所有的checkbox的checked，以免产生bug
function cancel_check() {
	$('input[type="checkbox"]').removeAttr('checked');
}
