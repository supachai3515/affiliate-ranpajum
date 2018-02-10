<script src="<?php echo base_url('js/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
	$(document).on('ready', function() {
	    $("#image_field").fileinput({
	    	language: "th",
	    	<?php if($slider_data['image']!=""){?>
		        initialPreview: [
		            '<img src="<?php echo $this->config->item('url_img').$slider_data['image'];?>" class="file-preview-image">'
		        ],
	        <?php } ?>
	        overwriteInitial: false,
	        maxFileSize: 2000,
	    });
	});

</script>
