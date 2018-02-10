<script src="<?php echo base_url('js/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
	tinymce.init({
		  selector: "#detail",
		  height: 500,
		  plugins: [
		    "advlist autolink lists link image charmap print preview anchor",
		    "searchreplace visualblocks code fullscreen",
		    "insertdatetime media table contextmenu paste code"
		  ],
		  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		  content_css: [
		    "//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css",
		    "//www.tinymce.com/css/codepen.min.css"
		  ]
		});
	$(document).on('ready', function() {
	    $("#image_field").fileinput({
	    	language: "th",
	    	<?php if($product_data['image']!=""){?>
		        initialPreview: [
		            '<img src="<?php echo base_url($product_data['image']);?>" class="file-preview-image">'
		        ],
	        <?php } ?>
	        overwriteInitial: false,
	        maxFileSize: 2000,
	    });
	       <?php foreach ($images_list as $image) {?>
	    	
			 $("#image_field_<?php echo $image['line_number']; ?>").fileinput({
			    	language: "th",
			    	<?php if($image['path']!=""){?>
			    		initialPreview: [
					            '<img src="<?php echo base_url($image['path']); ?>" class="file-preview-image">'
					        ],
			    	<?php } ?>
			        overwriteInitial: false,
			        maxFileSize: 2000
			    });

	   <?php } ?>
	});

	var app = angular.module("myApp", []);
	app.controller("myCtrl", function($scope) {
	    $scope.firstName = "John";
	    $scope.lastName = "Doe";
	});
</script>