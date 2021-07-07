<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>

<script>
	$('.datepicker-start').datepicker({
		format: 'dd-mm-yyyy'
	});
	
	$('.datepicker-end').datepicker({
		format: 'dd-mm-yyyy'
	});

	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy'
	});

	$('.datepicker1').datepicker({
		format: 'dd-mm-yyyy'
	});

	$('.timepickerx').timepicker({
		showInputs: false,
		showMeridian: false
	});

	$('#btn_verifikasi_inventaris').click(function() {
		var verifikasi = [];

		$('.checkbox_verifikasi_inventaris:checked').not(':disabled').each(function(i) {
			verifikasi[i] = $(this).attr('value');
		});

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: 'verifikasi_inventaris',
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			},
			data: {
				id: verifikasi
			},
			success: function(res) {
				alert('Data berhasil diajukan');

				console.log(res)

				location.reload();
			}
		})
	});

	$('#btn_verifikasi_maintenance').click(function() {
		var verifikasi = [];

		$('.checkbox_verifikasi_maintenance:checked').not(':disabled').each(function(i){
			verifikasi[i] = $(this).attr('value');
		})

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: 'verifikasi_maintenance',
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			},
			data: {
				id: verifikasi
			},
			success: function(res) {
				alert('Data berhasil diajukan');

				console.log(res)

				location.reload();
			}
		})
	});

	$('#btn_verifikasi_jurnal').click(function() {
		var verifikasi = [];

		$('.checkbox_verifikasi_jurnal:checked').not(':disabled').each(function(i) {
			verifikasi[i] = $(this).attr('value');
		});

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: 'verifikasi_jurnal',
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			},
			data: {
				id: verifikasi
			},
			success: function(res) {
				alert('Data berhasil diajukan');

				console.log(res)

				location.reload();
			}
		})
	});

	$('#btn_verifikasi_peminjamanalat').click(function() {
		var verifikasi = [];

		$('.checkbox_verifikasi_peminjamanalat:checked').not(':disabled').each(function(i) {
			verifikasi[i] = $(this).attr('value');
		});

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: 'verifikasi_peminjamanalat',
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			},
			data: {
				id: verifikasi
			},
			success: function(res) {
				alert('Data berhasil diajukan');

				console.log(res)

				location.reload();
			}
		})
	});

	$('#btn_verifikasi_peminjamanlab').click(function() {
		var verifikasi = [];

		$('.checkbox_verifikasi_peminjamanlab:checked').not(':disabled').each(function(i) {
			verifikasi[i] = $(this).attr('value');
		});

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: 'verifikasi_peminjamanlab',
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			},
			data: {
				id: verifikasi
			},
			success: function(res) {
				alert('Data berhasil diajukan');
				
				console.log(res)
				
				location.reload();
			}
		})
	});

	$(document).ready(function() {
		$.ajax({
			method: 'GET',
			url: '../data_inventaris',
			header: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(res) {
				var ctx = document.getElementById('canvas_inventaris').getContext('2d');
				var chart = new Chart(ctx, {
					type: 'bar',
					title: 'Data Inventaris',
					data: {
						labels: Object.keys(res),
						datasets: [{
							label: 'Kondisi Barang',
							backgroundColor: 'rgba(20, 120, 180, 0.8)',
							data: Object.values(res)
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});
			}
		});
	});

	$(document).ready(function() {
		$.ajax({
			method: 'GET',
			url: '../data_maintenance',
			header: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(res) {
				var ctx1 = document.getElementById('canvas_maintenance1').getContext('2d');
				var chart1 = new Chart(ctx1, {
					type: 'bar',
					title: 'Data Maintenance',
					data: {
						labels: Object.keys(res[0]),
						datasets: [{
							label: 'Kondisi Hardware',
							backgroundColor: 'rgba(20, 120, 180, 0.8)',
							data: Object.values(res[0])
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});

				var ctx2 = document.getElementById('canvas_maintenance2').getContext('2d');
				var chart2 = new Chart(ctx2, {
					type: 'bar',
					title: 'Data Maintenance',
					data: {
						labels: Object.keys(res[1]),
						datasets: [{
							label: 'Kondisi Software',
							backgroundColor: 'rgba(20, 120, 180, 0.8)',
							data: Object.values(res[1])
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});
			}
		});
	});

	$(document).ready(function() {
		$.ajax({
			method: 'GET',
			url: '../data_peminjamanalat',
			header: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(res) {
				var ctx1 = document.getElementById('canvas_peminjamanalat1').getContext('2d');
				var chart1 = new Chart(ctx1, {
					type: 'bar',
					title: 'Data Peminjaman Alat',
					data: {
						labels: Object.keys(res[0]),
						datasets: [{
							label: 'Kondisi Barang Pinjam',
							backgroundColor: 'rgba(20, 120, 180, 0.8)',
							data: Object.values(res[0])
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});

				var ctx2 = document.getElementById('canvas_peminjamanalat2').getContext('2d');
				var chart2 = new Chart(ctx2, {
					type: 'bar',
					title: 'Data Peminjaman Alat',
					data: {
						labels: Object.keys(res[1]),
						datasets: [{
							label: 'Kondisi Barang Kembali',
							backgroundColor: 'rgba(20, 120, 180, 0.8)',
							data: Object.values(res[1])
						}]
					},
					options: {
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});
			}
		});
	});

	var canvas = document.querySelector("canvas");
	var signaturePad = new SignaturePad(canvas);

	signaturePad.fromDataURL("{{ isset($profil->sign) ? $profil->sign : NULL }}")

	function clear_sign() {
		signaturePad.clear();
	}

	function save_sign() {
		var sign = signaturePad.toDataURL();

		$('#sign').val(sign);

		alert('Tanda tangan disimpan');
	}
</script>