var manage_usr_tbl;
$(document).ready(function() {
	$("#top_nav_usr").addClass("active");
	manage_usr_tbl = $("#manage_usr_tbl").DataTable({ajax:"functions/user/get-users.php", order:[], dom:"Bfrtip", buttons:[{extend:"copy",}, {extend:"csv",}], initComplete:function(a, c) {
			$(".dt-button").removeClass("dt-button").addClass("btn btn-primary");
		}});
	$("#new_usr_btn").unbind("click").bind("click", function() {
		$("#submit_usr_form")[0].reset();
		$(".text-danger").remove();
		$(".form-group").removeClass("has-error").removeClass("has-success");
		$("#prod_img").fileinput({overwriteInitial:!0, maxFileSize:5000, showClose:!1, showCaption:!1, browseLabel:"", removeLabel:"", browseIcon:'<i class="glyphicon glyphicon-folder-open"></i>', removeIcon:'<i class="glyphicon glyphicon-remove"></i>', removeTitle:"Cancel or reset changes", elErrorContainer:"#kv-avatar-errors-1", msgErrorClass:"alert alert-block alert-danger", defaultPreviewContent:'<img src="assets/images/Placeholder_view_vector.png" alt="Profile Image" style="width:100%;">', layoutTemplates:{main2:"{preview} {remove} {browse}"},
			allowedFileExtensions:"jpg png gif JPG PNG GIF".split(" ")});
		$("#submit_usr_form").unbind("submit").bind("submit", function() {
			var a = $("#userName").val(), c = $("#upassword").val();
			"" == a ? ($("#userName").after('<p class="text-danger">User name field is required</p>'), $("#userName").closest(".form-group").addClass("has-error")) : ($("#userName").find(".text-danger").remove(), $("#userName").closest(".form-group").addClass("has-success"));
			"" == c ? ($("#upassword").after('<p class="text-danger">Password field is required</p>'), $("#upassword").closest(".form-group").addClass("has-error")) : ($("#upassword").find(".text-danger").remove(), $("#upassword").closest(".form-group").addClass("has-success"));
			c && a && ($("#new_usr_btn").button("loading"), a = $(this), c = new FormData(this), $.ajax({url:a.attr("action"), type:a.attr("method"), data:c, dataType:"json", cache:!1, contentType:!1, processData:!1, success:function(b) {
					1 == b.isSuccessful && ($("#new_usr_btn").button("reset"), $("#submit_usr_form")[0].reset(), $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop:"0"}, 100), $("#add-user-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + b.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
						$(this).delay(3000).hide(10, function() {
							$(this).remove();
						});
					}), manage_usr_tbl.ajax.reload(null, !0), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"));
				}}));
			return !1;
		});
	});
});
function editUser(a) {
	(a = void 0 === a ? null : a) ? ($("#userid").remove(), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"), $(".div-loading").removeClass("div-hide"), $(".div-result").addClass("div-hide"), $.ajax({url:"functions/user/get-preferred-staff.php", type:"post", data:{userid:a}, dataType:"json", success:function(c) {
			$(".div-loading").addClass("div-hide");
			$(".div-result").removeClass("div-hide");
			$(".editUserFooter").append('<input type="hidden" name="userid" id="userid" value="' + c.user_id + '" />');
			$(".mdfy_usr_photo_footer").append('<input type="hidden" name="userid" id="userid" value="' + c.user_id + '" />');
			$("#mdfy_usr_nm").val(c.username);
			$("#mdfy_usr_form").unbind("submit").bind("submit", function() {
				var b = $("#mdfy_usr_nm").val(), d = $("#mdfy_pwd").val();
				"" == b ? ($("#mdfy_usr_nm").after('<p class="text-danger">User Name field is required</p>'), $("#mdfy_usr_nm").closest(".form-group").addClass("has-error")) : ($("#mdfy_usr_nm").find(".text-danger").remove(), $("#mdfy_usr_nm").closest(".form-group").addClass("has-success"));
				"" == d ? ($("#mdfy_pwd").after('<p class="text-danger">Password field is required</p>'), $("#mdfy_pwd").closest(".form-group").addClass("has-error")) : ($("#mdfy_pwd").find(".text-danger").remove(), $("#mdfy_pwd").closest(".form-group").addClass("has-success"));
				d && b && ($("#mdfy_usr_btn").button("loading"), b = $(this), d = new FormData(this), $.ajax({url:b.attr("action"), type:b.attr("method"), data:d, dataType:"json", cache:!1, contentType:!1, processData:!1, success:function(e) {
						console.log(e);
						1 == e.isSuccessful && ($("#mdfy_usr_btn").button("reset"), $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop:"0"}, 100), $("#edit-user-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + e.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}), manage_usr_tbl.ajax.reload(null, !0), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"));
					}}));
				return !1;
			});
			$("#mdfy_prod_img_form").unbind("submit").bind("submit", function() {
				var b = $("#mdfy_prod_img").val();
				"" == b ? ($("#mdfy_prod_img").closest(".center-block").after('<p class="text-danger">Product Image field is required</p>'), $("#mdfy_prod_img").closest(".form-group").addClass("has-error")) : ($("#mdfy_prod_img").find(".text-danger").remove(), $("#mdfy_prod_img").closest(".form-group").addClass("has-success"));
				if (b) {
					$("#mdfy_prod_imgBtn").button("loading");
					b = $(this);
					var d = new FormData(this);
					$.ajax({url:b.attr("action"), type:b.attr("method"), data:d, dataType:"json", cache:!1, contentType:!1, processData:!1, success:function(e) {
							1 == e.isSuccessful && ($("#mdfy_prod_imgBtn").button("reset"), $("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop:"0"}, 100), $("#edit-productPhoto-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + e.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}), manage_usr_tbl.ajax.reload(null, !0), $(".fileinput-remove-button").click(), $.ajax({url:"functions/user/get-product-image-url.php?i=" + a, type:"post", success:function(f) {
									$("#getprod_img").attr("src", f);
								}}), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"));
						}});
				}
				return !1;
			});
		}})) : alert("error please refresh the page");
}
function deleteUser(a) {
	(a = void 0 === a ? null : a) && $("#del_prod_btn").unbind("click").bind("click", function() {
		$("#del_prod_btn").button("loading");
		$.ajax({url:"functions/user/delete-staff.php", type:"post", data:{userid:a}, dataType:"json", success:function(c) {
				$("#del_prod_btn").button("reset");
				1 == c.isSuccessful ? ($("#del_usr_modal").modal("hide"), manage_usr_tbl.ajax.reload(null, !1), $(".remove-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + c.updateFeedback + "</div>")) : $(".deleteUserMessages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' +
					c.updateFeedback + "</div>");
				$(".alert-success").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				});
			}});
		return !1;
	});
}
