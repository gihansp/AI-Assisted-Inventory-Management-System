$(document).ready(function() {
	function e(a, c) {
		$(a).closest(".form-group").addClass("has-error");
		$(a).after('<p class="text-danger">' + c + "</p>");
	}
	function d() {
		$(".form-group").removeClass("has-error");
		$(".text-danger").remove();
	}
	$("#startDate, #endDate").datepicker();
	$("#get_ord_report_form").unbind("submit").bind("submit", function() {
		var a = $("#startDate").val(), c = $("#endDate").val();
		"" == a || "" == c ? ("" == a ? e("#startDate", "Please enter a Start Date") : d(), "" == c ? e("#endDate", "Please enter an End Date") : d()) : (d(), a = $(this), $.ajax({url:a.attr("action"), type:a.attr("method"), data:a.serialize(), dataType:"text", success:function(f) {
				var b = window.open("", "Phoenix Industries", "height=400,width=600");
				b.document.write("<html><head><title>Order Report</title>");
				b.document.write("</head><body>");
				b.document.write(f);
				b.document.write("</body></html>");
				b.document.close();
				b.focus();
				b.print();
				b.close();
			}}));
		return !1;
	});
});