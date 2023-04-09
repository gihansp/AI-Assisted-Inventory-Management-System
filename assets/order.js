var manage_ord_tbl;
$(document).ready(function() {
	var a = $(".div-request").text();
	$("#nav_ord").addClass("active");
	"add" == a ? ($("#top_nav_new_ord").addClass("active"), $("#ord_date").datepicker(), $("#new_ord_form").unbind("submit").bind("submit", function() {
		var c = $(this);
		$(".form-group").removeClass("has-error").removeClass("has-success");
		$(".text-danger").remove();
		var b = $("#ord_date").val(), f = $("#cstmr_nm").val(), k = $("#cstmr_contact").val(), h = $("#paid").val(), l = $("#discount").val(), m = $("#pay_type").val(), p = $("#pay_status").val();
		"" == b ? ($("#ord_date").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Order Date. </p>'), $("#ord_date").closest(".form-group").addClass("has-error")) : $("#ord_date").closest(".form-group").addClass("has-success");
		"" == f ? ($("#cstmr_nm").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Customer Name. </p>'), $("#cstmr_nm").closest(".form-group").addClass("has-error")) : $("#cstmr_nm").closest(".form-group").addClass("has-success");
		"" == k ? ($("#cstmr_contact").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Contact. </p>'), $("#cstmr_contact").closest(".form-group").addClass("has-error")) : $("#cstmr_contact").closest(".form-group").addClass("has-success");
		"" == h ? ($("#paid").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Paid amount. </p>'), $("#paid").closest(".form-group").addClass("has-error")) : $("#paid").closest(".form-group").addClass("has-success");
		"" == l ? ($("#discount").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Discount. </p>'), $("#discount").closest(".form-group").addClass("has-error")) : $("#discount").closest(".form-group").addClass("has-success");
		"" == m ? ($("#pay_type").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please select Payment Type. </p>'), $("#pay_type").closest(".form-group").addClass("has-error")) : $("#pay_type").closest(".form-group").addClass("has-success");
		"" == p ? ($("#pay_status").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please select Payment Status. </p>'), $("#pay_status").closest(".form-group").addClass("has-error")) : $("#pay_status").closest(".form-group").addClass("has-success");
		for (var e = document.getElementsByName("prod_nm[]"), q, d = 0; d < e.length; d++) {
			var g = e[d].id;
			"" == e[d].value ? ($("#" + g).after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter the Quantity. </p>'), $("#" + g).closest(".form-group").addClass("has-error")) : $("#" + g).closest(".form-group").addClass("has-success");
		}
		for (d = 0; d < e.length; d++) {
			q = e[d].value ? !0 : !1;
		}
		e = document.getElementsByName("product_quantity[]");
		for (d = 0; d < e.length; d++) {
			g = e[d].id, "" == e[d].value ? ($("#" + g).after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter the Quantity. </p>'), $("#" + g).closest(".form-group").addClass("has-error")) : $("#" + g).closest(".form-group").addClass("has-success");
		}
		for (d = 0; d < e.length; d++) {
			var r = e[d].value ? !0 : !1;
		}
		b && f && k && h && l && m && p && 1 == q && 1 == r && $.ajax({url:c.attr("action"), type:c.attr("method"), data:c.serialize(), dataType:"json", success:function(n) {
				console.log(n);
				$("#new_ord_btn").button("reset");
				$(".text-danger").remove();
				$(".form-group").removeClass("has-error").removeClass("has-success");
				1 == n.isSuccessful ? ($(".success-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + n.updateFeedback),
					$("html, body, div.panel, div.pane-body").animate({scrollTop:"0px"}, 100), $(".submitButtonFooter").addClass("div-hide"), $(".removeProdBtn").addClass("div-hide")) : alert(n.updateFeedback);
			}});
		return !1;
	})) : "manage" == a ? ($("#topNavManageOrder").addClass("active"), manage_ord_tbl = $("#manage_ord_tbl").DataTable({ajax:"functions/order/get-order.php", order:[], dom:"Bfrtip", buttons:[{extend:"copy",}, {extend:"csv",}], initComplete:function(c, b) {
			$(".dt-button").removeClass("dt-button").addClass("btn btn-primary");
		}})) : "modify" == a && ($("#ord_date").datepicker(), $("#mdfy_ord_form").unbind("submit").bind("submit", function() {
		var c = $(this);
		$(".form-group").removeClass("has-error").removeClass("has-success");
		$(".text-danger").remove();
		var b = $("#ord_date").val(), f = $("#cstmr_nm").val(), k = $("#cstmr_contact").val(), h = $("#paid").val(), l = $("#discount").val(), m = $("#pay_type").val(), p = $("#pay_status").val();
		"" == b ? ($("#ord_date").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Order Date.</p>'), $("#ord_date").closest(".form-group").addClass("has-error")) : $("#ord_date").closest(".form-group").addClass("has-success");
		"" == f ? ($("#cstmr_nm").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Client Name.</p>'), $("#cstmr_nm").closest(".form-group").addClass("has-error")) : $("#cstmr_nm").closest(".form-group").addClass("has-success");
		"" == k ? ($("#cstmr_contact").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Contact.</p>'), $("#cstmr_contact").closest(".form-group").addClass("has-error")) : $("#cstmr_contact").closest(".form-group").addClass("has-success");
		"" == h ? ($("#paid").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Paid amount.</p>'), $("#paid").closest(".form-group").addClass("has-error")) : $("#paid").closest(".form-group").addClass("has-success");
		"" == l ? ($("#discount").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please enter Discount.</p>'), $("#discount").closest(".form-group").addClass("has-error")) : $("#discount").closest(".form-group").addClass("has-success");
		"" == m ? ($("#pay_type").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please select Payment Type.</p>'), $("#pay_type").closest(".form-group").addClass("has-error")) : $("#pay_type").closest(".form-group").addClass("has-success");
		"" == p ? ($("#pay_status").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Please select Payment Status.</p>'), $("#pay_status").closest(".form-group").addClass("has-error")) : $("#pay_status").closest(".form-group").addClass("has-success");
		for (var e = document.getElementsByName("prod_nm[]"), q, d = 0; d < e.length; d++) {
			var g = e[d].id;
			"" == e[d].value ? ($("#" + g).after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Product Name Field is required!! </p>'), $("#" + g).closest(".form-group").addClass("has-error")) : $("#" + g).closest(".form-group").addClass("has-success");
		}
		for (d = 0; d < e.length; d++) {
			q = e[d].value ? !0 : !1;
		}
		e = document.getElementsByName("product_quantity[]");
		for (d = 0; d < e.length; d++) {
			g = e[d].id, "" == e[d].value ? ($("#" + g).after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Product Name Field is required!! </p>'), $("#" + g).closest(".form-group").addClass("has-error")) : $("#" + g).closest(".form-group").addClass("has-success");
		}
		for (d = 0; d < e.length; d++) {
			var r = e[d].value ? !0 : !1;
		}
		b && f && k && h && l && m && p && 1 == q && 1 == r && $.ajax({url:c.attr("action"), type:c.attr("method"), data:c.serialize(), dataType:"json", success:function(n) {
				console.log(n);
				$("#mdfy_ord_btn").button("reset");
				$(".text-danger").remove();
				$(".form-group").removeClass("has-error").removeClass("has-success");
				1 == n.isSuccessful ? ($(".success-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + n.updateFeedback + "</div>"), $("html, body, div.panel, div.pane-body").animate({scrollTop:"0px"}, 100), $(".editButtonFooter").addClass("div-hide"), $(".removeProdBtn").addClass("div-hide")) : alert(n.updateFeedback);
			}});
		return !1;
	}));
});






function deleteOrder(a) {
	(a = void 0 === a ? null : a) ? $("#deleteOrderBtn").unbind("click").bind("click", function() {
		$("#deleteOrderBtn").button("loading");
		$.ajax({url:"functions/order/delete-order.php", type:"post", data:{orderId:a}, dataType:"json", success:function(c) {
				$("#deleteOrderBtn").button("reset");
				1 == c.isSuccessful ? (manage_ord_tbl.ajax.reload(null, !1), $("#deleteOrderModal").modal("hide"), $("#success-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + c.updateFeedback + "</div>")) : $(".deleteOrderMessages").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button> ' +
					c.updateFeedback + "</div>");
				$(".alert-success").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				});
			}});
	}) : alert("error! refresh the page again");
}

;