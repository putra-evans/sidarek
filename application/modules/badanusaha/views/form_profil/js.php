<script type="text/javascript">
  // $(function() {

  // Global Variabel
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var site = '<?php echo site_url(); ?>';
  var profiltbl;

  // Define Datatable
  profiltbl = $('#profiltbl').dataTable({
    processing: true,
    searching: true,
    language: {
      processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
      searchPlaceholder: "Search records"
    },
    serverSide: true,
    ordering: false,
    ajax: {
      url: site + "badanusaha/profil/listview",
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
        data: "nama",
        className: "text-left",
      },
      {
        data: "alamat",
        className: "text-left",
        render: function(data, type, row, meta) {
          return row.alamat + '<br>' + row.no_telp + ' | ' + row.email;
        }
      },
      {
        data: "tahun_berdiri",
        className: "text-center",
      },
      {
        data: "bidang_usaha",
      },
      {
        data: "modal_dasar",
        className: "text-right",
        render: function(data, type, row, meta) {
          return abbreviateNumber(row.modal_dasar);
        }
      },
      {
        data: null,
        className: "text-center",
        render: function(data, type, row, meta) {

          // var liHTML = '<button type="button" class="btn btn-xs btn-belt penyertaanmodal" id="liabilitas" title="View data">Liabilitas</button>&nbsp;';
          // var laHTML = '<button type="button" class="btn btn-xs btn-belt penyertaanmodal" id="labarugi" title="View data">Labarugi</button>&nbsp;';
          // var peHTML = '<button type="button" class="btn btn-xs btn-belt penyertaanmodal" id="pendapatan" title="View data">Pendapatan</button>&nbsp;';
          // var ekHTML = '<button type="button" class="btn btn-xs btn-belt penyertaanmodal" id="ekuitas" title="View data">Ekuitas</button>&nbsp;';
          // var asHTML = '<button type="button" class="btn btn-xs btn-belt penyertaanmodal" id="aset" title="View data">Aset</button>&nbsp;';

          // return liHTML + laHTML + peHTML + ekHTML + asHTML;

          var penyertaanModal = '<a href="' + site + 'badanusaha/modal/index/' + row.id_profil_bu + '" type="button" class="btn btn-xs btn-belt" id="aset" title="View data">Progress Perkembangan</a>';
          return penyertaanModal;


        }
      },
      {
        data: "action"
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

  profiltbl.on('xhr.dt', function(e, settings, json, xhr) {
    //(json);
    csrfHash = json.csrf.csrfHash;
    $('input[name="' + csrfName + '"]').val(csrfHash);
  });

  $('#profiltbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
  $('#profiltbl_length select').addClass('form-control');

  // Form Reset
  function formReset() {
    $('#formEntry').attr('action', site + 'badanusaha/profil/create');
    $('#errEntry').html('');
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('form#formEntry').trigger('reset');
    $('.lblPass').text('*');

    $('#nama_bu').prop('disabled', false);
    $('#no_telp').prop('disabled', false);
    $('#email').prop('disabled', false);
    $('#tahun_berdiri').prop('disabled', false);
    $('#persen_kepemilikan').prop('disabled', false);
    $('#modal_dasar').prop('disabled', false);
    $('#alamat').prop('disabled', false);
    $('#bidang_usaha').prop('disabled', false);
    $('#nomor_perda_pendirian').prop('disabled', false);
    $('#jumlah_komisaris').prop('disabled', false);
    $('#jumlah_direksi').prop('disabled', false);
    $('#keterangan').prop('disabled', false);
    $('#id_jenis_bu').prop('disabled', false);
    $('#id_bentuk_bu').prop('disabled', false);

    $('#id_jenis_bu').val('').trigger('change');
    $('#id_bentuk_bu').val('').trigger('change');
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

    var data = profiltbl.api().row($(this).parents('tr')).data();
    //(data);
    e.stopPropagation();
    formReset();

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

    $('#nama_bu').prop('disabled', true);
    $('#no_telp').prop('disabled', true);
    $('#email').prop('disabled', true);
    $('#tahun_berdiri').prop('disabled', true);
    $('#persen_kepemilikan').prop('disabled', true);
    $('#modal_dasar').prop('disabled', true);
    $('#alamat').prop('disabled', true);
    $('#bidang_usaha').prop('disabled', true);
    $('#nomor_perda_pendirian').prop('disabled', true);
    $('#jumlah_komisaris').prop('disabled', true);
    $('#jumlah_direksi').prop('disabled', true);
    $('#keterangan').prop('disabled', true);
    $('#id_jenis_bu').prop('disabled', true);
    $('#id_bentuk_bu').prop('disabled', true);

    $('#formEntry').attr('action', site + 'badanusaha/profil/update');
    $('.lblPass').text('');
    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
  });

  $(document).on('click', '.btnEdit', function(e) {

    $('#judul-form').html('EDIT ');

    var data = profiltbl.api().row($(this).parents('tr')).data();
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

    var idProfilBU = $(this).data('id');
    var postData = {
      'id_profil_bu': idProfilBU,
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
                url: site + 'badanusaha/profil/delete',
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
                  profiltbl.api().ajax.reload(null, false);
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
                    profiltbl.api().ajax.reload(null, false);
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
    var tipepenyertaanmodal = $(this).attr('id');
    $('#tipe-penyertaanmodal').html(tipepenyertaanmodal.toUpperCase());

    // Data Badan Usaha
    var data = profiltbl.api().row($(this).parents('tr')).data();
    $('#badan-usaha-title').html(data.nama.toUpperCase());

    $('.lblPass').text('');
    $('#penyertaanmodal').modal({
      backdrop: 'static'
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