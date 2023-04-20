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
function printOrd(a) {
	(a = void 0 === a ? null : a) && $.ajax({url:"functions/order/invoice.php", type:"post", data:{orderId:a}, dataType:"text", success:function(c) {
			var b = window.open("", "Phoenix Industries", "height=400,width=600");
			b.document.write("<html><head><title>Order Invoice</title>");
			b.document.write("</head><body>");
			b.document.write(c);
			b.document.write("</body></html>");
			b.document.close();
			b.focus();
			b.resizeTo(screen.width, screen.height);
			setTimeout(function() {
				b.print();
				b.close();
			}, 1250);
		}});
}
function addProd() {
	$("#new_row_btn").button("loading");
	var a = $("#prod_tbl tbody tr").length;
	if (0 < a) {
		var c = $("#prod_tbl tbody tr:last").attr("id");
		var b = $("#prod_tbl tbody tr:last").attr("class");
		var f = c.substring(3);
		f = Number(f) + 1;
		b = Number(b) + 1;
	} else {
		f = 1, b = 0;
	}
	$.ajax({url:"functions/product/get-product-data.php", type:"post", dataType:"json", success:function(k) {
			$("#new_row_btn").button("reset");
			var h = '<tr id="row' + f + '" class="' + b + '"><td><div class="form-group"><select class="form-control" name="prod_nm[]" id="prod_nm' + f + '" onchange="getProd(' + f + ')" >';
			$.each(k, function(l, m) {
				h += '<option value="' + m[0] + '">' + m[1] + "</option>";
			});
			h += '</select></div></td><td style="padding-left:20px;""><input type="text" name="rate[]" id="rate' + f + '" disabled="true" class="form-control" /><input type="hidden" name="rate_val[]" id="rate_val' + f + '" class="form-control" /></td style="padding-left:20px;"><td style="padding-left:20px;"><div class="form-group"><p id="avail_prod_qty' + f + '"></p></div></td><td style="padding-left:20px;"><div class="form-group"><input type="number" name="product_quantity[]" id="product_quantity' +
				f + '" onkeyup="getTotal(' + f + ')" class="form-control" min="1" /></div></td><td style="padding-left:20px;"><input type="text" name="total[]" id="total' + f + '" class="form-control" disabled="true" /><input type="hidden" name="tot_val[]" id="tot_val' + f + '" class="form-control" /></td><td><button class="btn btn-default removeProdBtn" type="button" onclick="removeProd(' + f + ')"><i class="glyphicon glyphicon-trash"></i></button></td></tr>';
			0 < a ? $("#prod_tbl tbody tr:last").after(h) : $("#prod_tbl tbody").append(h);
		}});
}
function removeProd(a) {
	(a = void 0 === a ? null : a) ? ($("#row" + a).remove(), subAmt()) : alert("There was an issue retrieving the data. Please refresh the page and try again.");
}
function getProd(a) {
	if (a = void 0 === a ? null : a) {
		var c = $("#prod_nm" + a).val();
		"" == c ? ($("#rate" + a).val(""), $("#product_quantity" + a).val(""), $("#total" + a).val("")) : $.ajax({url:"functions/product/get-preferred-product.php", type:"post", data:{prod_id:c}, dataType:"json", success:function(b) {
				$("#rate" + a).val(b.rate);
				$("#rate_val" + a).val(b.rate);
				$("#product_quantity" + a).val(1);
				$("#avail_prod_qty" + a).text(b.product_quantity);
				b = 1 * Number(b.rate);
				b = b.toFixed(2);
				$("#total" + a).val(b);
				$("#tot_val" + a).val(b);
				subAmt();
			}});
	} else {
		alert("There was an issue retrieving the data. Please refresh the page and try again.");
	}
}
function getTotal(a) {
	if (a = void 0 === a ? null : a) {
		var c = Number($("#rate" + a).val()) * Number($("#product_quantity" + a).val());
		c = c.toFixed(2);
		$("#total" + a).val(c);
		$("#tot_val" + a).val(c);
		subAmt();
	} else {
		alert("There was an issue retrieving the data. Please refresh the page and try again.");
	}
}
function subAmt() {
	var a = $("#prod_tbl tbody tr").length, c = 0;
	for (x = 0; x < a; x++) {
		var b = $("#prod_tbl tbody tr")[x];
		b = $(b).attr("id");
		b = b.substring(3);
		c = Number(c) + Number($("#total" + b).val());
	}
	c = c.toFixed(2);
	$("#subTotal").val(c);
	$("#subtot_val").val(c);
	a = Number($("#subTotal").val()) / 100 * 18;
	a = a.toFixed(2);
	$("#vat").val(a);
	$("#vatValue").val(a);
	a = Number($("#subTotal").val()) + Number($("#vat").val());
	a = a.toFixed(2);
	$("#totalAmount").val(a);
	$("#totalAmountValue").val(a);
	(c = $("#discount").val()) ? (a = Number($("#totalAmount").val()) - Number(c), a = a.toFixed(2), $("#grandTotal").val(a), $("#grandtot_val").val(a)) : ($("#grandTotal").val(a), $("#grandtot_val").val(a));
	(a = $("#paid").val()) ? (a = Number($("#grandTotal").val()) - Number(a), a = a.toFixed(2), $("#due").val(a), $("#dueValue").val(a)) : ($("#due").val($("#grandTotal").val()), $("#dueValue").val($("#grandTotal").val()));
}
function applyDiscount() {
	$("#discount").val();
	var a = Number($("#totalAmount").val());
	if (a = a.toFixed(2)) {
		a = Number($("#totalAmount").val()) - Number($("#discount").val()), a = a.toFixed(2), $("#grandTotal").val(a), $("#grandtot_val").val(a);
	}
	$("#paid").val() ? (a = Number($("#grandTotal").val()) - Number($("#paid").val()), a = a.toFixed(2), $("#due").val(a), $("#dueValue").val(a)) : ($("#due").val($("#grandTotal").val()), $("#dueValue").val($("#grandTotal").val()));
}
function paidAmt() {
	if ($("#grandTotal").val()) {
		var a = Number($("#grandTotal").val()) - Number($("#paid").val());
		a = a.toFixed(2);
		$("#due").val(a);
		$("#dueValue").val(a);
	}
}

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
	}) : alert("There was an issue retrieving the data. Please refresh the page and try again.");
}
function payOrder(a) {
	(a = void 0 === a ? null : a) ? ($("#ord_date").datepicker(), $.ajax({url:"functions/order/fetchOrderData.php", type:"post", data:{orderId:a}, dataType:"json", success:function(c) {
			$("#due").val(c.order[10]);
			$("#pay_amt").val(c.order[10]);
			var b = c.order[9], f = c.order[8];
			$("#updt-pay-order-btn").unbind("click").bind("click", function() {
				var k = $("#pay_amt").val(), h = $("#pay_type").val(), l = $("#pay_status").val();
				"" == k ? ($("#pay_amt").after('<p class="text-danger">The Pay Amount field is required</p>'), $("#pay_amt").closest(".form-group").addClass("has-error")) : $("#pay_amt").closest(".form-group").addClass("has-success");
				"" == h ? ($("#pay_type").after('<p class="text-danger">The Pay Amount field is required</p>'), $("#pay_type").closest(".form-group").addClass("has-error")) : $("#pay_type").closest(".form-group").addClass("has-success");
				"" == l ? ($("#pay_status").after('<p class="text-danger">The Pay Amount field is required</p>'), $("#pay_status").closest(".form-group").addClass("has-error")) : $("#pay_status").closest(".form-group").addClass("has-success");
				k && h && l && ($("#updt-pay-order-btn").button("loading"), $.ajax({url:"functions/order/editPayment.php", type:"post", data:{orderId:a, pay_amt:k, pay_type:h, pay_status:l, paidAmt:b, grandTotal:f}, dataType:"json", success:function(m) {
						$("#updt-pay-order-btn").button("loading");
						$(".text-danger").remove();
						$(".form-group").removeClass("has-error").removeClass("has-success");
						$("#pay-order-modal").modal("hide");
						$("#success-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + m.updateFeedback + "</div>");
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						});
						manage_ord_tbl.ajax.reload(null, !1);
					}}));
				return !1;
			});
		}})) : alert("There was an issue retrieving the data. Please refresh the page and try again.");
}
;