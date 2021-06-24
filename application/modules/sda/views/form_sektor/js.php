<script type="text/javascript">
    $(function() {

        // Global Variabel
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var site = '<?php echo site_url(); ?>';
        var sektortbl;
        var komodititbl;
        var idsektor = null;
        var idsektorforkomoditi = null;

        // Define Datatable of Sektor
        sektortbl = $('#sektortbl').dataTable({
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "sda/sektor/listview",
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
                    data: "sektor"
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

        sektortbl.on('xhr.dt', function(e, settings, json, xhr) {
            //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
            $('#id_sektor_for_komoditi').append(json.sektoroptions);
        });

        $('#sektortbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#sektortbl_length select').addClass('form-control');

        // Define Datatable of Komoditi
        komodititbl = $('#komodititbl').dataTable({
            deferRender: true,
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "sda/sektor/fetch",
                type: "POST",
                data: function(d) {
                    d.param = $('#formFilter').serializeArray();
                    d.idsektor = idsektor;
                    d.csrf_test_name = csrfHash;
                },
            },
            columns: [{
                    data: "index"
                },
                {
                    data: "komoditi"
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

        $('#komodititbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#komodititbl_length select').addClass('form-control');

        komodititbl.on('xhr.dt', function(e, settings, json, xhr) {
            //('json');
            //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
            $('#id_sektor_filter').append(json.sektoroptions);
        });

        $(document).on('click', '.btnLook', function(e) {

            var data = sektortbl.api().row($(this).parents('tr')).data();
            //(data);

            $('#sektor-name').html(data.sektor);

            idsektor = data.id_sektor;
            komodititbl.api().ajax.reload();
            idsektorforkomoditi = data.id_sektor;
        });


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



        /**
         * Form Sektor
         */
        // Close Form Entri

        // Form Reset Sektor
        function formResetSektor() {
            $('#formEntry').attr('action', site + 'sda/sektor/create');
            $('#errEntry').html('');
            $('.help-block').text('');
            $('.required').removeClass('has-error');
            $('form#formEntry').trigger('reset');
            $('.lblPass').text('*');

            $('#nama_sektor').val('');
        }

        // On Close
        $(document).on('click', '.btnClose', function(e) {
            formResetSektor();
            $('#modalEntryForm').modal('toggle');
        });

        // On Add
        $(document).on('click', '#btnAdd', function(e) {
            formResetSektor();
            $('#judul-form').html('ENTRI ');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        // On Edit
        $(document).on('click', '.btnEdit', function(e) {

            $('#judul-form').html('EDIT ');

            var data = sektortbl.api().row($(this).parents('tr')).data();
            //(data);
            e.stopPropagation();
            formResetSektor();
            $('#formEntry').attr('action', site + 'sda/sektor/update');


            $('#id_sektor').val(data.id_sektor);
            $('#nama_sektor').val(data.sektor);

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

                                //(Object.fromEntries(formData));

                                $.ajax({
                                        url: formActionURL,
                                        type: "POST",
                                        data: formData,
                                        dataType: "json",
                                        processData: false, // tell jQuery not to process the data
                                        contentType: false
                                    }).done(function(data) {
                                        //('data nya apa');
                                        //(data);
                                        csrfName = data.csrf.csrfName;
                                        csrfHash = data.csrf.csrfHash;
                                        $('input[name="' + csrfName + '"]').val(csrfHash);
                                        $('.help-block').text('');
                                        $('.required').removeClass('has-error');
                                        if (data.status == 0) {
                                            //('masuk status 0');

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
                                            //('masuk status 1');
                                            $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                                                '<strong>Sukses!</strong> ' + data.message +
                                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                                '</div>');
                                            $('#modalEntryForm').modal('toggle');
                                            sektortbl.api().ajax.reload(null, false);
                                        }
                                        $('#frmEntry').waitMe('hide');
                                    })
                                    .fail(function(data) {
                                        //('masuk fail');
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

        /**
         * End of Sector Form
         */


        /**
         * Form Komoditi
         */

        // Form Reset Komoditi
        function formResetKomoditi() {
            $('#formKomoditi').attr('action', site + 'sda/komoditi/create');
            $('#errEntry').html('');
            $('.help-block').text('');
            $('.required').removeClass('has-error');
            $('form#formKomoditi').trigger('reset');
            $('.lblPass').text('*');

            $('#nama_komoditi').val('');
        }

        $(document).on('click', '.btnCloseKomoditi', function(e) {
            formResetKomoditi();
            $('#modalKomoditi').modal('toggle');
        });

        // On Add
        $(document).on('click', '#btnAddKomoditi', function(e) {
            formResetKomoditi();

            $("#id_sektor_for_komoditi").select2("val", idsektorforkomoditi);
            $('#judul-form-komoditi').html('ENTRI ');
            $('#modalKomoditi').modal({
                backdrop: 'static'
            });
        });

        // On Edit
        $(document).on('click', '.btnEditKomoditi', function(e) {

            $('#judul-form-komoditi').html('EDIT ');

            var data = komodititbl.api().row($(this).parents('tr')).data();
            //(data);
            e.stopPropagation();
            formResetKomoditi();
            $('#formKomoditi').attr('action', site + 'sda/komoditi/update');

            $('#id_komoditi').val(data.id_komoditi);
            $('#id_sektor_for_komoditi').val(data.id_sektor).trigger('change');

            $('#nama_komoditi').val(data.komoditi);

            $('.lblPass').text('');
            $('#modalKomoditi').modal({
                backdrop: 'static'
            });
        });

        // On Submit
        $('#formKomoditi').submit(function(e) {
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

                                var formData = new FormData(document.getElementById("formKomoditi"));
                                //('formData');
                                //(formData);

                                $.ajax({
                                        url: formActionURL,
                                        type: "POST",
                                        data: formData,
                                        dataType: "json",
                                        processData: false, // tell jQuery not to process the data
                                        contentType: false
                                    }).done(function(data) {
                                        //('data nya apa');
                                        //(data);
                                        csrfName = data.csrf.csrfName;
                                        csrfHash = data.csrf.csrfHash;
                                        $('input[name="' + csrfName + '"]').val(csrfHash);
                                        $('.help-block').text('');
                                        $('.required').removeClass('has-error');
                                        if (data.status == 0) {
                                            //('masuk status 0');

                                            $('#errEntry').html('<div class="alert alert-danger" id="pesanErr"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                                            $.each(data.message, function(key, value) {
                                                if (key != 'isi')
                                                    $('input[name="' + key + '"], select[name="' + key + '"], textarea[name="' + key + '"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                                                else {
                                                    $('#pesanErr').html('<strong>Peringatan!</strong> ' + value);
                                                }
                                            });
                                            $('#modalKomoditi').animate({
                                                scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, textarea, select').first().focus().offset().top - 300)
                                            }, 'slow');
                                        } else {
                                            //('masuk status 1');
                                            $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                                                '<strong>Sukses!</strong> ' + data.message +
                                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                                '</div>');
                                            $('#modalKomoditi').modal('toggle');
                                            komodititbl.api().ajax.reload(null, false);
                                        }
                                        $('#frmEntry').waitMe('hide');
                                    })
                                    .fail(function(data) {
                                        //('masuk fail');
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
        $(document).on('click', '.btnDeleteKomoditi', function(e) {
            e.preventDefault();
            var itemID = $(this).data('id');
            // //(itemID)
            var postData = {
                'id_komoditi': itemID,
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
                                    url: site + 'sda/komoditi/delete',
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
                                        komodititbl.api().ajax.reload(null, false);
                                        // secTbl.api().ajax.reload(null, false);
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
</script>