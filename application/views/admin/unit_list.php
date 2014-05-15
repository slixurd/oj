    <div class="add-tab pull-right">
        <table class="table">
            <caption>单元列表<small id="mode-course" style="cursor:pointer;font-size:14px;margin-left:1em;">修改课程信息</small></caption>
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

<!--修改课程信息模态对话框 -->
<div style="width:805px;left:0;margin-left:280px" id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <a class="close pull-right" onmouseover="this.style.opacity=0.6" onmouseout="this.style.opacity=1"style="cursor:pointer" data-dismiss="modal" aria-hidden="true">×</a>
        <h3 id="myModalLabel">修改课程信息</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <span style="width:100px" class="tip">课程名称：</span>
            <input style="width:610px" id="title" type="text" />
        </div>
        <input type="text" id="assis-count" class="hidden" value="1" />
        <div class="row">
            <span style="width:100px" class="tip">添加助教：</span>
            <input id="assistant" type="text" name="assistant0" />
            <a id="assitant-id" href="#" class="btn chk-id">ID是否存在</a>
        </div>
        <div class="row">
            <span style="width:100px" class="tip">修改有效期：</span>
            <div class="select-down">
                <span class="select-down-span year placeholder">年<i class="down"></i></span>
                <select class="select-down-select year" autocomplete="off" id="c_syear">
                </select>
            </div>
            <div class="select-down">
                <span class="select-down-span month placeholder">月<i class="down"></i></span>
                <select class="select-down-select month" autocomplete="off" id="c_smonth">
                </select>
            </div>
            <div class="select-down">
                <span class="select-down-span date placeholder">日<i class="down"></i></span>
                <select class="select-down-select date" autocomplete="off" id="c_sdate">
                </select>
            </div>
            <i class="partion-h"></i>
            <div class="select-down">
                <span class="select-down-span year placeholder">年<i class="down"></i></span>
                <select class="select-down-select year" autocomplete="off" id="c_eyear">
                </select>
            </div>
            <div class="select-down">
                <span class="select-down-span month placeholder">月<i class="down"></i></span>
                <select class="select-down-select month" autocomplete="off" id="c_emonth">
                </select>
            </div>
            <div class="select-down">
                <span class="select-down-span date placeholder">日<i class="down"></i></span>
                <select class="select-down-select date" autocomplete="off" id="c_edate">
                </select>
            </div>
        </div>
        <div class="row">
            <span style="width:100px" class="tip">private：</span>
            <div class="select-down" id="private">
                <span class="select-down-span placeholder">private<i class="down"></i></span>
                <select id="private-sel" class="select-down-select" autocomplete="off">
                <option value="private" selected="true">private</option>
                <option value="public">public</option>
                </select>
            </div>
        </div>
        <hr />
        <div class="row">
            <div style="margin-bottom:1em">修改学生名单(
                <label for="add">添加</label>
                <input type="radio" id="add" checked="checked" name="add" value="1" autocomplete="off" />&nbsp;&nbsp;
                <label for="del">删除</label>
                <input type="radio" id="del" name="add" value="0" autocomplete="off" />
                )：
            </div>
            <textarea style="width:710px;height:205px" id="students" name="students"></textarea>
        </div>
        <hr />
        <div class="row">
            <span class="tip">描述：</span>
            <textarea style="width:610px" id="describe"></textarea>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
            <button id="mode-course-submit" style="margin-right:15px;" class="btn btn-primary">确认修改</button>
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

//修改课程，需要后台动态填写信息
    $('#mode-course').on('click', function(event) {
        var url = 'http://www.baidu.com';

/*
**********以下代码纯属演示和自己测试，有ajax存在的话应该删除*********************************
*/
        //json可以采用这种格式
        var jsonStr = '{ "title": "数据结构", "describe": "这是一门很有用的课程", ';
        jsonStr += '"stime": "2015-05-12", "etime": "2029-12-09", ';
        jsonStr += '"private": "public" }';
        var json = $.parseJSON(jsonStr);

        var stime = json.stime.split('-'), etime = json.etime.split('-');

        var $modal = $('#myModal2');
        $('#title', $modal).val(json.title);
        $('#describe', $modal).val(json.describe);
        $('#c_syear', $modal).val(+stime[0]).prev('span').html(stime[0] + ' 年<i class="down"></i>');
        $('#c_smonth', $modal).val(+stime[1]).prev('span').html(stime[1] + ' 月<i class="down"></i>');
        $('#c_sdate', $modal).val(+stime[2]).prev('span').html(stime[2] + ' 日<i class="down"></i>');

        $('#c_eyear', $modal).val(+etime[0]).prev('span').html(etime[0] + ' 年<i class="down"></i>');
        $('#c_emonth', $modal).val(+etime[1]).prev('span').html(etime[1] + ' 月<i class="down"></i>');
        $('#c_edate', $modal).val(+etime[2]).prev('span').html(etime[2] + ' 日<i class="down"></i>');

        $('#private option[value="' + json.private + '"]', $modal).prop('selected', 'true');
        $('#private-sel', $modal).prev('span').html(json.private + '<i class="down"></i>');
/*
************************************************************************************************
*/      
        $.getJSON(url, {courseid: '1000'}, function(data) {
            var jsonStr = '{ "title": "数据结构", "describe": "这是一门很有用的课程", ';
            jsonStr += '"stime": "2015-05-12", "etime": "2029-12-09", ';
            jsonStr += '"private": "public" }';
            var json = $.parseJSON(jsonStr);

            var stime = json.stime.split('-'), etime = json.etime.split('-');

            var $modal = $('#myModal2');
            $('#title', $modal).val(json.title);
            $('#describe', $modal).val(json.describe);
            $('#c_syear', $modal).val(+stime[0]).prev('span').html(stime[0] + ' 年<i class="down"></i>');
            $('#c_smonth', $modal).val(+stime[1]).prev('span').html(stime[1] + ' 月<i class="down"></i>');
            $('#c_sdate', $modal).val(+stime[2]).prev('span').html(stime[2] + ' 日<i class="down"></i>');

            $('#c_eyear', $modal).val(+etime[0]).prev('span').html(etime[0] + ' 年<i class="down"></i>');
            $('#c_emonth', $modal).val(+etime[1]).prev('span').html(etime[1] + ' 月<i class="down"></i>');
            $('#c_edate', $modal).val(+etime[2]).prev('span').html(etime[2] + ' 日<i class="down"></i>');

            $('#private option[value="' + json.private + '"]', $modal).prop('selected', 'true');
            $('#private-sel', $modal).prev('span').html(json.private + '<i class="down"></i>');
        });
        
        $("#myModal2").modal("show");
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