<div class="panel panel-default">
    <div class="panel-heading">
      <?php
        echo '<i class="fa fa-user"></i> '.$this->session->userdata('username');
      ?>
    </div>
    <div class="panel-body">
        <a class="btn btn-default btn-lg btn-block" href="<?php echo  base_url('dealer'); ?>" role="button">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> ข้อมูล Dealer
        </a>
		<?php if (isset($dealerInfo['verify'])): ?>
			<?php if (($dealerInfo['is_lavel1'] == 1) && ($dealerInfo['verify'] ==1)): ?>
				<p></p>
				<div class="list-group">
					<a href="<?php echo base_url('dealer_po'); ?>" class="list-group-item"><i class="fa fa-file-text-o "></i> ขอใบเสนอราคา</a>
					<a href="<?php echo  base_url('dealer_po/po_list'); ?>" class="list-group-item"><i class="fa fa-file-text-o "></i> ใบเสนอราคาย้อนหลัง</a>
				</div>
			<?php endif ?>
		<?php endif ?>
    </div>
</div>