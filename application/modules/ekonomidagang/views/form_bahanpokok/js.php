<script type="text/javascript">
    $(function() {

        // Global Variabel
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var site = '<?php echo site_url(); ?>';
        var idProfilBU = '<?php echo isset($id_profil_bu) ? $id_profil_bu : ''; ?>';
        var mainTbl;
        var id_komoditas_for_jenis = null;
        var id_kategori_for_jenis = null;

        // Define Datatable
        mainTbl = $('#mainTbl').dataTable({
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            // dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            //     "<'row'<'col-sm-12'tr>>" +
            //     "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            // buttons: [{
            //     text: '<i class="fa fa-plus"></i> Tambah Data',
            //     attr: {
            //         title: 'Add Button',
            //         class: 'btn btn-primary',
            //         id: 'btnAdd'
            //     },
            // }],
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "ekonomidagang/bahanpokok/listview/",
                type: "POST",
                data: function(d) {
                    d.param = $('#formFilter').serializeArray();
                    d.csrf_test_name = csrfHash;
                },
            },
            columns: [{
                    data: "index",
                    className: "text-center",
                },
                {
                    data: "nama_komoditas",
                    className: "text-left",
                },
                {
                    data: "nama_kategori",
                    className: "text-left",
                    sDefaultContent: "-",
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

        mainTbl.on('xhr.dt', function(e, settings, json, xhr) {
            //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);

            $('#id_komoditas_for_jenis').empty().trigger("change");
            $('#id_kategori_for_jenis').empty().trigger("change");
            $('#id_komoditas_for_jenis').append(json.komoditas_options);
            $('#id_kategori_for_jenis').append(json.kategori_options);
        });

        $('#mainTbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#mainTbl_length select').addClass('form-control');

        // Define Second Datatables
        secondTbl = $('#secondTbl').dataTable({
            deferRender: true,
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                text: '<i class="fa fa-plus"></i> Tambah Data',
                attr: {
                    title: 'Add Button',
                    class: 'btn btn-primary',
                    id: 'btnAddKomoditi'
                },
            }],
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "ekonomidagang/komoditas/listview",
                type: "POST",
                data: function(d) {
                    d.param = $('#formFilter').serializeArray();
                    d.id_komoditas_for_jenis = id_komoditas_for_jenis;
                    d.id_kategori_for_jenis = id_kategori_for_jenis;
                    d.csrf_test_name = csrfHash;
                },
            },
            columns: [{
                    data: "index",
                    className: "text-center"
                },
                {
                    data: "nama"
                },
                {
                    data: "satuan",
                    className: "text-center"
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

        $('#secondTbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#secondTbl_length select').addClass('form-control');

        secondTbl.on('xhr.dt', function(e, settings, json, xhr) {
            //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
        });


        $(document).on('click', '.btnLook', function(e) {

            var data = mainTbl.api().row($(this).parents('tr')).data();
            //(data);

            id_komoditas_for_jenis = data.id_komoditas;
            id_kategori_for_jenis = data.id_komoditas_kategori == '' ? null : data.id_komoditas_kategori;
            $('#id_komoditas_for_jenis').val(id_komoditas_for_jenis).trigger('change');
            if (id_kategori_for_jenis) {
                $('#id_kategori_for_jenis').val(id_kategori_for_jenis).trigger('change');
            } else {
                $('#id_kategori_for_jenis').val('').trigger('change');
                $('#id_kategori_for_jenis').prop('disabled', true);
            }


            secondTbl.api().ajax.reload();
        });



        // Form Reset
        function formReset() {
            $('#formEntry').attr('action', site + 'ekonomidagang/bahanpokok/create');
            $('#errEntry').html('');
            $('.help-block').text('');
            $('.required').removeClass('has-error');
            $('form#formEntry').trigger('reset');
            $('.lblPass').text('*');


            $('#id_komoditas').val('');
            $('#nama_komoditas').val('');
            $('#nama_kategori').val('');

        }

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

        // Close Form Entri
        $(document).on('click', '.btnClose', function(e) {
            formReset();
            $('#modalEntryForm').modal('hide');
        });

        // Button Add
        $(document).on('click', '#btnAdd', function(e) {

            var descBox = $('.descBox');
            descBox.empty();
            $('.add').show();
            $('.showupdate').hide();
            formReset();
            $('#judul-form').html('ENTRI ');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnEdit', function(e) {

            $('#judul-form').html('EDIT ');

            var data = mainTbl.api().row($(this).parents('tr')).data();
            //(data);
            e.stopPropagation();
            $('#formEntry').attr('action', site + 'ekonomidagang/bahanpokok/update');

            $('#id_komoditas_harga').val(data.id_komoditas_harga);

            $('#id_komoditas').val(data.id_komoditas);
            $('#id_komoditas_kategori').val(data.id_komoditas_kategori);

            $('#nama_komoditas').val(data.nama_komoditas);
            $('#nama_kategori').val(data.nama_kategori);
            $('#satuan').val(data.satuan);

            $('.lblPass').text('');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnDelete', function(e) {

            e.preventDefault();

            var itemID = $(this).data('id');
            var postData = {
                'id_komoditas_harga': itemID,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            };
            //(postData);
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
                                    url: site + 'ekonomidagang/bahanpokok/delete',
                                    type: "POST",
                                    data: postData,
                                    dataType: "json",
                                }).done(function(data) {
                                    //(data);
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
                                    }
                                    $('#formParent').waitMe('hide');
                                }).fail(function() {
                                    //('masuk fail');
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

        // Form Entry On Sumbit
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
                                            mainTbl.api().ajax.reload(null, false);
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

        // Filter on Submit
        $('#formFilter').submit(function(e) {
            e.preventDefault();
            var serialized = $(this).serializeArray();
            mainTbl.api().ajax.reload();
        });

        var SI_SYMBOL = ["", "Ribu", "Juta", "Miliar", "Triliun", "P", "E"];

        function abbreviateNumber(number) {

            // what tier? (determines SI symbol)
            var tier = Math.log10(number) / 3 | 0;

            // if zero, we don't need a suffix
            if (tier == 0) return number;

            // get suffix and determine scale
            var suffix = SI_SYMBOL[tier];
            var scale = Math.pow(10, tier * 3);

            // scale the number
            var scaled = number / scale;

            // format number and add suffix
            return scaled + ' ' + suffix;
        }



        /**
         * Form Jenis KOmoditi
         */

        // Define Datatable of Komoditi





        // On Add
        $(document).on('click', '#btnAddKomoditi', function(e) {
            //('jenis');


            $("#id_sektor_for_komoditi").select2("val", id_komoditas_for_jenis);
            $('#judul-form-komoditi').html('ENTRI ');
            $('#modalJenis').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnEditJenis', function(e) {

            $('#judul-form').html('EDIT ');

            var data = secondTbl.api().row($(this).parents('tr')).data();
            //(data);
            e.stopPropagation();
            $('#formJenis').attr('action', site + 'ekonomidagang/komoditas/update');

            $('#id_komoditas_jenis').val(data.id_komoditas_jenis);

            $('#id_komoditas_for_jenis').val(data.id_komoditas);
            $('#id_kategori_for_jenis').val(data.id_komoditas_kategori);

            $('#nama_komoditas').val(data.nama_komoditas);
            $('#nama_kategori').val(data.nama_kategori);

            $('#nama_jenis').val(data.nama);
            $('#satuan').val(data.satuan).trigger('change');

            $('.lblPass').text('');
            $('#modalJenis').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnDeleteJenis', function(e) {

            e.preventDefault();

            var itemID = $(this).data('id');
            var postData = {
                'id_komoditas_jenis': itemID,
                '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
            };
            //(postData);
            run_waitMe($('#frmSecond'));
            bootbox.dialog({
                title: "Konfirmasi",
                message: "Apakah anda ingin menghapus data produk tersebut ?",
                buttons: {
                    "cancel": {
                        "label": "<i class='fa fa-times'></i> Tidak",
                        "className": "btn-danger",
                        callback: function(response) {
                            if (response) {
                                $('#frmSecond').waitMe('hide');
                            }
                        }
                    },
                    "main": {
                        "label": "<i class='fa fa-check'></i> Ya, Lanjutkan",
                        "className": "btn-primary",
                        callback: function(response) {
                            if (response) {
                                $.ajax({
                                    url: site + 'ekonomidagang/komoditas/delete',
                                    type: "POST",
                                    data: postData,
                                    dataType: "json",
                                }).done(function(data) {
                                    //(data);
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
                                        secondTbl.api().ajax.reload(null, false);
                                    }
                                    $('#frmSecond').waitMe('hide');
                                }).fail(function() {
                                    //('masuk fail');
                                    $('#errSuccess').html('<div class="alert alert-danger">' +
                                        '<strong>Peringatan!</strong> Proses delete data gagal...' +
                                        '</div>');
                                    $('#frmSecond').waitMe('hide');
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

        $(document).on('click', '.btnCloseKomoditi', function(e) {
            $('#modalJenis').modal('toggle');
        });

        // Form Entry On Sumbit
        $('#formJenis').submit(function(e) {
            e.preventDefault();
            var postData = $(this).serialize();
            var formActionURL = $(this).attr("action");
            $("#save").html('<i class="fa fa-hourglass-half"></i> DIPROSES...');
            $("#save").addClass('disabled');
            run_waitMe($('#frmSecond'));
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
                                $('#frmSecond').waitMe('hide');
                            }
                        }
                    },
                    "main": {
                        "label": "<i class='fa fa-check'></i> Ya, Lanjutkan",
                        "className": "btn-primary",
                        callback: function(response) {
                            if (response) {

                                var formData = new FormData(document.getElementById("formJenis"));

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
                                            $('#modalJenis').animate({
                                                scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, textarea, select').first().focus().offset().top - 300)
                                            }, 'slow');
                                        } else {
                                            //('masuk status 1');
                                            $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                                                '<strong>Sukses!</strong> ' + data.message +
                                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                                '</div>');
                                            $('#modalJenis').modal('toggle');
                                            secondTbl.api().ajax.reload(null, false);
                                        }
                                        $('#frmSecond').waitMe('hide');
                                    })
                                    .fail(function(data) {
                                        //('masuk fail');
                                        $('#errEntry').html('<div class="alert alert-danger">' +
                                            '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
                                            '</div>');
                                        $('#frmSecond').waitMe('hide');
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





    });
</script>