

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
			"Anda tidak akan dapat mengembalikan ini! <br>Pasien Keluar Ruangan pada <br><strong>" +
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
