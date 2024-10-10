console.log("adsda");

const loginFlash = $("#loginflash");
const loginBerhasil = loginFlash.data("login-success");
const loginGagal = loginFlash.data("login-error");
if (loginBerhasil) {
	Swal.fire({
		title: "Login Berhasil",
		text: loginBerhasil,
		icon: "success",
	}).then((result) => {
		if (result.isConfirmed) {
			document.location.href = "http://localhost/new-simrs/pasien/index";
		}
	});
} else if (loginGagal) {
	Swal.fire({
		title: "Login Gagal",
		text: loginGagal,
		icon: "error",
	});
}
const ruangflash =$(".ruangflash").data("ruang-flash")
const errorRuang =$(".ruangflash").data("error-flash")
if (ruangflash) {
	Swal.fire({
		title: "Ruang",
		text: ruangflash,
		icon: "success",
		timer: 2500,
	});
}
if (errorRuang) {
	Swal.fire({
		title: "Ruang",
		text: errorRuang,
		icon: "error",
		timer: 2500,
	});
}
const tindakanflash =$(".tindakanflash").data("tindakan-flash")
const errorTindakan =$(".tindakanflash").data("error-flash")
if (tindakanflash) {
	Swal.fire({
		title: "Tindakan",
		text: tindakanflash,
		icon: "success",
		timer: 2500,
	});
}
if (errorTindakan) {
	Swal.fire({
		title: "Tindakan",
		text: errorTindakan,
		icon: "error",
		timer: 2500,
	});
}
const visiteAdded =$(".visiteflash").data("visite-added")
const visiteFailed =$(".visiteflash").data("visite-failed")

if (visiteAdded) {
	Swal.fire({
		title: "Visite",
		text: visiteAdded,
		icon: "success",
		timer: 2500,
	});
}
if (visiteFailed) {
	Swal.fire({
		title: "Visite",
		text: visiteFailed,
		icon: "error",
		timer: 2500,
	});
}
const tindakanDokterFlash =$(".tindakanflash").data("tindakan-success")
const tindakanDokterFailed =$(".tindakanflash").data("tindakan-failed")

if (tindakanDokterFlash) {
	Swal.fire({
		title: "Tindakan",
		text: tindakanDokterFlash,
		icon: "success",
		timer: 2500,
	});
}
if (tindakanDokterFailed) {
	Swal.fire({
		title: "Tindakan",
		text: tindakanDokterFailed,
		icon: "error",
		timer: 2500,
	});
}


const pasienFlash =$(".pasienflash").data("pasien-flash")
const errorFlash =$(".pasienflash").data("error-flash")
if (pasienFlash) {
	Swal.fire({
		title: "Pasien",
		text: pasienFlash,
		icon: "success",
		timer: 2500,
	});
}
if (errorFlash) {
	Swal.fire({
		title: "Pasien",
		text: errorFlash,
		icon: "error",
		timer: 2500,
	});
}
$(document).ready(function () {
	const pasienFlash = document.getElementById("pasienflash");
	const regisPasien = pasienFlash.getAttribute("data-pasien-success");
	const noMedis = document
		.getElementById("no_medis")
		.getAttribute("data-nomedis");
	
	if (regisPasien) {
		Swal.fire({
			title: regisPasien + " Daftar Akun Pasien",
			html: `
				<div class="d-flex justify-content-center align-items-center">
					<h4 class='mt-2' id='textToCopy'>${noMedis}</h4>
					<input type='text' id='copyInput' value='${noMedis}' readonly style='position: absolute; left: -9999px;'>
					<button class="btn ml-3 btn-primary" onclick="myFunction()">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
							<path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V2Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H6ZM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1H2Z"/>
						</svg>
					</button>
				</div>
				<br> Ini No. Medis Pasien kamu, silahkan masuk menggunakan No. Medis Pasien tersebut.`,
			icon: "success",
			confirmButtonText: "OK",
		}).then((result) => {
			if (result.isConfirmed) {
				document.location.href = "login";
			}
		});
	}
});
function myFunction() {
	var copyText = document.getElementById("copyInput");
	if (copyText) {
		copyText.select(); // Select the text
		copyText.setSelectionRange(0, 99999); // For mobile devices
		navigator.clipboard
			.writeText(copyText.value)
			.then(() => {
				const copyButton = document.querySelector(".btn-primary");
				copyButton.classList.remove("btn-primary");
				copyButton.classList.add("btn-secondary");
			})
			.catch((err) => {
				console.error("Failed to copy text: ", err);
			});
	} else {
		console.error('No input element found with ID "copyInput"');
	}
}

const menuFlash = $(".menu-flash").data("menuflash");
const menuFailed = $(".menu-flash").data("menufailed");
const menuAdded = $(".menu-flash").data("menuadded");
if (menuFlash) {
	Swal.fire({
		title: "Menu",
		text: "Successfully" + menuFlash,
		icon: "success",
		timer: 2500,
	});
}

if (menuAdded) {
	Swal.fire({
		title: "Menu",
		text: "Successfully" + menuAdded,
		icon: "success",
		timer: 2500,
	});
} else if (menuFailed) {
	Swal.fire({
		title: "Menu",
		text: "Menu" + menuFailed,
		icon: "error",
		timer: 2500,
	});
}

const subMenuAdded = $(".menu-flash").data("submenu_added");
const subMenuFailed = $(".menu-flash").data("submenu_failed");
if (subMenuAdded) {
	Swal.fire({
		title: "Submenu",
		text: "Successfully" + subMenuAdded,
		icon: "success",
		timer: 2500,
	});
} else if (subMenuFailed) {
	Swal.fire({
		title: "Submenu",
		text: "Submenu" + subMenuFailed,
		icon: "error",
		timer: 2500,
	});
}

const roleFlash = $(".role-flash").data("roleflash");
const roleAdd = $(".role-flash").data("roleadded");
const roleFailed = $(".role-flash").data("rolefailed");
if (roleFlash) {
	Swal.fire({
		title: "Role",
		text: "Successfully" + roleFlash,
		icon: "success",
		timer: 2500,
	});
}
if (roleAdd) {
	Swal.fire({
		title: "Role",
		text: "Successfully" + roleAdd,
		icon: "success",
		timer: 2500,
	});
} else if (roleFailed) {
	Swal.fire({
		title: "Role",
		text: "Role" + roleFailed,
		icon: "error",
		timer: 2500,
	});
}
const profilFlash = $(".profil-flash").data("profilflash");
if (profilFlash) {
	Swal.fire({
		title: "Profil",
		text: "Successfully" + profilFlash,
		icon: "success",
		timer: 2500,
	});
}

// input check

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

$(".delete").on("click", function (e) {
	e.preventDefault();
	const href = $(this).attr("href");

	Swal.fire({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, delete it!",
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
		}
	});
});
$(".keluar").on("click", function (e) {
	e.preventDefault();
	const href = $(this).attr("href");
	const options = {
		weekday: "long",
		year: "numeric",
		month: "long",
		day: "numeric",
	};
	const tanggal = new Date().toLocaleDateString("id-ID", options);

	Swal.fire({
		title: "Yakin?",
		html:
			"Anda tidak akan dapat mengembalikan ini! <br>Pasien Keluar Rawat Inap pada <br><strong>" +
			tanggal +
			"</strong>",
		icon: "question",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Ya",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
		}
	});
});

$(document).ready(function () {
	const flashdataElement = document.getElementById("flashdata");
	const loginSuccess = flashdataElement.getAttribute("data-login-success");
	const loginError = flashdataElement.getAttribute("data-login-error");

	if (loginSuccess) {
		const Toast = Swal.mixin({
			toast: true,
			position: "top-end",
			showConfirmButton: false,
			timer: 2000,
			timerProgressBar: false,
			didOpen: (toast) => {
				toast.onmouseenter = Swal.stopTimer;
				toast.onmouseleave = Swal.resumeTimer;
			},
		});
		Toast.fire({
			icon: "success",
			title: "Signed in successfully",
		}).then((result) => {
			if (result) {
			}
		});
	} else if (loginError) {
		Swal.fire({
			title: "Error",
			text: loginError,
			icon: "error",
		});
	}
});

//image

$(".custom-file-input").on("change", function () {
	let fileName = $(this).val().split("\\").pop();
	$(this).next(".custom-file-label").addClass("selected").html(fileName);
});

// UPDATE STATUS CHECK DOKTER
$(document).ready(function () {
	$(".status_dokter").click(function () {
		var button = $(this);
		var isActive = button.attr("data-is-active") === "true";
		var no_dokter = button.attr("data-id");

		if (isActive) {
			button.html('<i class="fas fa-xl text-danger fa-thin fa-xmark"></i>');
			button.attr("data-is-active", "false");
		} else {
			button.html('<i class="fas fa-xl text-success fa-thin fa-check"></i>');
			button.attr("data-is-active", "true");
		}

		var newStatus = button.attr("data-is-active") === "true" ? 1 : 0;

		$.ajax({
			url: "http://localhost/new-simrs/admin/status_dokter",
			type: "POST",
			data: {
				no_dokter: no_dokter,
				is_active: newStatus,
			},
		});
	});
});
// UPDATE STATUS CHECK PASIEN
$(document).ready(function () {
	$(".status_pasien").click(function () {
		var button = $(this);
		var isActive = button.attr("data-is-active") === "true";
		var no_medis = button.attr("data-id");

		if (isActive) {
			button.html('<i class="fas fa-xl text-danger fa-thin fa-xmark"></i>');
			button.attr("data-is-active", "false");
		} else {
			button.html('<i class="fas fa-xl text-success fa-thin fa-check"></i>');
			button.attr("data-is-active", "true");
		}

		var newStatus = button.attr("data-is-active") === "true" ? 1 : 0;

		$.ajax({
			url: "http://localhost/new-simrs/admin/status_pasien",
			type: "POST",
			data: {
				no_medis: no_medis,
				is_active: newStatus,
			},
		});
	});
});

//menu modal
$(function () {
	$(".btnAdd").on("click", function () {
		$("#menuModalLabel").html("Add Menu");
		$(".modal-footer button[type=submit]").html("Add");
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
		$("#submenuModalLabel").html("Add Sub Menu");
		$(".modal-footer button[type=submit]").html("Add");
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

//role modal
$(function () {
	$(".btnAddRole").on("click", function () {
		$(".roleModalLabel").html("Add Role");
		$(".modal-footer button[type=submit]").html("Add");
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

const selectRuang = document.getElementById("ruang");
const kapasitasInfo = document.getElementById("kapasitas-info");

// Event listener untuk update kapasitas saat ruang dipilih
selectRuang.addEventListener("change", function () {
	const selectedOption = selectRuang.options[selectRuang.selectedIndex];
	const kapasitas = selectedOption.getAttribute("data-kapasitas");
	kapasitasInfo.textContent = kapasitas ? `${kapasitas}` : "Kapasitas";
});


$(function () {
	$(".btnEdit").on("click", function () {
		$("#pasien").show();
		$("#v_pasien").hide();
	});

	$(".pasienModal").on("click", function () {
		$("#pasien").hide();
		$("#v_pasien").show();
	});
});

$(function () {
	$(".pasienModal").on("click", function () {
		$("#pasienModalLabel").html("Edit Ruang");
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
				$("#v_pasien").val(data.id_pasien);
				$("#no_telp").val(data.no_telp);
				$("#ruang").val(data.id_ruang);
				$("#v_ruang").val(data.id_ruang);
				$("#tanggal_masuk").val(data.tanggal_masuk);
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

//ruang modal
$(function () {
	$(".btnAddRuang").on("click", function () {
		$("#ruangModalLabel").html("Tambah Ruang");
		$(".modal-footer button[type=submit]").html("Tambah");
	});

	// edit ruang
	$(".ruangModal").on("click", function () {
		$("#ruangModalLabel").html("Edit Ruang");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/menuadmin/update/"
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


	// end edit 
});


//tindakan modal
$(function () {
	$(".btnTindakan").on("click", function () {		
		$("#tindakanModalLabel").html("Tambah Tindakan");
		$(".modal-footer button[type=submit]").html("Tambah");
	});


	$(".tindakanModalDokter").on("click", function () {
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

// tindakan dokter Modal
$(function () {
	$(".btnTindakanDokter").on("click", function () {
		
		
		$("#tindakanDokterModalLabel").html("Tambah Tindakan");
		$(".modal-footer button[type=submit]").html("Tambah");
	});


	$(".tindakanDokterModal").on("click", function () {
		$("#tindakanDokterModalLabel").html("Edit Tindakan");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/dokter/editTindakan/"
		);
		const id = $(this).data("id");
		
		
		$.ajax({
			url: "http://localhost/new-simrs/dokter/getEditTindakanDokter/",
			data: { id_tindakan_pasien: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				if (data) {
					$("#id_tindakan_pasien").val(data[0].id_tindakan_pasien);
					$("#id_visite").val(data[0].id_visite);
					// $("#nama_dokter").val(data[0].nama_dokter);
					$("#nama_pasien").val(data[0].id_pasien);
					$("#ruang").val(data[0].nama_ruang);
					$("#id_tindakan").val(data[0].id_tindakan);
					$("#id_rawat").val(data[0].id_rawat);
					$("#id_ruang").val(data[0].id_ruang);
					$("#tanggal_tindakan").val(data[0].tanggal_tindakan);
					$("#catatan").val(data[0].catatan);
					
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});


                                // $("#id_tindakan_pasien").val(data[0].id_tindakan_pasien);
                                // $("#id_visite").val(data[0].id_visite);
                                // $("#nama_dokter").val(data[0].nama_dokter);
                                // $("#nama_pasien").val(data[0].id_pasien);
                                // $("#ruang").val(data[0].nama_ruang);
                                // $("#id_rawat").val(data[0].id_rawat);
                                // $("#id_ruang").val(data[0].id_ruang);
                                // $("#id_tindakan").val(data[0].id_tindakan);
                                // $("#tanggal_tindakan").val(data[0].tanggal_tindakan);
                                // $("#catatan").val(data[0].catatan);

//dokter visite modal
$(function () {
	$(".btnVisite").on("click", function () {
		$("#visiteModalLabel").html("Visite Dokter");
		$(".modal-footer button[type=submit]").html("Tambah");
	});
	$(".visiteModal").on("click", function () {
		$("#visiteModalLabel").html("Visite Dokter");
		$(".modal-footer button[type=submit]").html("Edit");
		
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/dokter/editvisite/"
		);
		

		const id = $(this).data("id");

		$.ajax({
			url: "http://localhost/new-simrs/dokter/getEditVisite/",
			data: { id_visite: id },
			method: "post",
			dataType: "json",
			success: function (data) {
				

				if (data) {
					$("#id_visite").val(data.id_visite);
					$("#id_ruang").val(data.id_ruang);
					$("#nama_pasien").val(data.id_pasien);
					$("#no_telp").val(data.no_telp);
					$("#ruang").val(data.nama_ruang);
					$("#tanggal_visite").val(data.tanggal_visite);
					$("#catatan").val(data.catatan);
				} else {
					console.error("Data is null or undefined");
				}
			},
		});
	});
});

//search2 tindakan
$(document).ready(function() {
	console.log("Inisialisasi Select2 dimulai...");
	$('#id_tindakan').select2({
		placeholder: "---Pilih Nama Tindakan---",
		allowClear: true
	});
	console.log("Inisialisasi Select2 selesai.");
});