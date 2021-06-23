<script type="text/javascript">
    // $(function() {

    // Select 2
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    $.fn.editable.defaults.mode = 'inline';

    $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">OK</button>' +
        '<button type="button" class="btn btn-default btn-sm editable-cancel">Batal</button>';


    // Global Variabel
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var site = '<?php echo site_url(); ?>';
    var idProfilBU = '<?php echo isset($id_profil_bu) ? $id_profil_bu : ''; ?>';
    var mainTbl;
    var kategoriID = '',
        jenisID = '';
    var rowGroup = 1;
    var master = '';
    var weeknumber = '<?= $minggu_tahun_filter ?>';
    var year = '<?= $tahun_filter ?>';
    var firstDate, lastDate;
    var currDate;

    $(document).ready(function() {

        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();

        currDate = d.getFullYear() + '-' +
            (month < 10 ? '0' : '') + month + '-' +
            (day < 10 ? '0' : '') + day;

        moment.locale('en', {
            week: {
                dow: 1
            } // Monday is the first day of the week
        });

        firstDate = moment(currDate, "YYYY-MM-DD").day(1).format("YYYY/MM/DD");
        lastDate = moment(currDate, "YYYY-MM-DD").day(7).format("YYYY/MM/DD");

        $('#monday_date_datepicker').datepicker({
            "setDate": new Date(),
            "autoclose": true,
            weekStart: 1
        });





        // On Change Date
        $('#monday_date_datepicker').on('changeDate', function() {
            $('.day.active').closest('tr').find('.day').addClass('highlight');
            //('masuk sini');
            var value = $("#monday_date").val();
            //(value);
            firstDate = moment(value, "YYYY-MM-DD").day(1).format("YYYY/MM/DD");
            lastDate = moment(value, "YYYY-MM-DD").day(7).format("YYYY/MM/DD");
            //('firstDate: ' + firstDate);

            $('#monday_date_datepicker').datepicker('update', firstDate);
            weeknumber = moment(firstDate, "YYYY/MM/DD").week();
            year = moment(firstDate, "YYYY/MM/DD").year();
            //('weeknumber: ' + weeknumber);

            $('#minggu_tahun').val(weeknumber + ' pada Tahun ' + year);
            $('.day.active').closest('tr').find('.day').addClass('highlight');
        });

        // Define Datatable
        mainTbl = $('#mainTbl').dataTable({
            processing: true,
            searching: true,
            paging: false,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                // {
                //     text: '<i class="fa fa-plus"></i> Add',
                //     attr: {
                //         title: 'Add Button',
                //         class: 'btn btn-primary',
                //         style: 'margin-right:10px;',
                //         id: 'btnAdd'
                //     },
                // },
                {
                    text: '<i class="fa fa-caret-left"></i> ',
                    attr: {
                        title: 'btnNext',
                        class: 'btn btn-default',
                        style: 'margin-right:10px;',
                        id: 'btnPrevious'
                    },
                },
                {
                    text: firstDate + ' - ' + lastDate,
                    attr: {
                        title: 'btnNext',
                        class: 'btn btn-default',
                        style: 'margin-right:10px;',
                        id: 'btnDetail',
                    },
                },
                {
                    text: '<i class="fa fa-caret-right"></i> ',
                    attr: {
                        title: 'btnPrev',
                        class: 'btn btn-default',
                        style: 'margin-right:10px;',
                        id: 'btnNext'
                    },
                }
            ],
            serverSide: true,
            // ordering: false,
            ajax: {
                url: site + "ekonomidagang/harga/listview/",
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
                // {
                //     data: "monday_date",
                //     className: "text-center",
                // },
                // {
                //     data: "minggu_tahun",
                //     className: "text-center",
                // },
                {
                    data: "nama_komoditas",
                    className: "text-left",
                },
                {
                    data: "kategori_komoditas",
                    className: "text-left",
                    sDefaultContent: "-",
                },
                {
                    data: "jenis_komoditas",
                    className: "text-left",
                },
                {
                    data: "satuan",
                    className: "text-center",
                },
                {
                    data: "harga",
                    className: "text-right",
                    render: function(data, type, row, meta) {
                        return '<a href="javascript:void(0)" id="harga" class="editable" data-komoditas="' + row.id_komoditas + '" data-kategori="' + row.id_komoditas_kategori + '" data-jenis="' + row.id_komoditas_jenis + '" data-harga="' + row.id_komoditas_harga + '" onclick="popUp(this)">' + row.harga + '</a>'
                    }

                },
                // {
                //     data: "action",
                //     className: "text-center",
                // }
            ],
            columnDefs: [{
                    "visible": false,
                    "targets": rowGroup
                }, {
                    targets: [0], //first column
                    orderable: false, //set not orderable
                },
                {
                    targets: [-1], //last column
                    orderable: false, //set not orderable
                },
            ],
            order: [
                [rowGroup, 'asc']
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(rowGroup, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="5" class="text-left" style="background-color: #ddd !important;">Komoditas: <b>' + group + '<b></td></tr>'
                        );

                        last = group;
                    }
                });
            },

        });

        $('#mainTbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#mainTbl_length select').addClass('form-control');

        mainTbl.on('xhr.dt', function(e, settings, json, xhr) {
            //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
        });

        $('#btnDetail').datepicker({
            "setDate": new Date(),
            "autoclose": true,
            weekStart: 1,
        }).on('changeDate', function(ev) {
            currDate = ev.format();
            blockUI();
            setDateRange(currDate);
        });

        $('#btnDetail').datepicker('update', firstDate);

    });

    function blockUI() {
        $('#mainTbl').block({
            message: '<i class="fa fa-spinner"></i>',
            css: {
                backgroundColor: 'transparent',
                border: 'none'
            },
            baseZ: 1500,
        });
    }

    $('#mainTbl .editable').on('hidden', function(e, reason) {
        //('hidden check');
        if (reason === 'save' || reason === 'nochange') {
            var $next = $(this).closest('tr').next().find('.editable');
            if ($('#autoopen').is(':checked')) {
                setTimeout(function() {
                    $next.editable('show');
                }, 300);
            } else {
                $next.focus();
            }
        }
    });


    function setDateRange(currDate) {
        firstDate = moment(currDate, "YYYY-MM-DD").day(1).format("YYYY/MM/DD");
        lastDate = moment(currDate, "YYYY-MM-DD").day(7).format("YYYY/MM/DD");
        $('#btnDetail').datepicker('update', firstDate);

        weeknumber = moment(firstDate, "YYYY/MM/DD").week();
        year = moment(firstDate, "YYYY/MM/DD").year();

        $('#tahun_filter').val(year).trigger('change');
        $('#minggu_tahun_filter').val(weeknumber).trigger('change');

        $('#btnDetail').html(firstDate + ' - ' + lastDate);


        // $.unblockUI();
        setTimeout(function() {
            mainTbl.api().ajax.reload(null, false);
            $('#mainTbl').unblock();
        }, 500);
    }


    $(document).on('click', '#btnNext', function(e) {
        currDate = moment(currDate, "YYYY-MM-DD").subtract(-7, "days").format("YYYY-MM-DD");
        setDateRange(currDate);
        blockUI();
    });

    $(document).on('click', '#btnPrevious', function(e) {
        currDate = moment(currDate, "YYYY-MM-DD").subtract(7, "days").format("YYYY-MM-DD");
        setDateRange(currDate);
        blockUI();
    });




    // Form Reset
    function formReset() {
        $('#formEntry').attr('action', site + 'ekonomidagang/harga/create');
        $('#errEntry').html('');
        $('.help-block').text('');
        $('.required').removeClass('has-error');
        $('form#formEntry').trigger('reset');
        $('.lblPass').text('*');

        kategoriID = '';
        jenisID = '';
        $('#id_komoditas_harga').val('');

        $('#id_komoditas').val('').trigger('change');
        $('#id_komoditas_kategori').val('').trigger('change');
        $('#id_komoditas_jenis').val('').trigger('change');
        $('#monday_date').val('');
        $('#harga').val('');
        $('#minggu_tahun').val('');

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

    // Close Form Entri
    $(document).on('click', '.btnCloseBulk', function(e) {
        $('#modalEntryBulk').modal('hide');
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

    function popUp(x) {

        var komoditas = $(x).data('komoditas');
        var kategori = $(x).data('kategori');
        var jenis = $(x).data('jenis');
        var harga = $(x).data('harga');

        $(x).editable({
            type: 'text',
            pk: {
                'komoditas': komoditas,
                'kategori': kategori,
                'jenis': jenis,
                'harga': harga,
                'monday_date': currDate,
                'minggu_tahun': weeknumber,
            },
            url: '<?php echo site_url(); ?>' + 'ekonomidagang/harga/input',
            title: 'Enter username',
            params: function(params) {
                params.csrf_test_name = csrfHash;
                return params;
            },
            success: function(response, newValue) {
                csrfHash = response.csrf.csrfHash;
                mainTbl.api().ajax.reload(null, false);
            }
        });

    }

    $(document).on('click', '.btnEdit', function(e) {

        $('#judul-form').html('EDIT ');

        var data = mainTbl.api().row($(this).parents('tr')).data();
        //(data);
        e.stopPropagation();
        $('#formEntry').attr('action', site + 'ekonomidagang/harga/update');

        $('#id_komoditas_harga').val(data.id_komoditas_harga);

        kategoriID = data.id_komoditas_kategori;
        jenisID = data.id_komoditas_jenis;
        $('#id_komoditas').val(data.id_komoditas).trigger('change');

        // $('#id_komoditas_kategori').val(data.id_komoditas_kategori).trigger('change');
        // $('#id_komoditas_jenis').val(data.id_komoditas_jenis).trigger('change');
        $('#monday_date').val(data.monday_date);
        $('#harga').val(data.harga);
        var year = moment(data.monday_date, "YYYY-MM-DD").year();
        $('#minggu_tahun').val(data.minggu_tahun + ' pada Tahun ' + year);

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
                                url: site + 'ekonomidagang/harga/delete',
                                type: "POST",
                                data: postData,
                                dataType: "json",
                            }).done(function(data) {
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



    $(document).on('change', 'select[name="id_komoditas"]', function(e) {
        let id = $(this).val();
        //('id_komoditas: ' + id);

        //('kategoriID');
        //('jenisID');
        //(kategoriID);
        //(jenisID);

        var kategori = <?php echo $kategori; ?>;

        $('select[name="id_komoditas_kategori"]').html('').select2('data', null);
        lblKategori = '<option value="">Pilih Kategori</option>';

        var counter = 0;
        $.each(kategori, function(key, value) {
            if (value.id_komoditas == id) {
                counter++;
                lblKategori += '<option value="' + key + '">' + value.nama + '</option>';
            }
        });

        if (counter == 0) {
            $('select[name="id_komoditas_kategori"]').prop('disabled', true);
            var jenis = <?php echo $jenis; ?>;
            //(jenis);
            $('select[name="id_komoditas_jenis"]').html('').select2('data', null);
            lblJenis = '<option value="">Pilih Jenis</option>';

            var counter = 0;
            $.each(jenis, function(key, value) {
                if (value.id_komoditas == id) {
                    counter++;
                    lblJenis += '<option value="' + key + '">' + value.nama + '</option>';
                }
            });
            $('select[name="id_komoditas_jenis"]').html(lblJenis);
            $('select[name="id_komoditas_jenis"]').select2('val', jenisID).trigger('change');
        } else {
            $('select[name="id_komoditas_kategori"]').prop('disabled', false);
            $('select[name="id_komoditas_kategori"]').html(lblKategori);
            $('select[name="id_komoditas_kategori"]').select2('val', kategoriID).trigger('change');
        }


    });

    $(document).on('change', 'select[name="id_komoditas_kategori"]', function(e) {
        let id = $(this).val();

        var tempArray = <?php echo $jenis; ?>;

        $('select[name="id_komoditas_jenis"]').html('').select2('data', null);
        lblReg = '<option value="">Pilih Jenis</option>';
        $.each(tempArray, function(key, value) {
            if (value.id_komoditas_kategori == id) {
                lblReg += '<option value="' + key + '">' + value.nama + '</option>';
            }
        });

        $('select[name="id_komoditas_jenis"]').html(lblReg);
        $('select[name="id_komoditas_jenis"]').select2('val', jenisID).trigger('change');
    });

    $(document).on('change', 'select[name="id_komoditas_jenis"]', function(e) {
        let id = $(this).val();

        var tempArray = <?php echo $jenis; ?>;

        $.each(tempArray, function(key, value) {
            if (key == id) {
                $('#satuan-html').html(value.satuan);
            }
        });

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






    // });
</script>