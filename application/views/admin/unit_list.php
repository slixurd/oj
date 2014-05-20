    <div class="add-tab pull-right">
        <style type="text/css">
            div.course-detail{
                margin-bottom: 25px;
                margin-top: 0;
                padding:15px 10px;
            }
            div.course-detail #i-title{
                color: #38b3ff;
                font-size: 28px;
                margin-bottom: 10px;
            }
            div.course-detail .sitem div{
                display: inline-block;
                line-height: 35px;

            }
            .sitem{width: 620px;;border-bottom: 1px solid #DDD;}
            .stitle{
                display: inline-block;
                width: 100px;
            }
        </style>
        <div class="course-detail">
            <div id="i-title"><?php echo $cdetail['courseName'] ?></div>
            <div class="sitem">
                <div class='stitle'>有效期</div>
                <div>
                    <span id="i-stime"><?php echo $cdetail['startTime'] ?></span>
                    至
                    <span id="i-etime"><?php echo $cdetail['endTime'] ?></span>
                </div>
            </div>
            <div class="sitem">
                <div class='stitle'>private</div>
                <div id="i-pri"><?php if($cdetail['private'] == 0) echo "public"; else echo "private"; ?></div>
            </div>
            <div class="sitem">
                <div class='stitle'>描述</div>
                <div id="i-describe"><?php echo $cdetail['description'] ?></div>
            </div>
        </div>
        <table class="table">
            <caption>单元列表</caption>
            <thead>
                <tr>
                    <th class="span1">单元ID</th>
                    <th class="span4">名称</th>
                    <th class="span6">开始时间</th>
                    <th class="span6">结束时间</th>
                    <th class="span2">修改</th>
                    <th class="span2">查看</th>
                    <th class="span2">删除</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(!empty($plist)){
                foreach ($plist as $item) { ?>
                <tr>
                    <td class="uid"><?php echo $item['unitId'] ?></td>
                    <td><?php echo $item['title'] ?></td>
                    <td><?php echo $item['startTime'] ?></td>
                    <td><?php echo $item['endTime'] ?></td>
                    <td><a class="edit" href="#">编辑</a></td>
                    <td><a href="<?php echo site_url('admin/course/problem/'.$item['unitId']) ?>">问题列表</a></td>
                    <td><a class="del" href="">删除</a></td>
                </tr>
                <?php }}else{ ?>

                    <td colspan='6'>暂无单元内容,请于下方添加</td>
                <?php } ?>
            </tbody>
        </table>
        <div>
            <h3>新建单元</h3>
            <div class="row">
                <span class="tip">名称：</span>
                <input class="necessary" id="title" type="text" name="title" />
            </div>
            <div class="row">
                <span class="tip">开始时间：</span>
                <div class="select-down">
                    <span class="select-down-span year placeholder">年<i class="down"></i></span>
                    <select class="select-down-select year" autocomplete="off" id="syear" name="start_year">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span month placeholder">月<i class="down"></i></span>
                    <select class="select-down-select month" autocomplete="off" id="smonth" name="start_mon">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span date placeholder">日<i class="down"></i></span>
                    <select class="select-down-select date" autocomplete="off" id="sdate" name="start_date">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span hour placeholder">时<i class="down"></i></span>
                    <select class="select-down-select hour" autocomplete="off" id="shour" name="start_hour">
                    </select>
                </div>
                <div class="select-down last-child">
                    <span class="select-down-span minute placeholder">分<i class="down"></i></span>
                    <select class="select-down-select minute" autocomplete="off" id="sminute" name="start_min">
                    </select>
                </div>
            </div>
            <div class="row">
                <span class="tip">结束时间：</span>
                <div class="select-down">
                    <span class="select-down-span year placeholder">年<i class="down"></i></span>
                    <select class="select-down-select year" autocomplete="off" id="eyear" name="end_year">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span month placeholder">月<i class="down"></i></span>
                    <select class="select-down-select month" autocomplete="off" id="emonth" name="end_mon">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span date placeholder">日<i class="down"></i></span>
                    <select class="select-down-select date" autocomplete="off" id="edate" name="end_date">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span hour placeholder">时<i class="down"></i></span>
                    <select class="select-down-select hour" autocomplete="off" id="ehour" name="end_hour">
                    </select>
                </div>
                <div class="select-down last-child"> 
                    <span class="select-down-span minute placeholder">分<i class="down"></i></span>
                    <select class="select-down-select minute" autocomplete="off" id="eminute" name="end_min">
                    </select>
                </div>
            </div>
            <div class="submit-footer">
                <input id="submit" type="button" class="btn" value="确认添加" />
            </div>
        </div>
    </div>
</div>

<!--修改时间模态对话框 -->
<div style="width:50%" id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <a class="close pull-right" onmouseover="this.style.opacity=0.6" onmouseout="this.style.opacity=1"style="cursor:pointer" data-dismiss="modal" aria-hidden="true">×</a>
    <h3 id="myModalLabel">修改单元时间</h3>
  </div>
  <div class="modal-body">
    <input id="unitid" class="hidden" />
    <div class="row">
        <span class="tip">开始时间：</span>
        <div class="select-down">
            <span class="select-down-span year placeholder">年<i class="down"></i></span>
            <select class="select-down-select year" autocomplete="off" id="m_syear">
            </select>
        </div>
        <div class="select-down">
            <span class="select-down-span month placeholder">月<i class="down"></i></span>
            <select class="select-down-select month" autocomplete="off" id="m_smonth">
            </select>
        </div>
        <div class="select-down">
            <span class="select-down-span date placeholder">日<i class="down"></i></span>
            <select class="select-down-select date" autocomplete="off" id="m_sdate">
            </select>
        </div>
        <div class="select-down">
            <span class="select-down-span hour placeholder">时<i class="down"></i></span>
            <select class="select-down-select hour" autocomplete="off" id="m_shour" >
            </select>
        </div>
        <div class="select-down last-child">
            <span class="select-down-span minute placeholder">分<i class="down"></i></span>
            <select class="select-down-select minute" autocomplete="off" id="m_sminute">
            </select>
        </div>
    </div>
    <div class="row">
        <span class="tip">结束时间：</span>
        <div class="select-down">
            <span class="select-down-span year placeholder">年<i class="down"></i></span>
            <select class="select-down-select year" autocomplete="off" id="m_eyear">
            </select>
        </div>
        <div class="select-down">
            <span class="select-down-span month placeholder">月<i class="down"></i></span>
            <select class="select-down-select month" autocomplete="off" id="m_emonth">
            </select>
        </div>
        <div class="select-down">
            <span class="select-down-span date placeholder">日<i class="down"></i></span>
            <select class="select-down-select date" autocomplete="off" id="m_edate">
            </select>
        </div>
        <div class="select-down">
            <span class="select-down-span hour placeholder">时<i class="down"></i></span>
            <select class="select-down-select hour" autocomplete="off" id="m_ehour">
            </select>
        </div>
        <div class="select-down last-child"> 
            <span class="select-down-span minute placeholder">分<i class="down"></i></span>
            <select class="select-down-select minute" autocomplete="off" id="m_eminute">
            </select>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    <button id="mode" style="margin-right:55px;" class="btn btn-primary">确认修改</button>
  </div>
</div>



<script type="text/javascript">
    loadTimeWidget();
    doSelect();
    fitAssistant();
    $(".del").on("click",function(c){
        c.preventDefault();
        var line = $(this).parent().parent();
        var uid = line.find(".uid").text();
        var url = '<?php echo site_url("admin/course/unit_del"); ?>'+'/'+uid;
            $.getJSON(url,function(data){
                if(data.status == true ){
                    line.fadeOut();
                }else{
                    alert(data.reason);
                }

            });
    })
//================================================
    $('input[name="add"]').on('click', function(event) {
        if(this.value == 0) {
            $('#students')[0].bg = $('#students').css('background-color');
            $('#students')[0].text = $('#students').val();
            $('#students').prop('disabled', 'true').css({ 
                'background-color': '#EDECED',
                'border-style': 'dashed'
            });
            $('#students').val('');
        } else {
            $('#students').removeAttr('disabled');
            $('#students').css({
                'background-color': $('#students')[0].bg,
                'border-style': 'solid'
            });
            $('#students').val($('#students')[0].text).focus();
        }
    });

//验证ID是否存在时相应闪烁边框*********ajax
    $('body').on('click','.chk-id', function(event) {
        var $input = $(this).parents('.row').find('input');

        var id = $input.val();
        var url = 'http://www.baidu.com';
        $.getJSON(url, {id: id}, function(data) {
            if(data.status == true) {
                blink_border($input,true);  //ID存在时的动作
            }else {
                blink_border($input,false); //ID不存在时的动作
            }
        });
    });

//修改课程ajax提交
    $('#mode-course-submit').on('click', function(event) {
        adapt_name();
        var url,title,stime,etime,pri,ifadd,describe,assistants,assCount,students;
        url = 'http://www.baidu.com';
        title = $('#myModal2 #title').val();
        stime = $('#c_syear').val();
        if(+$('#c_smonth').val() < 10) {
            stime += '-0' + $('#c_smonth').val();
        } else {
            stime += '-' + $('#c_smonth').val()
        }
        if(+$('#c_sdate').val() < 10) {
            stime += '-0' + $('#c_sdate').val();
        } else {
            stime += '-' + $('#c_sdate').val();
        }

        etime = $('#c_eyear').val();
        if(+$('#c_emonth').val() < 10) {
            etime += '-0' + $('#c_emonth').val();
        } else {
            etime += '-' + $('#c_emonth').val()
        }
        if(+$('#c_sdate').val() < 10) {
            etime += '-0' + $('#c_edate').val();
        } else {
            etime += '-' + $('#c_edate').val();
        }
        console.log(new Date(stime), new Date(etime));

        if(new Date(stime) >= new Date(etime)) {
            myPopover($('.partion-h', '#myModal2'), '开始时间必须小于结束时间', 'bottom');
            return false;
        }

        pri = $('#private-sel').val();
        ifadd = $('input[name="add"]:checked').val();
        describe = $('#describe').val();
        students = $('#students').val();

        assistants = '';
        assCount = $('#assis-count').val();
        for(var i = 0;i < assCount;i++) {
            assistants += $('input[name="assistant' + i + '"]').val() + ';';
        }

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                title: title,
                stime: stime,
                etime: etime,
                private: pri,
                describe: describe,
                ifadd: ifadd,
                students: students,
                assistants: assistants,
                assCount: assCount
            },
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    });
//================================================
    $('#submit').bind('click',function(c) {
        
        var url = '<?php echo site_url("admin/course/unit_add")."/".$cid ?>';
        if(!check_ness()) {
            c.preventDefault();
        }
        var title;
        var syear,smonth,sdate,shour,sminute,stime;
        var eyear,emonth,edate,ehour,eminute,etime;

        title = $('#title').val();
        syear = $('#syear').val();
        smonth = parseInt($('#smonth').val()) < 10 ? '0' + $('#smonth').val() : $('#smonth').val();
        sdate = parseInt($('#sdate').val()) < 10 ? '0' + $('#sdate').val() : $('#sdate').val();
        if($('#shour')[0])
            shour = parseInt($('#shour').val()) < 10 ? '0' + $('#shour').val() : $('#shour').val();
        else 
            shour = '00';
        if($('#sminute')[0])
            sminute = parseInt($('#sminute').val()) < 10 ? '0' + $('#sminute').val() : $('#sminute').val();
         else 
            sminute = '00';

        eyear = $('#eyear').val();
        emonth = parseInt($('#emonth').val()) < 10 ? '0' + $('#emonth').val() : $('#emonth').val();
        edate = parseInt($('#edate').val()) < 10 ? '0' + $('#edate').val() : $('#edate').val();
        if($('#ehour')[0])
            ehour = parseInt($('#ehour').val()) < 10 ? '0' + $('#ehour').val() : $('#ehour').val();
        else
            ehour = '00';
        if($('#eminute')[0])
            eminute = parseInt($('#eminute').val()) < 10 ? '0' + $('#eminute').val() : $('#eminute').val();
        else
            eminute = '00';
        stime = syear + '-' + smonth + '-' + sdate + ' ' + shour + ':' + sminute + ':00';
        etime = eyear + '-' + emonth + '-' + edate + ' ' + ehour + ':' + eminute + ':00';
            
        //开始时间必须小于结束时间
        var s = new Date(),e = new Date();
        s.setFullYear(parseInt(syear));
        s.setMonth(parseInt(smonth));
        s.setDate(parseInt(sdate));
        s.setHours(parseInt(shour));
        s.setMinutes(parseInt(sminute));
        s.setSeconds(parseInt(0));

        e.setFullYear(parseInt(eyear));
        e.setMonth(parseInt(emonth));
        e.setDate(parseInt(edate));
        e.setHours(parseInt(ehour));
        e.setMinutes(parseInt(eminute));
        e.setSeconds(parseInt(0));
        if(s < e) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    stime: stime,
                    etime: etime,
                    title: title
                },
            })
            .done(function() {
                location.reload();  //添加成功后自动刷新网页
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            
                
        } else {
                $('#syear').parent().parent().next('.popTip').remove();
                $('#syear').parent().parent().attr("data-content","开始时间必须小于结束时间");
                $('#syear').parent().parent().popover('show');
                setTimeout("$('#syear').parent().parent().popover('destroy')",1000);

            c.preventDefault();
        }
    })   

    $('body').on('click', '.edit', function(event) {
        $("#myModal").modal("show");
        $("#unitid").val($(this).parents('tr').children('td:first').text());
        var syear,smonth,sdate,shour,sminute;
        var eyear,emonth,edate,ehour,eminute;
        var regEx = /[- :]/;
        var stime = $(this).parents('tr').children('td:eq(2)').text().split(regEx);
        var etime = $(this).parents('tr').children('td:eq(3)').text().split(regEx);
        $("#m_syear").prev("span").html(stime[0] + " 年<i class='down'></i>");
        $("#m_syear option[value=" + (+stime[0]) + "]").prop('selected', 'true');

        $("#m_smonth").prev("span").html(stime[1] + " 月<i class='down'></i>");
        $("#m_smonth option[value=" + (+stime[1]) + "]").prop('selected', 'true');
        
        $("#m_sdate").prev("span").html(stime[2] + " 日<i class='down'></i>");
        $("#m_sdate option[value=" + (+stime[2]) + "]").prop('selected', 'true');

        $("#m_shour").prev("span").html(stime[3] + " 时<i class='down'></i>");
        $("#m_shour option[value=" + (+stime[3]) + "]").prop('selected', 'true');

        $("#m_sminute").prev("span").html(stime[4] + " 分<i class='down'></i>");
        $("#m_sminute option[value=" + (+stime[4]) + "]").prop('selected', 'true');

        $("#m_eyear").prev("span").html(etime[0] + " 年<i class='down'></i>");
        $("#m_eyear option[value=" + (+etime[0]) + "]").prop('selected', 'true');

        $("#m_emonth").prev("span").html(etime[1] + " 月<i class='down'></i>");
        $("#m_emonth option[value=" + (+etime[1]) + "]").prop('selected', 'true');

        $("#m_edate").prev("span").html(etime[2] + " 日<i class='down'></i>");
        $("#m_edate option[value=" + (+etime[2]) + "]").prop('selected', 'true');

        $("#m_ehour").prev("span").html(etime[3] + " 时<i class='down'></i>");
        $("#m_ehour option[value=" + (+etime[3]) + "]").prop('selected', 'true');

        $("#m_eminute").prev("span").html(etime[4] + " 分<i class='down'></i>");
        $("#m_eminute option[value=" + (+etime[4]) + "]").prop('selected', 'true');

    })

/*
*   修改时间
*/
    $('#mode').bind('click', function(event) {
        var url = '<?php echo site_url("/admin/course/unit_time_change") ?>';
        var unitid = $("#unitid").val();
        var syear,smonth,sdate,shour,sminute,stime;
        var eyear,emonth,edate,ehour,eminute,etime;

        syear = $('#m_syear').val();
        smonth = parseInt($('#m_smonth').val()) < 10 ? '0' + $('#m_smonth').val() : $('#m_smonth').val();
        sdate = parseInt($('#m_sdate').val()) < 10 ? '0' + $('#m_sdate').val() : $('#m_sdate').val();
        if($('#shour')[0])
            shour = parseInt($('#m_shour').val()) < 10 ? '0' + $('#m_shour').val() : $('#m_shour').val();
        else 
            shour = '00';
        if($('#m_sminute')[0])
            sminute = parseInt($('#m_sminute').val()) < 10 ? '0' + $('#m_sminute').val() : $('#m_sminute').val();
         else 
            sminute = '00';

        eyear = $('#m_eyear').val();
        emonth = parseInt($('#m_emonth').val()) < 10 ? '0' + $('#m_emonth').val() : $('#m_emonth').val();
        edate = parseInt($('#m_edate').val()) < 10 ? '0' + $('#m_edate').val() : $('#m_edate').val();
        if($('#m_ehour')[0])
            ehour = parseInt($('#m_ehour').val()) < 10 ? '0' + $('#m_ehour').val() : $('#m_ehour').val();
        else
            ehour = '00';
        if($('#m_minute')[0])
            eminute = parseInt($('#m_eminute').val()) < 10 ? '0' + $('#m_eminute').val() : $('#m_eminute').val();
        else
            eminute = '00';

        stime = syear + '-' + smonth + '-' + sdate + ' ' + shour + ':' + sminute + ':00';
        etime = eyear + '-' + emonth + '-' + edate + ' ' + ehour + ':' + eminute + ':00';
            
        //开始时间必须小于结束时间
        var s = new Date(),e = new Date();
        s.setFullYear(parseInt(syear));
        s.setMonth(parseInt(smonth));
        s.setDate(parseInt(sdate));
        s.setHours(parseInt(shour));
        s.setMinutes(parseInt(sminute));
        s.setSeconds(parseInt(0));

        e.setFullYear(parseInt(eyear));
        e.setMonth(parseInt(emonth));
        e.setDate(parseInt(edate));
        e.setHours(parseInt(ehour));
        e.setMinutes(parseInt(eminute));
        e.setSeconds(parseInt(0));

        if(s < e) {
            $.post(url,{unitid: unitid,stime: stime,etime: etime},function(data){
                if(data.status == true ){
                    window.location.reload();
                }else{
                    alert(data.reason);
                }

            },"json");
        } else {
            myPopover($('#m_eyear').parents('.row'),'结束时间必须大于开始时间','top');
            return false;
        }
    }); 
</script>