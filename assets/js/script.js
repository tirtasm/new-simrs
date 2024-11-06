console.log("tes");

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

// input check


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
		var no_pegawai = button.attr("data-id");

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
				no_pegawai: no_pegawai,
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











//search2 tindakan
$(document).ready(function () {
	console.log("Inisialisasi Select2 dimulai...");
	$("#id_tindakan").select2({
		placeholder: "---Pilih Nama Tindakan---",
		allowClear: true,
	});
	console.log("Inisialisasi Select2 selesai.");
});
