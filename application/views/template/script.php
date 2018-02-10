    <!-- jQuery -->
    <script src="<?php echo base_url();?>js/jquery.js"></script>
    <!-- File Input Js -->
    <script src="<?php echo base_url();?>js/fileinput.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/fileinput_locale_th.js" type="text/javascript"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <!-- Angular Js -->
    <script src="<?php echo base_url();?>js/angular.min.js"></script>
    <script src="<?php echo base_url();?>js/ui-bootstrap-tpls-1.2.1.min.js"></script>
    <?php $this->load->view("js/app_js"); ?>
    <?php if(isset($script)){echo $script;}?>
    <?php if(isset($script_file)){echo $this->load->view($script_file); }?>
</body>
</html>