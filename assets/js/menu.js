//menu modal
$(function () {
	$(".btnAdd").on("click", function () {
		$("#menuModalLabel").html("Tambah Menu");
		$(".modal-footer button[type=submit]").html("Tambah");
	});
	$(".menuModalEdit").on("click", function () {
		$("#menuModalLabel").html("Edit Menu");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/menu/editmenu/"
		);

		const id = $(this).data("id");

		$.ajax({
			url: "http://localhost/new-simrs/menu/getEditMenu/",
			data: { id_menu: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				if (data) {
					$("#id_menu").val(data.id_menu);
					$("#menu").val(data.menu);
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});

//submenu modal
$(function () {
	$(".btnEdit").on("click", function () {
		$("#submenuModalLabel").html("Tambah Sub Menu");
		$(".modal-footer button[type=submit]").html("Tambah");
		$(".url_form input").removeAttr("disabled");
	});
	$(".subMenuModal").on("click", function () {
		$("#submenuModalLabel").html("Edit Sub Menu");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".url_form input").attr("disabled", true);
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/menu/editsubmenu/"
		);

		const id = $(this).data("id");

		$.ajax({
			url: "http://localhost/new-simrs/menu/getEditSubMenu/",
			data: { id_sub: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				// console.log(data);

				if (data) {
					$("#id_sub").val(data.id_sub); // Sesuaikan dengan id_sub
					$("#title").val(data.judul);
					$("#menu_name").val(data.id_menu);
					$("#icon").val(data.ikon);
					$("#url").val(data.url);
					$("option[value=" + data.id_menu + "]").attr("selected", "");
					if (data.is_active == 1) {
						$("#active").attr("checked", "");
					} else {
						$("#active").removeAttr("checked", "");
					}
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});
