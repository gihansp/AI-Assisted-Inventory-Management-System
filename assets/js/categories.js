// Input 0
var manage_cats_tbl;
$(document).ready(function() {
	$("#nav_cats").addClass("active");
	manage_cats_tbl = $("#manage_cats_tbl").DataTable({ajax:"functions/category/get-categories.php", order:[], dom:"Bfrtip", buttons:[{extend:"copy",}, {extend:"csv",}], initComplete:function(a, c) {
			$(".dt-button").removeClass("dt-button").addClass("btn btn-primary");
		}});
	$("#new_cats_btn").unbind("click").bind("click", function() {
		$("#submit_cats_form")[0].reset();
		$(".text-danger").remove();
		$(".form-group").removeClass("has-error").removeClass("has-success");
		$("#submit_cats_form").unbind("submit").bind("submit", function() {
			var a = $("#cats_name").val();
			"" == a ? ($("#cats_name").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Category is required.</p>'), $("#cats_name").closest(".form-group").addClass("has-error")) : ($("#cats_name").find(".text-danger").remove(), $("#cats_name").closest(".form-group").addClass("has-success"));
			a && (a = $(this), $("#new_cats_btn").button("loading"), $.ajax({url:a.attr("action"), type:a.attr("method"), data:a.serialize(), dataType:"json", success:function(c) {
					$("#new_cats_btn").button("reset");
					1 == c.isSuccessful && (manage_cats_tbl.ajax.reload(null, !1), $("#submit_cats_form")[0].reset(), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"), $("#add-categories-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + c.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
						$(this).delay(3000).hide(10, function() {
							$(this).remove();
						});
					}));
				}}));
			return !1;
		});
	});
});
function editCats(a) {
	(a = void 0 === a ? null : a) ? ($("#mdfy_cats_id").remove(), $("#mdfy_cats_form")[0].reset(), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"), $("#edit-categories-messages").html(""), $(".modal-loading").removeClass("div-hide"), $(".edit-cat-res").addClass("div-hide"), $(".edit-cat-footer").addClass("div-hide"), $.ajax({url:"functions/category/get-preferred-categories.php", type:"post", data:{categoriesId:a}, dataType:"json",
		success:function(c) {
			$(".modal-loading").addClass("div-hide");
			$(".edit-cat-res").removeClass("div-hide");
			$(".edit-cat-footer").removeClass("div-hide");
			$("#mdfy_cats_name").val(c.cat_name);
			$(".edit-cat-footer").after('<input type="hidden" name="mdfy_cats_id" id="mdfy_cats_id" value="' + c.cat_id + '" />');
			$("#mdfy_cats_form").unbind("submit").bind("submit", function() {
				var b = $("#mdfy_cats_name").val();
				"" == b ? ($("#mdfy_cats_name").after('<p class="text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Category is required.</p>'), $("#mdfy_cats_name").closest(".form-group").addClass("has-error")) : ($("#mdfy_cats_name").find(".text-danger").remove(), $("#mdfy_cats_name").closest(".form-group").addClass("has-success"));
				b && (b = $(this), $("#mdfy_cats_btn").button("loading"), $.ajax({url:b.attr("action"), type:b.attr("method"), data:b.serialize(), dataType:"json", success:function(d) {
						$("#mdfy_cats_btn").button("reset");
						1 == d.isSuccessful && (manage_cats_tbl.ajax.reload(null, !1), $(".text-danger").remove(), $(".form-group").removeClass("has-error").removeClass("has-success"), $("#edit-categories-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + d.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}));
					}}));
				return !1;
			});
		}})) : alert("Oops!! Refresh the page");
}
function removeCats(a) {
	a = void 0 === a ? null : a;
	$.ajax({url:"functions/category/get-preferred-categories.php", type:"post", data:{categoriesId:a}, dataType:"json", success:function(c) {
			$("#del_cats_btn").unbind("click").bind("click", function() {
				$("#del_cats_btn").button("loading");
				$.ajax({url:"functions/category/delete-category.php", type:"post", data:{categoriesId:a}, dataType:"json", success:function(b) {
						1 == b.isSuccessful ? ($("#del_cats_btn").button("reset"), $("#del_cats_modal").modal("hide"), manage_cats_tbl.ajax.reload(null, !1)) : $("#del_cats_modal").modal("hide");
						$(".remove-messages").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + b.updateFeedback + "</div>");
						$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						});
					}});
			});
		}});
}
