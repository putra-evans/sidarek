<script type="text/javascript">
    $(function() {

        // Global Variabel
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var site = '<?php echo site_url(); ?>';
        var mainTbl;
        var desatbl;

        // Define Datatable of Sektor
        mainTbl = $('#mainTbl').dataTable({
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "kemiskinan/kemiskinan/listview",
                type: "POST",
                data: function(d) {
                    d.param = $('#formFilter').serializeArray();
                    d.csrf_test_name = csrfHash;
                },
            },
            columns: [{
                    data: "index"
                },
                {
                    data: "tipe_daerah",
                    className: "text-center",
                },
                {
                    data: "bulan_kemiskinan",
                    className: "text-center",
                },
                {
                    data: "jumlah_kemiskinan",
                    className: "text-center",
                },
                {
                    data: "action",
                    className: "text-center",
                }
            ],
            columnDefs: [{
                    targets: [0], //first column
                    orderable: false, //set not orderable
                },
                {
                    targets: [-1], //last column
                    orderable: false, //set not orderable
                },
            ],

        });

        $('#mainTbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#mainTbl_length select').addClass('form-control');

        mainTbl.on('xhr.dt', function(e, settings, json, xhr) {
            // //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
        });

        // Define Datatable of Komoditi
        desatbl = $('#desatbl').dataTable({
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "kemiskinan/kemiskinan/fetch",
                type: "POST",
                data: function(d) {
                    d.param = $('#formFilter').serializeArray();
                    d.csrf_test_name = csrfHash;
                },
            },
            columns: [{
                    data: "index"
                },
                {
                    data: "tipe_daerah",
                    className: "text-center",
                },
                {
                    data: "bulan_kemiskinan",
                    className: "text-center",
                },
                {
                    data: "jumlah_kemiskinan",
                    className: "text-center",
                },
                {
                    data: "action",
                    className: "text-center",
                }
            ],
            columnDefs: [{
                    targets: [0], //first column
                    orderable: false, //set not orderable
                },
                {
                    targets: [-1], //last column
                    orderable: false, //set not orderable
                },
            ],

        });

        $('#desatbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#desatbl_length select').addClass('form-control');

        // desatbl.on('xhr.dt', function(e, settings, json, xhr) {
        //     // //(json);
        //     csrfHash = json.csrf.csrfHash;
        //     $('input[name="' + csrfName + '"]').val(csrfHash);
        // });

        // Loading Wait me
        function run_waitMe(el) {
            el.waitMe({
                effect: 'facebook',
                text: 'Please wait...',
                bg: 'rgba(255,255,255,0.7)',
                color: '#000',
                maxSize: 100,
                waitTime: -1,
                textPos: 'vertical',
                source: '',
                fontSize: '',
                onClose: function(el) {}
            });
        }

        // Form Reset Sektor
        function formReset() {
            $('#formEntry').attr('action', site + 'kemiskinan/kemiskinan/create');
            $('#errEntry').html('');
            $('.help-block').text('');
            $('.required').removeClass('has-error');
            $('form#formEntry').trigger('reset');
            $('.lblPass').text('*');
            $('#daerah').select2('val', '');
        }

        // On Close
        $(document).on('click', '.btnClose', function(e) {
            formReset();
            $('#modalEntryForm').modal('toggle');
        });

        // On Add
        $(document).on('click', '#btnAdd', function(e) {
            formReset();
            $('#judul-form').html('ENTRI ');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        // On Edit Data Perkotaan
        $(document).on('click', '.btnEdit', function(e) {
            $('#judul-form').html('EDIT ');
            var data = mainTbl.api().row($(this).parents('tr')).data();
            e.stopPropagation();
            formReset();
            $('#formEntry').attr('action', site + 'kemiskinan/kemiskinan/update');
            $('#id_kemiskinan').val(data.id_kemiskinan);
            $('#daerah').select2('val', data.tipe_daerah);
            $('#add_monday_date').val(data.bulan_kemiskinan);
            $('#jumlah_pdd').val(data.jumlah_kemiskinan);
            $('.lblPass').text('');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });


        // On Edit Data Pedesaan
        $(document).on('click', '.btnEditData', function(e) {
            $('#judul-form').html('EDIT ');
            var data = desatbl.api().row($(this).parents('tr')).data();
            e.stopPropagation();
            formReset();
            $('#formEntry').attr('action', site + 'kemiskinan/kemiskinan/update');
            $('#id_kemiskinan').val(data.id_kemiskinan);
            $('#daerah').select2('val', data.tipe_daerah);
            $('#add_monday_date').val(data.bulan_kemiskinan);
            $('#jumlah_pdd').val(data.jumlah_kemiskinan);
            $('.lblPass').text('');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        // On Submit
        $('#formEntry').submit(function(e) {
            e.preventDefault();
            var postData = $(this).serialize();
            var formActionURL = $(this).attr("action");
            $("#save").html('<i class="fa fa-hourglass-half"></i> DIPROSES...');
            $("#save").addClass('disabled');
            run_waitMe($('#frmEntry'));
            bootbox.dialog({
                title: "Konfirmasi",
                message: "Apakah anda akan menyimpan data ini ?",
                buttons: {
                    "cancel": {
                        "label": "<i class='fa fa-times'></i> Tidak",
                        "className": "btn-danger",
                        callback: function(response) {
                            if (response) {
                                $("#save").html('<i class="fa fa-check"></i> SUBMIT');
                                $("#save").removeClass('disabled');
                                $('#frmEntry').waitMe('hide');
                            }
                        }
                    },
                    "main": {
                        "label": "<i class='fa fa-check'></i> Ya, Lanjutkan",
                        "className": "btn-primary",
                        callback: function(response) {
                            if (response) {
                                var formData = new FormData(document.getElementById("formEntry"));
                                $.ajax({
                                        url: formActionURL,
                                        type: "POST",
                                        data: formData,
                                        dataType: "json",
                                        processData: false, // tell jQuery not to process the data
                                        contentType: false
                                    }).done(function(data) {
                                        csrfName = data.csrf.csrfName;
                                        csrfHash = data.csrf.csrfHash;
                                        $('input[name="' + csrfName + '"]').val(csrfHash);
                                        $('.help-block').text('');
                                        $('.required').removeClass('has-error');
                                        if (data.status == 0) {
                                            $('#errEntry').html('<div class="alert alert-danger" id="pesanErr"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                                            $.each(data.message, function(key, value) {
                                                if (key != 'isi')
                                                    $('input[name="' + key + '"], select[name="' + key + '"], textarea[name="' + key + '"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                                                else {
                                                    $('#pesanErr').html('<strong>Peringatan!</strong> ' + value);
                                                }
                                            });
                                            $('#modalEntryForm').animate({
                                                scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, textarea, select').first().focus().offset().top - 300)
                                            }, 'slow');
                                        } else {
                                            $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                                                '<strong>Sukses!</strong> ' + data.message +
                                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                                '</div>');
                                            $('#modalEntryForm').modal('toggle');
                                            mainTbl.api().ajax.reload(null, false);
                                            desatbl.api().ajax.reload(null, false);
                                        }
                                        $('#frmEntry').waitMe('hide');
                                    })
                                    .fail(function(data) {
                                        $('#errEntry').html('<div class="alert alert-danger">' +
                                            '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
                                            '</div>');
                                        $('#frmEntry').waitMe('hide');
                                    }).always(function() {
                                        $("#save").html('<i class="fa fa-check"></i> SUBMIT');
                                        $("#save").removeClass('disabled');
                                    });
                            }
                        }
                    }
                }
            });
        });


        // On Delete
        $(document).on('click', '.btnDelete', function(e) {
            e.preventDefault();
            var itemID = $(this).data('id');
            // //(itemID)
            var postData = {
                'id_kemiskinan': itemID,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            };
            // //(postData);
            run_waitMe($('#formParent'));
            bootbox.dialog({
                title: "Konfirmasi",
                message: "Apakah anda ingin menghapus data produk tersebut ?",
                buttons: {
                    "cancel": {
                        "label": "<i class='fa fa-times'></i> Tidak",
                        "className": "btn-danger",
                        callback: function(response) {
                            if (response) {
                                $('#formParent').waitMe('hide');
                            }
                        }
                    },
                    "main": {
                        "label": "<i class='fa fa-check'></i> Ya, Lanjutkan",
                        "className": "btn-primary",
                        callback: function(response) {
                            if (response) {
                                $.ajax({
                                    url: site + 'kemiskinan/kemiskinan/delete',
                                    type: "POST",
                                    data: postData,
                                    dataType: "json",
                                }).done(function(data) {
                                    // //(data);
                                    csrfName = data.csrf.csrfName;
                                    csrfHash = data.csrf.csrfHash;
                                    $('input[name="' + csrfName + '"]').val(csrfHash);
                                    if (data.status == 0) {
                                        $('#errSuccess').html('<div class="alert alert-danger">' +
                                            '<strong>Informasi!</strong> ' + data.message +
                                            '</div>');
                                    } else {
                                        $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                                            '<strong>Sukses!</strong> ' + data.message +
                                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                            '</div>');
                                        mainTbl.api().ajax.reload(null, false);
                                        desatbl.api().ajax.reload(null, false);
                                    }
                                    $('#formParent').waitMe('hide');
                                }).fail(function() {
                                    // //('masuk fail');
                                    $('#errSuccess').html('<div class="alert alert-danger">' +
                                        '<strong>Peringatan!</strong> Proses delete data gagal...' +
                                        '</div>');
                                    $('#formParent').waitMe('hide');
                                }).always(function() {
                                    $('#btnDelete').html('<i class="fa fa-trash-o"></i> Delete User');
                                    $('#btnDelete').removeClass('disabled');
                                });
                            }
                        }
                    }
                }
            });
        });

    });
    $(document).ready(function() {
        $("#monday_date_datepicker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#add_monday_date").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#monday_date_datepicker1").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#add_monday_date1").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
    });
</script>