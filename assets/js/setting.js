$(document).ready(function() {
	$("#nav_sett").addClass("active");
	$("#top_nav_sett").addClass("active");
	$("#chng_username_form").unbind("submit").bind("submit", function() {
		var a = $(this);
		"" == $("#username").val() ? ($("#username").after('<p class="text-danger">Username field is required</p>'), $("#username").closest(".form-group").addClass("has-error")) : ($(".text-danger").remove(), $(".form-group").removeClass("has-error"), $("#chng_username_btn").button("loading"), $.ajax({url:a.attr("action"), type:a.attr("method"), data:a.serialize(), dataType:"json", success:function(b) {
				$("#chng_username_btn").button("reset");
				$(".text-danger").remove();
				$(".form-group").removeClass("has-error").removeClass("has-success");
				1 == b.isSuccessful ? ($(".chng_username_alrt").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + b.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				})) : ($(".chng_username_alrt").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> ' + b.updateFeedback + "</div>"), $(".alert-warning").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				}));
			}}));
		return !1;
	});
	$("#chng_pwd_form").unbind("submit").bind("submit", function() {
		var a = $(this);
		$(".text-danger").remove();
		var b = $("#password").val(), d = $("#new_pwd").val(), e = $("#conf_pwd").val();
		"" == b || "" == d || "" == e ? ("" == b ? ($("#password").after('<p class="text-danger">The Current Password field is required</p>'), $("#password").closest(".form-group").addClass("has-error")) : ($("#password").closest(".form-group").removeClass("has-error"), $(".text-danger").remove()), "" == d ? ($("#new_pwd").after('<p class="text-danger">The New Password field is required</p>'), $("#new_pwd").closest(".form-group").addClass("has-error")) : ($("#new_pwd").closest(".form-group").removeClass("has-error"),
			$(".text-danger").remove()), "" == e ? ($("#conf_pwd").after('<p class="text-danger">The Conform Password field is required</p>'), $("#conf_pwd").closest(".form-group").addClass("has-error")) : ($("#conf_pwd").closest(".form-group").removeClass("has-error"), $(".text-danger").remove())) : ($(".form-group").removeClass("has-error"), $(".text-danger").remove(), $.ajax({url:a.attr("action"), type:a.attr("method"), data:a.serialize(), dataType:"json", success:function(c) {
				console.log(c);
				1 == c.isSuccessful ? ($(".chng_pwd_alrt").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> ' + c.updateFeedback + "</div>"), $(".alert-success").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				})) : ($(".chng_pwd_alrt").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button><strong><i class="glyphicon glyphicon-exclamation-sign"></i></strong> ' + c.updateFeedback + "</div>"), $(".alert-warning").delay(500).show(10, function() {
					$(this).delay(3000).hide(10, function() {
						$(this).remove();
					});
				}));
			}}));
		return !1;
	});
});