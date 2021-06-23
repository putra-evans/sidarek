<script type="text/javascript">
  $(function() {


    // Select 2
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    // Global Variabel
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var site = '<?php echo site_url(); ?>';
    var mainTbl;

    $(document).ready(function() {
      // Defining Tabel
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
          url: site + "kebijakan/produk/listview",
          type: "POST",
          // data: {
          //   param : $('#formFilter').serializeArray(),
          //   [csrfName]: $('input[name="'+csrfName+'"]').val(),
          // },
          data: function(d) {
            d.param = $('#formFilter').serializeArray();
            d.csrf_test_name = csrfHash;
          },
        },
        initComplete: function(settings, json) {
          //(json);
          //('json.csrf.csrfHash');
          //(json.csrf.csrfHash);
          csrfName = json.csrf.csrfName;
          csrfHash = json.csrf.csrfHash;
          $('input[name="' + csrfName + '"]').val(csrfHash);
        },
        columns: [{
            data: "index"
          },
          {
            data: "nomor"
          },
          {
            data: "tahun"
          },
          {
            data: "judul"
          },
          {
            data: "sasaran"
          },
          {
            data: "target"
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
      });

      $('#mainTbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
      $('#mainTbl_length select').addClass('form-control');

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

      // Filter on Submit
      $('#formFilter').submit(function(e) {
        e.preventDefault();
        var serialized = $(this).serializeArray();
        //(id_bidang);
        //(serialized);
        mainTbl.api().ajax.reload();
      });

      // Call Form Entri
      $(document).on('click', '#btnAdd', function(e) {
        $('.add').show();
        $('.showupdate').hide();
        formReset();
        $('#judul-form').html('ENTRI ');
        $('#modalEntryForm').modal({
          backdrop: 'static'
        });
      });

      // Close Form Entri
      $(document).on('click', '.btnClose', function(e) {
        $('.add').show();
        $('.showupdate').hide();
        formReset();
        $('#modalEntryForm').modal('toggle');
      });

      // Form Reset
      function formReset() {

        $('#formEntry').attr('action', site + 'kebijakan/produk/create');
        $('#errEntry').html('');
        $('.help-block').text('');
        $('.required').removeClass('has-error');
        $('form#formEntry').trigger('reset');
        $('.lblPass').text('*');

        $('#id_bidang').prop('disabled', false);
        $('#tahun').prop('disabled', false);
        $('#nomor').prop('disabled', false);
        $('#pemerintah').prop('disabled', false);
        $('#judul').prop('disabled', false);
        $('#sasaran').prop('disabled', false);
        $('#target').prop('disabled', false);
        $('#tanggal_terbit').prop('disabled', false);
        $('#id_bidang').val('').trigger('change');
        $('#tahun').val('').trigger('change');

        var d = new Date();

        var month = d.getMonth() + 1;
        var day = d.getDate();

        currDate = d.getFullYear() + '-' +
          (month < 10 ? '0' : '') + month + '-' +
          (day < 10 ? '0' : '') + day;

        //('tanggal');
        //(currDate);
        $('#tanggal_terbit').val(currDate);
      }

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

      // Modal On Edit
      $(document).on('click', '.btnEdit', function(e) {

        $('#judul-form').html('UBAH ');

        $('.add').show();
        $('.showupdate').show();

        var data = mainTbl.api().row($(this).parents('tr')).data();
        //(data);
        e.stopPropagation();
        formReset();

        $('#id_produk').val(data.id_produk);
        $('#id_bidang').select2('val', data.id_bidang);
        $('#tahun').select2('val', data.tahun);
        $('#nomor').val(data.nomor);
        $('#pemerintah').val(data.pemerintah);
        $('#judul').val(data.judul);
        $('#sasaran').val(data.sasaran);
        $('#target').val(data.target);
        //(data.tanggal_terbit);
        $('#tanggal_terbit').val(data.tanggal_terbit);

        $('#formEntry').attr('action', site + 'kebijakan/produk/update');
        $('.lblPass').text('');
        $('#modalEntryForm').modal({
          backdrop: 'static'
        });
      });

      // Modal On View
      $(document).on('click', '.btnView', function(e) {

        $('#judul-form').html('LIHAT ');

        var data = mainTbl.api().row($(this).parents('tr')).data();
        //(data);
        e.stopPropagation();
        formReset();

        $('.add').hide();
        $('.showupdate').show();
        if (data.file != "") {
          $('#file-to-text').text(data.file);
          $("#seefile").attr("href", site + "assets/files/" + data.file);
          $('#seefile').show();
        } else {
          $('.add').hide();
          $('.showupdate').show();
          $('#seefile').hide();
          $('#file-to-text').text('Data File Tidak Ada');
        }


        $('#id_produk').val(data.id_produk);
        $('#id_bidang').select2('val', data.id_bidang);
        $('#tahun').select2('val', data.tahun);
        $('#nomor').val(data.nomor);
        $('#pemerintah').val(data.pemerintah);
        $('#judul').val(data.judul);
        $('#sasaran').val(data.sasaran);
        $('#target').val(data.target);
        //(data.tanggal_terbit);
        $('#tanggal_terbit').val(data.tanggal_terbit);

        $('#id_bidang').prop('disabled', true);
        $('#tahun').prop('disabled', true);
        $('#nomor').prop('disabled', true);
        $('#pemerintah').prop('disabled', true);
        $('#judul').prop('disabled', true);
        $('#sasaran').prop('disabled', true);
        $('#target').prop('disabled', true);
        $('#tanggal_terbit').prop('disabled', false);
        //(data.tanggal_terbit);
        $('#tanggal_terbit').val(data.tanggal_terbit);

        $('#formEntry').attr('action', site + 'kebijakan/produk/update');
        $('.lblPass').text('');
        $('#modalEntryForm').modal({
          backdrop: 'static'
        });
      });

      // Modal On Delete
      $(document).on('click', '.btnDelete', function(e) {

        e.preventDefault();

        var produkid = $(this).data('id');
        //(produkid)
        var postData = {
          'produkId': produkid,
          '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
        };
        //(postData);
        // $(this).html('<i class="fa fa-hourglass-half"></i> Diproses');
        // $(this).addClass('disabled');
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
                  // $('.btnDelete').html('<i class="fa fa-trash-o"></i> Delete User');
                  // $('.btnDelete').removeClass('disabled');
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
                    url: site + 'kebijakan/produk/delete',
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
    //cetak laporan excel
    $(document).on('click', '#printExcel', function(e) {
      let id_bidang = $('#formFilter').find('select[name="id_bidang"]').val();
      let tahun = $('#formFilter').find('select[name="tahun"]').val();
      let id_tipe = $('#formFilter').find('select[name="id_tipe"]').val();
      url = site + 'kebijakan/produk/export-to-excel?bidang=' + id_bidang + '&tahun=' + tahun + '&tipe=' + id_tipe;
      window.location.href = url;
    });


  });



  var defaults = {
    minimumChars: 8
  };
  var progressHtml = "<div class='contextual-progress' style='margin-top:5px;margin-bottom:0px;'>" +
    "<div class='clearfix'>" +
    "<div class='progress-title'></div>" +
    "</div>" +
    "<div class='progress'>" +
    "<div id='password-progress' class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%;'></div>" +
    "</div>" +
    "</div>";
  // $('input[type=password]:first').closest('div.input-group').after(progressHtml);
  $(progressHtml).insertAfter($('input[type=password]:first').closest('div.input-group'));
  $('.progress-title').text('');
  $('.contextual-progress').hide();
</script>