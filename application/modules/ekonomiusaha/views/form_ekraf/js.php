<script type="text/javascript">
    $(function() {

        // Select 2
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        // Global Variabel
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var site = '<?php echo site_url(); ?>';
        var idProfilBU = '<?php echo isset($id_profil_bu) ? $id_profil_bu : ''; ?>';
        var distID = '',
            villID = '';
        var mainTbl;

        // Define Datatable
        mainTbl = $('#mainTbl').dataTable({
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
                    id: 'btnAdd'
                },
            }],
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "ekonomiusaha/ekraf/listview/",
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
                    data: "usaha_nama",
                    className: "text-left",
                },
                {
                    data: "usaha_owner",
                    className: "text-left",
                },
                {
                    data: "no_hp",
                    className: "text-left",
                },
                {
                    data: "jenis_ekraf",
                    className: "text-left",
                },
                {
                    data: "alamat_jalan",
                    className: "text-left",
                    render: function(data, type, row, meta) {
                        return row.alamat_jalan + ' ' + row.alamat_nomor + ', RT/RW.' +
                            row.alamat_rt_rw + ', ' + row.regency_name + ', ' +
                            row.district_name + ', ' + row.village_name + ', SUMATERA BARAT, ' + row.kode_pos;
                    }
                },

                // {
                //     data: "alamat_jalan",
                //     className: "text-right",
                // },
                // {
                //     data: "alamat_nomor",
                //     className: "text-right",
                // },
                // {
                //     data: "alamat_rt_rw",
                //     className: "text-right",
                // },
                // {
                //     data: "regency_name",
                //     className: "text-right",
                // },
                // {
                //     data: "district_name",
                //     className: "text-right",
                // },
                // {
                //     data: "village_name",
                //     className: "text-right",
                // },
                // {
                //     data: "kode_pos",
                //     className: "text-right",
                // },
                {
                    data: "usaha_umur",
                    className: "text-right",
                    render: function(data, type, row, meta) {
                        return row.usaha_umur + " Bulan";
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

        $('#mainTbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#mainTbl_length select').addClass('form-control');

        mainTbl.on('xhr.dt', function(e, settings, json, xhr) {
            //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
        });

        // Form Reset
        function formReset() {
            $('#formEntry').attr('action', site + 'ekonomiusaha/ekraf/create');
            $('#errEntry').html('');
            $('.help-block').text('');
            $('.required').removeClass('has-error');
            $('form#formEntry').trigger('reset');
            $('.lblPass').text('*');


            $('#id_ekraf').val('');
            $('#usaha_owner').val('');
            $('#usaha_nama').val('');
            $('#no_hp').val('');
            $('#kode_pos').val('');

            $('#id_jenis_ekraf').val('').trigger('change');

            $('#alamat_jalan').val('');
            $('#alamat_nomor').val('');
            $('#alamat_rt_rw').val('');

            $('#usaha_umur').val('');

            distID = '';
            villID = '';

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
            $('#id_regency').val('').trigger('change');
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
            formReset();
            $('#formEntry').attr('action', site + 'ekonomiusaha/ekraf/update');

            $('#id_ekraf').val(data.id_ekraf);
            $('#usaha_owner').val(data.usaha_owner);
            $('#usaha_nama').val(data.usaha_nama);
            $('#no_hp').val(data.no_hp);
            $('#kode_pos').val(data.kode_pos);

            $('#id_jenis_ekraf').val(data.id_jenis_ekraf).trigger('change');

            $('#alamat_jalan').val(data.alamat_jalan);
            $('#alamat_nomor').val(data.alamat_nomor);
            $('#alamat_rt_rw').val(data.alamat_rt_rw);

            distID = data.id_district;
            villID = data.id_village;
            $('#id_regency').val(data.id_regency).trigger('change');


            // $('#id_district').val(data.id_district).trigger('change');
            // $('#id_village').val(data.id_village).trigger('change');

            $('#usaha_umur').val(data.usaha_umur);

            $('.lblPass').text('');
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnDelete', function(e) {

            e.preventDefault();

            var itemID = $(this).data('id');
            var postData = {
                'id_ekraf': itemID,
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
                                    url: site + 'ekonomiusaha/ekraf/delete',
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

        $(document).on('change', 'select[name="id_regency"]', function(e) {

            let id = $(this).val();
            //('id_regency: ' + id);
            //('district kepanggil dong');
            getDistrict(id);
        });

        $(document).on('change', 'select[name="id_district"]', function(e) {
            let id = $(this).val();
            //('id_district: ' + id);
            //('regen kepanggil dong');
            getVillage(id);
        });

        //mengambil data kecamatan
        function getDistrict(regencyId) {
            let lblDis = '';
            distID = (distID != '') ? distID : '<?php echo $this->input->post('id_district', TRUE); ?>';
            //('distID: ' + distID);
            $.ajax({
                type: 'GET',
                url: site + 'ekonomiusaha/ekraf/district',
                data: {
                    'id_regency': regencyId
                },
                dataType: 'json',
                success: function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    $('#id_district').html('').select2('data', null);
                    if (data.status == 1) {
                        lblDis = '<option value="">Pilih Kecamatan</option>';
                        $.each(data.message, function(key, value) {
                            lblDis += '<option value="' + value['id'] + '">' + value['text'] + '</option>';
                        });
                    } else
                        lblDis = '<option value="">Pilih Kecamatan</option>';
                    $('#id_district').html(lblDis);
                    $('#id_district').select2('val', distID).trigger('change');
                }
            });
        }

        //mengambil data kelurahan/desa/nagari
        function getVillage(districtId) {
            let lblVil = '';
            villID = (villID != '') ? villID : '<?php echo $this->input->post('id_village', TRUE); ?>';
            //('villID: ' + villID);
            $.ajax({
                type: 'GET',
                url: site + 'ekonomiusaha/ekraf/village',
                data: {
                    'id_district': districtId
                },
                dataType: 'json',
                success: function(data) {
                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                    $('#id_village').html('').select2('data', null);
                    if (data.status == 1) {
                        lblVil = '<option value="">Pilih Kelurahan</option>';
                        $.each(data.message, function(key, value) {
                            lblVil += '<option value="' + value['id'] + '">' + value['text'] + '</option>';
                        });
                    } else
                        lblVil = '<option value="">Pilih Kelurahan</option>';
                    $('#id_village').html(lblVil);
                    $('#id_village').select2('val', villID).trigger('change');
                }
            });
        }


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
            let jenis_ekraf = $('#formFilter').find('select[name="jenis_ekraf"]').val();
            let id_regency_filter = $('#formFilter').find('select[name="id_regency_filter"]').val();

            url = site + 'ekonomiusaha/ekraf/export-to-excel?jenis=' + jenis_ekraf + '&kabkota=' + id_regency_filter;
            window.location.href = url;
        });

    });
</script>