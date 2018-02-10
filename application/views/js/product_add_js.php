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
	        maxFileSize: 2000
	    });
	    <?php for ($i=1; $i < 11  ; $i++) { ?>
	       		 $("#image_field_<?php echo $i; ?>").fileinput({
			    	language: "th",
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