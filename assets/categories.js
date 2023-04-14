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
