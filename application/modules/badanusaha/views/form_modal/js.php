<script type="text/javascript">
    $(function() {

        // Global Variabel
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var site = '<?php echo site_url(); ?>';
        var idProfilBU = '<?php echo isset($id_profil_bu) ? $id_profil_bu : ''; ?>';
        var penyertaanmodaltbl;

        // Define Datatable
        penyertaanmodaltbl = $('#penyertaanmodaltbl').dataTable({
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "badanusaha/modal/listview/" + idProfilBU,
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
                    data: "nama_badan_usaha",
                    className: "text-left",
                },
                {
                    data: "tahun",
                    className: "text-center",
                },
                {
                    data: "penyertaan_modal",
                    className: "text-right",
                    sDefaultContent: '0',
                    render: function(data, type, row, meta) {
                        return numberWithCommas(row.penyertaan_modal);
                    }
                },
                {
                    data: "dividen",
                    className: "text-right",
                    sDefaultContent: '0',
                    render: function(data, type, row, meta) {
                        return numberWithCommas(row.dividen);
                    }
                },
                {
                    data: null,
                    className: "text-left",
                    render: function(data, type, row, meta) {

                        if (row.liabilitas_jangka_panjang == 0 || row.liabilitas_jangka_pendek == 0 || row.liabilitas_total == 0)
                            var liHTML = '<button type="button" class="btn btn-xs btn-belt-warning penyertaanmodal" data-title="liabilitas" title="View data">Liabilitas</button>&nbsp;';
                        else
                            var liHTML = '<button type="button" class="btn btn-xs btn-belt-success penyertaanmodal" data-title="liabilitas" title="View data">Liabilitas</button>&nbsp;';

                        if (row.laba_rugi_pajak == 0 || row.laba_rugi_nopajak == 0 || row.taksiran_pajak == 0)
                            var laHTML = '<button type="button" class="btn btn-xs btn-belt-warning penyertaanmodal" data-title="laba_rugi" title="View data">Labarugi</button>&nbsp;';
                        else
                            var laHTML = '<button type="button" class="btn btn-xs btn-belt-success penyertaanmodal" data-title="laba_rugi" title="View data">Labarugi</button>&nbsp;';

                        if (row.pendapatan_usaha == 0 || row.harga_pokok_pendapatan == 0)
                            var peHTML = '<button type="button" class="btn btn-xs btn-belt-warning penyertaanmodal" data-title="pendapatan" title="View data">Pendapatan</button>&nbsp;';
                        else
                            var peHTML = '<button type="button" class="btn btn-xs btn-belt-success penyertaanmodal" data-title="pendapatan" title="View data">Pendapatan</button>&nbsp;';

                        if (row.ekuitas_total == 0)
                            var ekHTML = '<button type="button" class="btn btn-xs btn-belt-warning penyertaanmodal" data-title="ekuitas" title="View data">Ekuitas</button>&nbsp;';
                        else
                            var ekHTML = '<button type="button" class="btn btn-xs btn-belt-success penyertaanmodal" data-title="ekuitas" title="View data">Ekuitas</button>&nbsp;';

                        if (row.aset_lancar == 0 || row.aset_tidak_lancar == 0 || row.aset_total == 0)
                            var asHTML = '<button type="button" class="btn btn-xs btn-belt-warning penyertaanmodal" data-title="aset" title="View data">Aset</button>&nbsp;';
                        else
                            var asHTML = '<button type="button" class="btn btn-xs btn-belt-success penyertaanmodal" data-title="aset" title="View data">Aset</button>&nbsp;';


                        return liHTML + laHTML + peHTML + ekHTML + asHTML;
                    }
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

        penyertaanmodaltbl.on('xhr.dt', function(e, settings, json, xhr) {
            //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
        });

        $('#penyertaanmodaltbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#penyertaanmodaltbl_length select').addClass('form-control');

        // Form Reset
        function formReset() {
            $('#formEntry').attr('action', site + 'badanusaha/modal/create');
            $('#errEntry').html('');
            $('.help-block').text('');
            $('.required').removeClass('has-error');
            $('form#formEntry').trigger('reset');
            $('.lblPass').text('*');

            $('#id_profil_bu').prop('disabled', false);
            $('#tahun').prop('disabled', false);
            $('#tahun').val('').trigger('change');
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
            $('#penyertaanmodal').modal('hide');
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

        // Modal On View
        $(document).on('click', '.btnView', function(e) {

            $('#judul-form').html('LIHAT ');

            var data = penyertaanmodaltbl.api().row($(this).parents('tr')).data();
            //(data);
            e.stopPropagation();
            formReset();

            $('#nama_bu').val(data.nama);
            $('#penyertaan_modal').val(data.penyertaan_modal);
            $('#dividen').val(data.dividen);
            $('#no_telp').val(data.no_telp);
            $('#email').val(data.email);

            $('#id_profil_bu').val(data.id_profil_bu).trigger('change');
            $('#tahun').val(data.tahun).trigger('change');

            $('#id_profil_bu').prop('disabled', true);
            $('#tahun').prop('disabled', true);


            var descBox = $('.descBox');
            descBox.empty();

            var content = "<table class='table table-bordered basic-datatables no-footer'>"
            // Aset
            content += '<tr style="background-color: #f7f8fa"> <td>ASET</td> <td></td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Aset Lancar</td> <td class="text-right">' + abbreviateNumber(data.aset_lancar) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Aset Tidak Lancar</td> <td class="text-right">' + abbreviateNumber(data.aset_tidak_lancar) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Total Aset</td> <td class="text-right">' + abbreviateNumber(data.aset_total) + '</td></tr>';

            // Liabilitas
            content += '<tr style="background-color: #f7f8fa"> <td>LIABILITAS</td> <td></td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Jangka Panjang</td> <td class="text-right">' + abbreviateNumber(data.liabilitas_jangka_panjang) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Jangka Pendek</td> <td class="text-right">' + abbreviateNumber(data.liabilitas_jangka_pendek) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Total</td> <td class="text-right">' + abbreviateNumber(data.liabilitas_total) + '</td></tr>';

            // Ekuitas
            content += '<tr style="background-color: #f7f8fa"> <td>EKUITAS</td> <td></td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Total</td> <td class="text-right">' + abbreviateNumber(data.ekuitas_total) + '</td></tr>';

            // Pendapatan
            content += '<tr style="background-color: #f7f8fa"> <td>PENDAPATAN</td> <td></td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Pendapatan Usaha</td> <td class="text-right">' + abbreviateNumber(data.pendapatan_usaha) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Harga Pokok</td> <td class="text-right">' + abbreviateNumber(data.harga_pokok_pendapatan) + '</td></tr>';

            // Laba Rugi
            content += '<tr style="background-color: #f7f8fa"> <td>LABA RUGI</td> <td></td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Laba Rugi dengan Pajak</td> <td class="text-right">' + abbreviateNumber(data.laba_rugi_pajak) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Taksiran Pajak</td> <td class="text-right">' + abbreviateNumber(data.taksiran_pajak) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Laba Rugi tanpa Pajak</td> <td class="text-right">' + abbreviateNumber(data.laba_rugi_nopajak) + '</td></tr>';
            content += "</table>"

            descBox.append(content);


            $('#formEntry').attr('action', site + 'badanusaha/profil/update');
            $('.lblPass').text('');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnEdit', function(e) {

            $('#judul-form').html('EDIT ');

            var data = penyertaanmodaltbl.api().row($(this).parents('tr')).data();
            //(data);
            e.stopPropagation();
            formReset();
            $('#formEntry').attr('action', site + 'badanusaha/profil/update');

            // Fill data
            $('#id_profil_bu').val(data.id_profil_bu);
            $('#nama_bu').val(data.nama);
            $('#no_telp').val(data.no_telp);
            $('#email').val(data.email);

            $('#id_jenis_bu').val(data.id_jenis_bu).trigger('change');
            $('#id_bentuk_bu').val(data.id_bentuk_bu).trigger('change');

            $('#persen_kepemilikan').val(data.persen_kepemilikan);
            $('#modal_dasar').val(data.modal_dasar);
            $('#alamat').val(data.alamat);
            $('#bidang_usaha').val(data.bidang_usaha);
            $('#tahun_berdiri').val(data.tahun_berdiri);
            $('#nomor_perda_pendirian').val(data.nomor_perda_pendirian);
            $('#jumlah_komisaris').val(data.jumlah_komisaris);
            $('#jumlah_direksi').val(data.jumlah_direksi);
            $('#keterangan').val(data.keterangan);

            $('.lblPass').text('');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnDelete', function(e) {

            e.preventDefault();

            var idModalPertahun = $(this).data('idmodalpertahun');
            var postData = {
                'id_modal_pertahun': idModalPertahun,
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
                                    url: site + 'badanusaha/modal/delete',
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
                                        penyertaanmodaltbl.api().ajax.reload(null, false);
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
                                            penyertaanmodaltbl.api().ajax.reload(null, false);
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

        $(document).on('click', '.penyertaanmodal', function(e) {

            // Data penyertaan modal
            var title = $(this).data('title');
            //(title)
            $('#tipe-penyertaanmodal').html(title.toUpperCase());

            // Data Badan Usaha
            var data = penyertaanmodaltbl.api().row($(this).parents('tr')).data();
            $('#badan-usaha-title').html(data.nama_badan_usaha.toUpperCase());

            $.ajax({
                url: site + "badanusaha/modal/fetch",
                type: "POST",
                data: {
                    csrf_test_name: csrfHash,
                    komponen: title,
                    id_modal_pertahun: data.id_modal_pertahun,
                },
                success: function(data) {
                    // //(data);
                    csrfHash = data.csrf.csrfHash;
                    $('input[name="' + csrfName + '"]').val(csrfHash);

                    $('#id_modal_pertahun').val(data.id_modal_pertahun);
                    $('#id_komponen').val(data.id_komponen);
                    $('#komponen').val(data.komponen);

                    var boxForm = '';

                    $.each(data.data, function(key, value) {
                        //(key + ' | ' + value);
                        boxForm += '<div class="form-group required">' +
                            '<label for="' + key + '" class="control-label"><b>' + key.replace("_", " ").toUpperCase() + ' <font color="red">*</font></b></label>' +
                            '<input type="text" class="form-control" name="' + key + '" id="' + key + '" placeholder="' + key + '" value="' + value + '">' +
                            '<div class="help-block"></div>' +
                            '</div>';
                    });

                    $('.boxKomponen').empty();
                    $('.boxKomponen').append(boxForm);
                },
            });

            $('.lblPass').text('');
            $('#penyertaanmodal').modal({
                backdrop: 'static'
            });
        });

        // Form Entry On Sumbit
        $('#formPenyertaanModal').submit(function(e) {
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

                                var formData = new FormData(document.getElementById("formPenyertaanModal"));

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
                                            $('#penyertaanmodal').animate({
                                                scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, textarea, select').first().focus().offset().top - 300)
                                            }, 'slow');
                                        } else {
                                            //('masuk status 1');
                                            $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                                                '<strong>Sukses!</strong> ' + data.message +
                                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                                '</div>');
                                            $('#penyertaanmodal').modal('toggle');
                                            penyertaanmodaltbl.api().ajax.reload(null, false);
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
            penyertaanmodaltbl.api().ajax.reload();
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

        //cetak laporan excel
        $(document).on('click', '#printExcel', function(e) {
            let id_profil_bu_filter = $('#formFilter').find('select[name="id_profil_bu_filter"]').val();
            let tahun_filter = $('#formFilter').find('select[name="tahun_filter"]').val();

            url = site + 'badanusaha/modal/export-to-excel?profil=' + id_profil_bu_filter + '&tahun=' + tahun_filter;
            window.location.href = url;
        });




    });
</script>