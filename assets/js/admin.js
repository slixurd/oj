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
//载入时间控件

	//首先载入年份与月份以及日期
	for(var i = 2000;i <= 2100;i++) {
		$('select.year').append('<option value='+i+'>'+i+'</option>');
	}
	for(var i = 1;i <= 12;i++) {
		$('select.month').append('<option value='+i+'>'+i+'</option>');
	}
	var now = new Date();
	loadDate(now.getFullYear(),now.getMonth()+1,$('select.date'));

	//加载时间并自动选择当前时间
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

//实现列表option连接跳转


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
})