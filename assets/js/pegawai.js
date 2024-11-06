console.log('pegawi');

//visite
//pegawai visite modal
$(function () {
    $(".btnVisite").on("click", function () {
        $("#visiteModalLabel").html("Visite Dokter");
        $(".modal-footer button[type=submit]").html("Tambah");
        $("#ruang").show();
        $("#ruang_igd").hide();
    });
    $(".visiteModal").on("click", function () {
        $("#visiteModalLabel").html("Edit Visite Dokter");
        $(".modal-footer button[type=submit]").html("Edit");

        $(".modal-body form").attr(
            "action",
            "http://localhost/new-simrs/pegawai/editvisite/"
        );

        const id = $(this).data("id");

        $.ajax({
            url: "http://localhost/new-simrs/pegawai/getEditVisite/",
            data: { id_visite: id },
            method: "post",
            dataType: "json",
            success: function (data) {
                if (data) {
                    $("#id_visite").val(data.id_visite);
                    $("#id_ruang").val(data.id_ruang);
                    $("#id_ruang_igd").val(data.id_ruang_igd);
                    $("#nama_pasien").val(data.id_pasien);
                    $("#no_telp").val(data.no_telp);
                    $("#ruang").val(data.nama_ruang);
                    $("#ruang_igd").val(data.nama_ruang_igd);
                    $("#tanggal_visite").val(data.tanggal_visite);
                    $("#catatan").val(data.catatan);
                } else {
                    console.error("Data is null or undefined");
                }
                if (data.nama_ruang) {
                    $("#ruang").val(data.nama_ruang).show();
                    $("#ruang_igd").hide();
                } else if (data.nama_ruang_igd) {
                    $("#ruang_igd").val(data.nama_ruang_igd).show();
                    $("#ruang").hide();
                } else {
                    $("#ruang").hide();
                    $("#ruang_igd").hide();
                }
            },
        });
    });
});

// tindakan pegawai Modal
$(function () {
	$(".btnTindakanDokter").on("click", function () {
		$("#tindakanDokterModalLabel").html("Tambah Tindakan Pasien");
		$(".modal-footer button[type=submit]").html("Tambah");
        $("#ruang").show();
        $("#ruang_igd").hide();
	});

	$(".tindakanDokterModal").on("click", function () {
		$("#tindakanDokterModalLabel").html("Edit Tindakan Pasien");
		$(".modal-footer button[type=submit]").html("Edit");
		$(".modal-body form").attr(
			"action",
			"http://localhost/new-simrs/pegawai/editTindakan/"
		);
		const id = $(this).data("id");

		$.ajax({
			url: "http://localhost/new-simrs/pegawai/getEditTindakanDokter/",
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
					$("#ruang_igd").val(data[0].nama_ruang_igd);
					$("#id_tindakan").val(data[0].id_tindakan);
					$("#id_pelayanan").val(data[0].id_pelayanan);
					$("#id_ruang").val(data[0].id_ruang);
					$("#id_ruang_igd").val(data[0].id_ruang_igd);
					$("#biaya").val(data[0].biaya);
					$("#tanggal_tindakan").val(data[0].tanggal_tindakan);
					$("#catatan").val(data[0].catatan);
				} else {
					console.error("Data is null or undefined");
				}

                if (data[0].nama_ruang) {
                    $("#ruang").val(data[0].nama_ruang).show();
                    $("#ruang_igd").hide();
                } else if (data[0].nama_ruang_igd) {
                    $("#ruang_igd").val(data[0].nama_ruang_igd).show();
                    $("#ruang").hide();
                } else {
                    $("#ruang").hide();
                    $("#ruang_igd").hide();
                }
			},
		});
	});
});