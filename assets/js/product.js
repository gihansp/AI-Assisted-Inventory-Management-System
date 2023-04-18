// Input 0
var manageprod_tbl;
$(document).ready(function() {
	$("#nav_prod").addClass("active");
	manageprod_tbl = $("#manageprod_tbl").DataTable({ajax:"functions/product/get-product.php", order:[], dom:"Bfrtip", buttons:[{extend:"copy",}, {extend:"csv",}], initComplete:function(b, a) {
			$(".dt-button").removeClass("dt-button").addClass("btn btn-primary");
		}});
	$("#new_prod_btn").unbind("click").bind("click", function() {
		$("#submit_prod_form")[0].reset();
		$(".text-danger").remove();
		$(".form-group").removeClass("has-error").removeClass("has-success");
		$("#prod_img").fileinput({overwriteInitial:!0, maxFileSize:2500, showClose:!1, showCaption:!1, browseLabel:"", removeLabel:"", browseIcon:'<i class="glyphicon glyphicon-folder-open"></i>', removeIcon:'<i class="glyphicon glyphicon-remove"></i>', removeTitle:"Cancel or reset changes", elErrorContainer:"#kv-avatar-errors-1", msgErrorClass:"alert alert-block alert-danger", defaultPreviewContent:'<img src="assets/images/Placeholder_view_vector.png" alt="Profile Image" style="width:100%;">', layoutTemplates:{main2:"{preview} {remove} {browse}"},
			allowedFileExtensions:"jpg png gif JPG PNG GIF".split(" ")});
		$("#submit_prod_form").unbind("submit").bind("submit", function() {
			var b = $("#prod_img").val(), a = $("#prod_nm").val(), c = $("#product_quantity").val(), d = $("#rate").val(), e = $("#cat_nm").val(), f = $("#prod_status").val();
			"" == b ? ($("#prod_img").closest(".center-block").after('<p class="text-danger">Please upload an image for your product.</p>'), $("#prod_img").closest(".form-group").addClass("has-error")) : ($("#prod_img").find(".text-danger").remove(), $("#prod_img").closest(".form-group").addClass("has-success"));
			"" == a ? ($("#prod_nm").after('<p class="text-danger">Product Name field is required.</p>'), $("#prod_nm").closest(".form-group").addClass("has-error")) : ($("#prod_nm").find(".text-danger").remove(), $("#prod_nm").closest(".form-group").addClass("has-success"));
			"" == c ? ($("#product_quantity").after('<p class="text-danger">The product quantity field is required.</p>'), $("#product_quantity").closest(".form-group").addClass("has-error")) : ($("#product_quantity").find(".text-danger").remove(), $("#product_quantity").closest(".form-group").addClass("has-success"));
			"" == d ? ($("#rate").after('<p class="text-danger">Rate field is required.</p>'), $("#rate").closest(".form-group").addClass("has-error")) : ($("#rate").find(".text-danger").remove(), $("#rate").closest(".form-group").addClass("has-success"));
			"" == e ? ($("#cat_nm").after('<p class="text-danger">Category Name field is required.</p>'), $("#cat_nm").closest(".form-group").addClass("has-error")) : ($("#cat_nm").find(".text-danger").remove(), $("#cat_nm").closest(".form-group").addClass("has-success"));
			"" == f ? ($("#prod_status").after('<p class="text-danger">Product Status field is required.</p>'), $("#prod_status").closest(".form-group").addClass("has-error")) : ($("#prod_status").find(".text-danger").remove(), $("#prod_status").closest(".form-group").addClass("has-success"));
			b && a && c && d && e && f && ($("#createProductBtn").button("loading"), b = $(this), a = new FormData(this), $.ajax({url:b.attr("action"), type:b.attr("method"), data:a, dataType:"json", cache:!1, contentType:!1, processData:!1, success:function(g) {
					1 == g.isSuccessful && ($("#createProductBtn").button("reset"), $("#submit_prod_form")[0].reset(), $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop:"0"}, 100), $("#add-product-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + g.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
						$(this).delay(3000).hide(10, function() {
							$(this).remove();
						});
					}), manageprod_tbl.ajax.reload(null, !0), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"));
				}}));
			return !1;
		});
	});
});
function mdfyProd(b) {
	(b = void 0 === b ? null : b) ? ($("#prod_id").remove(), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"), $(".div-loading").removeClass("div-hide"), $(".div-result").addClass("div-hide"), $.ajax({url:"functions/product/get-preferred-product.php", type:"post", data:{prod_id:b}, dataType:"json", success:function(a) {
			$(".div-loading").addClass("div-hide");
			$(".div-result").removeClass("div-hide");
			$("#getprod_img").attr("src", "product-images/" + a.product_photo);
			$("#mdfy_prod_img").fileinput({});
			$(".mdfyProdFooter").append('<input type="hidden" name="prod_id" id="prod_id" value="' + a.product_id + '" />');
			$(".mdfyProdPhotoFooter").append('<input type="hidden" name="prod_id" id="prod_id" value="' + a.product_id + '" />');
			$("#mdfy_prod_nm").val(a.product_name);
			$("#mdfy_prod_qty").val(a.product_quantity);
			$("#mdfy_rate").val(a.rate);
			$("#mdfy_cat_nm").val(a.cat_id);
			$("#mdfy_prod_status").val(a.active);
			$("#mdfyProdForm").unbind("submit").bind("submit", function() {
				$("#mdfy_prod_img").val();
				var c = $("#mdfy_prod_nm").val(), d = $("#mdfy_prod_qty").val(), e = $("#mdfy_rate").val(), f = $("#mdfy_cat_nm").val(), g = $("#mdfy_prod_status").val();
				"" == c ? ($("#mdfy_prod_nm").after('<p class="text-danger">Product Name is required.</p>'), $("#mdfy_prod_nm").closest(".form-group").addClass("has-error")) : ($("#mdfy_prod_nm").find(".text-danger").remove(), $("#mdfy_prod_nm").closest(".form-group").addClass("has-success"));
				"" == d ? ($("#mdfy_prod_qty").after('<p class="text-danger">Quantity is required.</p>'), $("#mdfy_prod_qty").closest(".form-group").addClass("has-error")) : ($("#mdfy_prod_qty").find(".text-danger").remove(), $("#mdfy_prod_qty").closest(".form-group").addClass("has-success"));
				"" == e ? ($("#mdfy_rate").after('<p class="text-danger">Rate is required.</p>'), $("#mdfy_rate").closest(".form-group").addClass("has-error")) : ($("#mdfy_rate").find(".text-danger").remove(), $("#mdfy_rate").closest(".form-group").addClass("has-success"));
				"" == f ? ($("#mdfy_cat_nm").after('<p class="text-danger">Category is required.</p>'), $("#mdfy_cat_nm").closest(".form-group").addClass("has-error")) : ($("#mdfy_cat_nm").find(".text-danger").remove(), $("#mdfy_cat_nm").closest(".form-group").addClass("has-success"));
				"" == g ? ($("#mdfy_prod_status").after('<p class="text-danger">Product status is required.</p>'), $("#mdfy_prod_status").closest(".form-group").addClass("has-error")) : ($("#mdfy_prod_status").find(".text-danger").remove(), $("#mdfy_prod_status").closest(".form-group").addClass("has-success"));
				c && d && e && f && g && ($("#mdfyProdBtn").button("loading"), c = $(this), d = new FormData(this), $.ajax({url:c.attr("action"), type:c.attr("method"), data:d, dataType:"json", cache:!1, contentType:!1, processData:!1, success:function(h) {
						console.log(h);
						1 == h.isSuccessful && ($("#mdfyProdBtn").button("reset"), $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop:"0"}, 100), $("#edit-product-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + h.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}), manageprod_tbl.ajax.reload(null, !0), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"));
					}}));
				return !1;
			});
			$("#mdfy_prod_img_form").unbind("submit").bind("submit", function() {
				var c = $("#mdfy_prod_img").val();
				"" == c ? ($("#mdfy_prod_img").closest(".center-block").after('<p class="text-danger">Product Image is required.</p>'), $("#mdfy_prod_img").closest(".form-group").addClass("has-error")) : ($("#mdfy_prod_img").find(".text-danger").remove(), $("#mdfy_prod_img").closest(".form-group").addClass("has-success"));
				if (c) {
					$("#mdfy_prod_imgBtn").button("loading");
					c = $(this);
					var d = new FormData(this);
					$.ajax({url:c.attr("action"), type:c.attr("method"), data:d, dataType:"json", cache:!1, contentType:!1, processData:!1, success:function(e) {
							1 == e.isSuccessful && ($("#mdfy_prod_imgBtn").button("reset"), $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop:"0"}, 100), $("#edit-productPhoto-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + e.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}), manageprod_tbl.ajax.reload(null, !0), $(".fileinput-remove-button").click(), $.ajax({url:"functions/product/get-product-image-url.php?i=" + b, type:"post", success:function(f) {
									$("#getprod_img").attr("src", f);
								}}), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"));
						}});
				}
				return !1;
			});
		}})) : alert("error please refresh the page");
}
function deleteProd(b) {
	(b = void 0 === b ? null : b) && $("#del_prod_btn").unbind("click").bind("click", function() {
		$("#del_prod_btn").button("loading");
		$.ajax({url:"functions/product/delete-product.php", type:"post", data:{prod_id:b}, dataType:"json", success:function(a) {
				$("#del_prod_btn").button("reset");
				1 == a.isSuccessful ? ($("#del_prod_modal").modal("hide"), manageprod_tbl.ajax.reload(null, !1), $(".remove-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + a.updateFeedback + "</div>")) : $(".deleteProdMessages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' +
					a.updateFeedback + "</div>");
				$(".alert-success").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				});
			}});
		return !1;
	});
}
