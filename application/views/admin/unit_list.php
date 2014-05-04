    <div class="add-tab pull-right">
        <table class="table">
            <caption>单元列表</caption>
            <thead>
                <tr>
                    <th class="span1">单元ID</th>
                    <th class="span7">名称</th>
                    <th class="span6">开始时间</th>
                    <th class="span6">结束时间</th>
                    <th class="span2">编辑</th>
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
                    <td><a href="<?php echo site_url('admin/course/problem/'.$item['unitId']) ?>">编辑</a></td>
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
</div>

<script type="text/javascript">
    loadTimeWidget();
    doSelect();
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
</script>