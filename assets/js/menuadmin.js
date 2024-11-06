
console.log("menuadmin.js is loaded");

$(document).ready(function () {
	$(".form-check-input").on("click", function () {
		const menuId = $(this).data("menu");
		const roleId = $(this).data("role");
		const url = $(this).data("url");
		$.ajax({
			url: url + "admin/changeaccess",
			type: "post",
			data: {
				menuId: menuId,
				roleId: roleId,
			},
			success: function () {
				document.location.href = url + "admin/roleaccess/" + roleId;
			},
		});
	});
});

//role modal
$(function () {
	$(".btnAddRole").on("click", function () {
		$("#roleModalLabel").html("Tambah Role");
		$(".modal-footer button[type=submit]").html("Tambah");
	});
	$(".roleModalEdit").on("click", function () {
		$("#roleModalLabel").html("Edit Role");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/admin/editrole/"
		);

		const id = $(this).data("id");

		$.ajax({
			url: "http://localhost/new-simrs/admin/getEditRole/",
			data: { id_role: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				if (data) {
					$("#id_role").val(data.id_role);
					$("#role").val(data.role);
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});











//tindakan modal
$(function () {
	$(".btnTindakan").on("click", function () {
		$("#tindakanModalLabel").html("Tambah Tindakan");
		$(".modal-footer button[type=submit]").html("Tambah");
	});

	$(".tindakanModal").on("click", function () {
		$("#tindakanModalLabel").html("Edit Tindakan");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/menuadmin/updateTindakan/"
		);
		const id = $(this).data("id");
		$.ajax({
			url: "http://localhost/new-simrs/menuadmin/geteditTindakan/",
			data: { id_tindakan: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				if (data) {
					$("#id_tindakan").val(data.id_tindakan);
					$("#tindakan").val(data.nama_tindakan);
					$("#biaya").val(data.biaya);
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});

//ruang modal
$(function () {
	$(".btnRuang").on("click", function () {
        console.log('sadjgbskjgb')
        // $("#ruangModalLabel").html("Tambah Ruang");
		// $(".modal-footer button[type=submit]").html("Tambah");
	});

	// edit ruang
	$(".ruangModal").on("click", function () {
		$("#ruangModalLabel").html("Edit Ruang");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/menuadmin/update_ruang/"
		);

		const id = $(this).data("id");

		$.ajax({
			url: "http://localhost/new-simrs/menuadmin/getEditRuang/",
			data: { id_ruang: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				if (data) {
					$("#id_ruang").val(data.id_ruang);
					$("#ruang").val(data.nama_ruang);
					$("#kapasitas").val(data.kapasitas);
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});

//ruang igd modal
$(function () {
	$(".ruangIGDModal").on("click", function () {
		$("#ruangIGDModalLabel").html("Edit Ruang IGD");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/menuadmin/update_ruang_igd/"
		);

		const id = $(this).data("id");

		$.ajax({
			url: "http://localhost/new-simrs/menuadmin/getEditRuangIGD/",
			data: { id_ruang_igd: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				if (data) {
					$("#id_ruang_igd").val(data.id_ruang_igd);
					$("#ruang_igd").val(data.nama_ruang_igd);
					$("#kapasitas").val(data.kapasitas);
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});

//pasien modal
const selectRuang = document.getElementById("ruang");
const selectRuangIGD = document.getElementById("ruang_igd");
const kapasitasInfo = document.getElementById("kapasitas-info");
const kapasitasInfoIGD = document.getElementById("kapasitas-info-igd");

// Event listener untuk update kapasitas saat ruang dipilih
selectRuang.addEventListener("change", function () {
	const selectedOption = selectRuang.options[selectRuang.selectedIndex];
	const kapasitas = selectedOption.getAttribute("data-kapasitas");
	kapasitasInfo.textContent = kapasitas ? `${kapasitas}` : "Kapasitas";
});
selectRuangIGD.addEventListener("change", function () {
	const selectedOption = selectRuangIGD.options[selectRuangIGD.selectedIndex];
	const kapasitas = selectedOption.getAttribute("data-kapasitas-igd");
	kapasitasInfoIGD.textContent = kapasitas ? `${kapasitas}` : "Kapasitas";
});


$(function () {
	$(".btnPasien").on("click", function () {
		$("#pasien").show();
		$("#v_pasien").hide();
	});

	$(".pasienModal").on("click", function () {
		$("#pasien").hide();
		$("#v_pasien").show();
	});
});
$(function () {
    $(".btnPasien").on("click", function () {
		$("#pasienModalLabel").html("Tambah Pasien");
		$(".modal-footer button[type=submit]").html("Tambah");
	});
	$(".pasienModal").on("click", function () {
		$("#pasienModalLabel").html("Edit Pasien");
		$(".modal-footer button[type=submit]").html("Edit");
		$("#tanggal_masuk").attr("readonly", true);
		$("#v_pasien").attr("disabled", true);
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/menuadmin/edit/"
		);

		const id = $(this).data("id");


		$.ajax({
			url: "http://localhost/new-simrs/menuadmin/getPasienInap/",
			data: { id_pasien: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				$("#id_pasien").val(data.id_pasien);
                // console.log(data.id_pasien);
				$("#v_pasien").val(data.id_pasien);
				$("#no_telp").val(data.no_telp);
				$("#tanggal_masuk").val(data.tanggal_masuk);
				console.log(data);
				const selectedOption = selectRuang.querySelector(
					`option[value="${data.id_ruang}"]`
				);
				const kapasitas = selectedOption
					? selectedOption.getAttribute("data-kapasitas")
					: null;
				kapasitasInfo.textContent = kapasitas ? `${kapasitas}` : 0;
			},
		});
	});
});