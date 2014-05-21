        <div class="add-course pull-right">
        <form action="<?php echo site_url("admin/contest/add_up") ?>" method="post">
            <h3>添加竞赛</h3>
            <div class="row">
                <span class="tip">竞赛名称：</span>
                <input class="necessary" id="title" type="text" name="title" />
            </div>
            <div class="row">
                <span class="tip">有效期：</span>
                <input type="text" id="stime" name="stime" class="hidden">
                <input type="text" id="etime" name="etime" class="hidden">
                <div class="select-down">
                    <span class="select-down-span year placeholder">年<i class="down"></i></span>
                    <select class="select-down-select year" autocomplete="off" id="syear">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span month placeholder">月<i class="down"></i></span>
                    <select class="select-down-select month" autocomplete="off" id="smonth">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span date placeholder">日<i class="down"></i></span>
                    <select class="select-down-select date" autocomplete="off" id="sdate">
                    </select>
                </div>
                <i class="partion-h"></i>
                <div class="select-down">
                    <span class="select-down-span year placeholder">年<i class="down"></i></span>
                    <select class="select-down-select year" autocomplete="off" id="eyear">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span month placeholder">月<i class="down"></i></span>
                    <select class="select-down-select month" autocomplete="off" id="emonth">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span date placeholder">日<i class="down"></i></span>
                    <select class="select-down-select date" autocomplete="off" id="edate">
                    </select>
                </div>
            </div>
            <div class="row">
                <span class="tip">private：</span>
                <div class="select-down" id="private">
                    <span class="select-down-span placeholder">private<i class="down"></i></span>
                    <select class="select-down-select" autocomplete="off" name="private">
                    <option value="private" selected="true">private</option>
                    <option value="public">public</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <span class="tip">语言选择:</span>
                <div class="select-down">
                    <span class="select-down-span placeholder">C++<i class="down"></i></span>
                    <select class="select-down-select" autocomplete="off" name="language">
                        <?php foreach ($lan as $index => $l) { ?>
                            <option value='<?php echo $index; ?>' <?php if($index == 1) echo 'selected="selected"'?>><?php echo $l; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <hr />
            <div class="row">
                <!--
                <span class="tip">导入学生：</span>
                <textarea id="students" name="students"></textarea>
                <div>
                    <input type="text" id="excel" readonly />
                    <div class="row">
                        <a href="#">查看excel格式要求</a>
                        <a class="btn file" id="excel">从excel导入</a>
                        <input id="excel" type="file" class="hidden" name="excel" />
                    </div>
                </div>
            -->
                <ul class="nav-tabs">
                    <li class="active"><a rel="#tab11">输入数据</a></li>
                    <li style="display:none"><a rel="#tab12">导入表格</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab11">
                        <span class="tip text-left">学生名单：</span>
                        <textarea id="students" name="students"></textarea>
                    </div>
                    <div class="tab-pane" id="tab12">
                        <input type="text" id="excel" readonly />
                        <div class="row">
                            <a href="#">查看excel格式要求</a>
                            <a class="btn file" id="excel">从excel导入</a>
                            <input id="excel" type="file" class="hidden" name="excel" />
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <span class="tip">描述：</span>
                <textarea id="describe" name="describe"></textarea>
            </div>
            <div class="submit-footer">
                <input type="submit" class="btn" value="添加" />
            </div>
        </form>
        </div>
    </div>
</div>
<!--
    因为可能需要提交文件，所以此页面就没有采用ajax，所有该提交的数据都用了表单
-->
<script type="text/javascript">
    doSelect();
    loadTimeWidget();
    load_tab(); //这函数的取名将错就错吧

    $('form').bind('submit',function(c) {

        if(!check_ness() || !check_students()) {
            c.preventDefault();
            return false;
        }
        var url = '<?php echo site_url("admin/") ?>';
       
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
            $('#stime').val(stime);
            $('#etime').val(etime);
            $('form')[0].submit();
        } else {
            if($('#syear').parents('.row')[0] == $('#eyear').parents('.row')[0]){
                myPopover($('#syear').parents('.row'),'开始时间必须小于结束时间','top');
            } else {
                myPopover($('#syear').parents('.row'),'开始时间必须小于结束时间','top');
                myPopover($('#eyear').parents('.row'),'结束时间必须大于开始时间','top');
            }
            c.preventDefault();
        }
    })
</script>
