<div class="wrapper">
	<div class="noback">
		<div class="nbc">
			<img src="<?php echo base_url("assets") ?>/img/master.png">
			<div class="inform">
				<h3><?php echo $error_inform_title ?></h3>
				<?php foreach ($error_inform as $inform): ?>
					<p><?php echo $inform ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>