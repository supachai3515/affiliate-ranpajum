<script type="text/javascript">

  /*Datepicker*/
		var minD = $("#startDate").html();
        var maxD = $("#endDate").html();
		var startDateTextBox = $('#dateStart');
		var endDateTextBox = $('#dateEnd');
	
		startDateTextBox.datepicker({ 
			format: "yyyy-mm-dd",
			language: "th",
			autoclose: true,
			todayHighlight: true,
			todayBtn: true,
			enableOnReadonly : true,
			changeMonth : true ,
			changeYear : true,
			yearRange : "c-2:c+80",
			onClose: function(dateText, inst) {
				if (endDateTextBox.val() != '') {
					var testStartDate = startDateTextBox.datetimepicker('getDate');
					var testEndDate = endDateTextBox.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						endDateTextBox.datetimepicker('setDate', testStartDate);
				}
				else {
					endDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate') );
			}
		});
		endDateTextBox.datepicker({ 
			format: "yyyy-mm-dd",
			language: "th",
			autoclose: true,
			todayHighlight: true,
			todayBtn: true,
			enableOnReadonly : true,
			changeMonth : true ,
			changeYear : true,
			yearRange : "c-2:c+80",
			onClose: function(dateText, inst) {
				if (startDateTextBox.val() != '') {
					var testStartDate = startDateTextBox.datetimepicker('getDate');
					var testEndDate = endDateTextBox.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						startDateTextBox.datetimepicker('setDate', testEndDate);
				}
				else {
					startDateTextBox.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate') );
			}
		});
</script>


	