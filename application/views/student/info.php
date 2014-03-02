<div class="wrapper">
	<div class="personal-info">
		<div class="info pull-left">
			<table>
				<tr>
					<td>
					<span class='person-name'><?php echo $user['name']?></span>
					<span><a class="mode-passwd" href="#"><img src="<?php echo base_url('assets') ?>/img/edit.jpg"> <small>修改密码</small></a></span>
					</td>
				</tr>
				<tr>
					<td>
					<span><a href="#">历史登陆情况</a></span>
					</td>
				</tr>
				<tr>
					<td>
					<span>NO.</span><span><?php echo $user['userId'] ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span>Solved:</span><span><?php echo $ac_num ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span>Submit:</span><span><?php echo $submit_num ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span>CE:</span><span><?php echo $ce_num ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span>School:</span><span><?php echo $school ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span>Email:</span><span><?php echo $email ?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span>默认编程语言:</span><span><?php echo $plan ?></span>
					</td>
				</tr>                
				<tr>
					<td>
					<span>Statistic:</span>
					<span id="pie-chart"></span>
					</td>
				</tr>
			</table>
	</div>
	<div class="problem-done">
		<div class='sub-header'>
			<h3>题目列表</h3>
		</div>
		<div class='all-p-list'>
			<div><i class='ac'></i><a href="#" data-toggle="tooltip" data-original-title="sssss"  data-trigger="hover">1001</a></div>
			<div><i class='we'></i><a href="#" data-toggle="tooltip"  data-placement="bottom" data-trigger="hover">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
			<div><i class='we'></i><a href="#">1001</a></div>
		</div>
	</div>
	<div class='clearfix'></div>

	</div>
</div>



<script type="text/javascript" src="<?php echo base_url('assets'); ?>/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets'); ?>/js/bootstrap.js"></script>
<script type="text/javascript">
	$(function () {
	$('#pie-chart').highcharts({
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: ''
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: false,
				cursor: 'pointer',
				dataLabels: {
					enabled: false,
					color: '#000000',
					connectorColor: '#000000',
					format: '<b>{point.name}</b>: {point.percentage:.1f} %'
				}
			}
		},
		series: [{
			type: 'pie',
			name: 'Browser share',
			data: [
				['Firefox',   45.0],
				['IE',       26.8],
				['Safari',    8.5],
				['Opera',     6.2],
				['Others',    0.7]
			]
		}]
	});

    $('.all-p-list').tooltip({
      selector: "a"
    })
});             
</script>
