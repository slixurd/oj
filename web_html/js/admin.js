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

//载入日期（时间）输入控件
function loadTimeWidget() {
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
}

//实现下拉列表动作
function doSelect() {
	$("div.select-down > select.select-down-select").change(function() {
		var value = this.value;
		var text = $(this).find("option[value="+value+"]").text();
		$(this).siblings("span.select-down-span").text(text)
		.append("<i class='down'></i>").removeClass("placeholder");
	})
}

//自定义弹出提示框
function myPopover($obj,str,place) {
	str = arguments[1] ? arguments[1] : '';
	place = arguments[2] ? arguments[2] : 'right';
	$obj.attr({
		'data-content': str,
		'data-placement': place
	});
	$obj.popover('show');
	setTimeout(destroyPop($obj),3000);
}

//销毁弹出对象
function destroyPop($obj) {
	$obj.popover('destroy');
}


//验证密码两次输入的一致性
function check_pwd() {
	if($('#pwd')[0] && $('#conf')[0]) {
		var pwd = $('#pwd').val(),conf = $('#conf').val();
		var regPwd = /^[\x00-\x7F]*$/; //检验密码只含ASCII字符
		if(pwd !== conf) {
			myPopover($('#pwd'),'密码输入不一致');
			myPopover($('#conf'),'密码输入不一致');
			return false;
		}else {
			if(pwd.length < 6 || pwd.length > 16) {
				myPopover($('#pwd'),'密码长度须为6-16位');
				myPopover($('#conf'),'密码长度须为6-16位');
				return false;
			}
		}
	}
	return true;
}

//验证input，textarea必填域是否已填写
function check_ness() {
	var ness = $('.necessary'),rev = true;
	for(var i = 0;i < ness.length;i++) {
		if(ness[i].value.length == 0) {
			if($(ness[i]).parents('.tab-pane').length==0) {
				myPopover($(ness[i]),'此项必须填写','top');
				rev = false;
			}else {
				var id = $(ness[i]).parents('.tab-pane')[0].id;
				var nav_tab = $('a[rel="#' + id + '"]').parent();
				myPopover($(nav_tab[0]),'此项必须填写','top');
				rev = false;
			}
		}
	}
	return rev;
}

//验证是否有学生名单
function check_students() {
	if($('#students')[0] && $('#excel')[0]) {
		if($('#students').val().length > 0) {
			var regE = /^((\d{12}[ \t(\r\n)]+)+)$/;
			var str = $.trim($('#students').val()) + ' ';
			if(!regE.test(str)) {
				var id = $('#students').parents('.tab-pane')[0].id;
				var nav_tab = $('a[rel="#' + id + '"]').parent();
				myPopover($(nav_tab[0]),'学生名单格不正确','top');
				return false;
			}else {
				return true;
			}
		} else {
			if($('#excel').val().length > 0) {
				return true;
			} else {
				var id = $('#excel').parents('.tab-pane')[0].id;
				var nav_tab = $('a[rel="#' + id + '"]').parent();
				myPopover($(nav_tab[0]),'未导入学生名单','top');
				return false;
			}
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
				myPopover($('#memory-limit'),'请填写正整数','top');
				rev = false;
			}
		}else if($('#memory-limit').val()=='') {
			rev = false;
		}else {
			myPopover($('#memory-limit'),'请填写正整数','top');
			rev = false;
		}

		if(+($('#time-limit').val())) {
			if(+($('#time-limit').val()) < 0) {
				myPopover($('#time-limit'),'请填写正整数','top');
				rev = false;
			}
		}else if($('#time-limit').val()=='') {
			rev = false;
		}else {
			$('#time-limit').next('i.popTip').remove();
			myPopover($('#time-limit'),'请填写正整数','top');
			rev = false;
		}
	}
	return rev;

}

//确认两次ID输入一致
function checkIdInput() {
	var user = $('#user').val();
	var conf = $('#conf').val();
	if(user !== conf) {
		myPopover($('#user'),'ID输入不一致','top');
		myPopover($('#conf'),'ID输入不一致','top');
		return false;
	}
	return true;
}

//某些布局在IE不兼容，用JS强制兼容
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

			/*
			var selects = $('select');
			for(var i = 0;i < selects.length;i++) {
				$(selects[i]).css('opacity', '0');
			}
			*/
			var checkboxs = $('input[type="checkbox"]');
			for(var i = 0;i < checkboxs.length;i++) {
				$(checkboxs[i]).css('opacity', '0');
			}
		}
	}
}

//刷新网页或者加载网页时正确加载checkbox背景
function checkBox() {
	var $checkboxs = $('[type="checkbox"]');
	for(var i = 0;i < $checkboxs.length;i++) {
		if($($checkboxs[i]).prop('checked') == 'checked' ||
			$($checkboxs[i]).prop('checked') == true) {
			$($checkboxs[i]).parent().addClass('checked');
		}
	}
}

//加载题目的初始状态
function loadStatus() {
	var tds = $($('table')[0]).find('tbody td:first-child');
	var trs = $($('table')[1]).find('tbody tr');
	var td;
	$.each(trs, function(index1) {
		$.each(tds, function(index2) {
			 if($(trs[index1]).children('td:first').text() == $(tds[index2]).text()) {
			 	$(trs[index1]).find(':checkbox').prop('checked', 'checked');
			 	$(trs[index1]).find('.checkbox').addClass('checked');
			 }
		});
	});
}

//动态删减添加助教输入框
function fitAssistant() {
	$('body').on('keyup', '[name*="assistant"]', function(event) {
		if(this.preStatus == undefined) this.preStatus = true;
		var charCode = event.keyCode;
		if( event.shiftKey ||
			charCode == 32 || charCode == 8 ||
			(charCode >= 48 && charCode <= 57) || 
			(charCode >= 65 && charCode <= 90) || 
			(charCode >= 97 && charCode <= 122)){
			if(this.preStatus && $(this).val().length > 0) {
				var $newRow = $(this).parents('.row').clone();

				$newRow.css('display', 'none');

				$newRow.find('input').val('');
				$newRow.find('input')[0].preStatus = undefined;
				$newRow.insertAfter($(this).parents('.row'));

				//$newRow.fadeIn(1000);
				$newRow.slideDown('slow');

				$newRow.nextAll('.row').next('.popTip').remove().end().find('.popTip').remove();

				this.preStatus = false;
			}
			if(!this.preStatus && $(this).val().length == 0) {
				if($(this).parents('.row').next('.row').find('input').val().length == 0) {
					//$(this).parents('.row').next('.row').remove();
					$(this).parents('.row').next('.row').slideUp('slow', function() {
						$(this).remove();
					});

					this.preStatus = true;
				}
			}
		}
	});
}

//调整助教输入框的name属性
function adapt_name() {
	var $assis = $('[name*="assistant"]');
	var app = 0;
	for(var i = 0;i < $assis.length;i++) {
		if($.trim($assis[i].value).length > 0) {
			$($assis[i]).attr('name','assistant' + app);
			app++;
		} else {
			$($assis[i]).removeAttr('name');
		}
	}
	$('#assis-count').val(app);
	return true;
}

//选项卡切换函数
function switch_tab() {
	$(this).addClass("active").siblings().removeClass("active");
	var targetPane = $(this).children(":first").attr("rel");
	$(targetPane).addClass("active").siblings().removeClass("active");
	$(targetPane).find('textarea:first').focus();
}

function load_tab() {
	$(".nav-tabs > li").bind('click',switch_tab);
}


//闪烁input边框，right=true时ID存在
function blink_border($input,right) {
	if(right) {
		$input.addClass('correct');
	} else {
		$input.addClass('error');
	}
	setTimeout(function() {
		$input.removeClass('correct');
		$input.removeClass('error');
	},500);
}


$(function() {
	//compat_layout();
})