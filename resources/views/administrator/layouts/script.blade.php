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
    
    $(document).ready(function() {
        $('.btn-status-user').on('click', function() {
            var id = $(this).attr('id');

            $('.btn-status-user-modal').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: `user/delete/${id}`,
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            alert('Status berhasil diubah');
                        } else if (res.status == 'failed') {
                            alert('Status gagal diubah');
                        }

                        location.reload();
                    }
                });
            });
        });

        $('.btn-status-lab').on('click', function() {
            var id = $(this).attr('id');

            $('.btn-status-lab-modal').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: `lab/delete/${id}`,
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            alert('Status berhasil diubah');
                        } else if (res.status == 'failed') {
                            alert('Status gagal diubah');
                        }

                        location.reload();
                    }
                });
            });
        });

        $('.btn-status-inventaris').on('click', function() {
            var id = $(this).attr('id');

            $('.btn-status-inventaris-modal').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: `inventaris/delete/${id}`,
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            alert('Status berhasil diubah');
                        } else if (res.status == 'failed') {
                            alert('Status gagal diubah');
                        }

                        location.reload();
                    }
                });
            });
        });

        $('.btn-status-jurnal').on('click', function() {
            var id = $(this).attr('id');

            $('.btn-status-jurnal-modal').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: `jurnal/delete/${id}`,
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            alert('Status berhasil diubah');
                        } else if (res.status == 'failed') {
                            alert('Status gagal diubah');
                        }

                        location.reload();
                    }
                });
            });
        });

        $('.btn-status-maintenance').on('click', function() {
            var id = $(this).attr('id');

            $('.btn-status-maintenance-modal').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: `maintenance/delete/${id}`,
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            alert('Status berhasil diubah');
                        } else if (res.status == 'failed') {
                            alert('Status gagal diubah');
                        }

                        location.reload();
                    }
                });
            });
        });

        $('.btn-status-peminjamanalat').on('click', function() {
            var id = $(this).attr('id');

            $('.btn-status-peminjamanalat-modal').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: `peminjamanalat/delete/${id}`,
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            alert('Status berhasil diubah');
                        } else if (res.status == 'failed') {
                            alert('Status gagal diubah');
                        }

                        location.reload();
                    }
                });
            });
        });

        $('.btn-status-peminjamanlab').on('click', function() {
            var id = $(this).attr('id');

            $('.btn-status-peminjamanlab-modal').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: `peminjamanlab/delete/${id}`,
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            alert('Status berhasil diubah');
                        } else if (res.status == 'failed') {
                            alert('Status gagal diubah');
                        }

                        location.reload();
                    }
                });
            });
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