<script type="text/javascript">
  $(function() {

    // Global Variabel
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var site = '<?php echo site_url(); ?>';
    var sdatbl;

    // Define Datatable
    sdatbl = $('#sdatbl').dataTable({
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
        url: site + "sda/peternakan/listview",
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
          data: "sektor",
          className: "text-left",
        },
        {
          data: "komoditi",
          className: "text-left",
        },
        {
          data: "tahun",
          className: "text-center",
        },
        {
          data: "produksi",
          className: "text-right",
          render: function(data, type, row, meta) {
            return numberWithCommas(row.produksi);
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

    $('#sdatbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
    $('#sdatbl_length select').addClass('form-control');

    // Filter Dinamis untuk Komoditi
    $('#id_sektor_filter').on('change', function() {

      var id_sektor = $(this).val();
      var url = site + '/sda/peternakan/fetch';
      $.ajax({
        url: url,
        type: "POST",
        data: {
          tabel: 'ma_komoditi',
          id: id_sektor,
          [csrfName]: csrfHash
        },
        success: function(data) {
          if (data.success) {
            csrfName = data.csrf.csrfName;
            csrfHash = data.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
            $('#id_komoditi_filter').html('');
            $('#id_komoditi_filter').append(data.options);
            $('#id_komoditi_filter').val('').trigger('change');
          } else {
            alert(data.message);
          }
        },
      })

    });

    // Filter Dinamis untuk Komoditi Modal
    $('#id_sektor').on('change', function() {

      var id_sektor = $(this).val();
      loadKomoditi(id_sektor);

    });


    function loadKomoditi(id_sektor) {
      var url = site + '/sda/peternakan/fetch';
      $.ajax({
        url: url,
        type: "POST",
        data: {
          tabel: 'ma_komoditi',
          id: id_sektor,
          [csrfName]: csrfHash
        },
        success: function(data) {
          if (data.success) {
            csrfName = data.csrf.csrfName;
            csrfHash = data.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
            $('#id_komoditi').html('');
            $('#id_komoditi').append(data.options);
          } else {
            alert(data.message);
          }
        }
      })
    }



    // Filter Jika Berjalan
    $('#formFilter').submit(function(e) {
      e.preventDefault();
      sdatbl.api().ajax.reload();
    });

    // Call Form Entri
    $(document).on('click', '#btnAdd', function(e) {
      formReset();
      $('#judul-form').html('ENTRI ');
      $('#modalEntryForm').modal({
        backdrop: 'static'
      });
    });

    // Close Form Entri
    $(document).on('click', '.btnClose', function(e) {
      formReset();
      $('#modalEntryForm').modal('toggle');
    });

    // Form Reset
    function formReset() {
      $('#formEntry').attr('action', site + 'sda/peternakan/create');
      $('#errEntry').html('');
      $('.help-block').text('');
      $('.required').removeClass('has-error');
      $('form#formEntry').trigger('reset');
      $('.lblPass').text('*');

      $('#id_sektor').val('').trigger('change');
      $('#id_komoditi').val('').trigger('change');
      $('#tahun').val('').trigger('change');
      $('#produksi').val('');

      $('#id_produksi_sda').prop('disabled', false);
      $('#id_sektor').prop('disabled', false);
      $('#id_komoditi').prop('disabled', false);
      $('#tahun').prop('disabled', false);
      $('#produksi').prop('disabled', false);
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

                // //(Object.fromEntries(formData));

                $.ajax({
                    url: formActionURL,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false, // tell jQuery not to process the data
                    contentType: false
                  }).done(function(data) {
                    // //('data nya apa');
                    // //(data);
                    csrfName = data.csrf.csrfName;
                    csrfHash = data.csrf.csrfHash;
                    $('input[name="' + csrfName + '"]').val(csrfHash);
                    $('.help-block').text('');
                    $('.required').removeClass('has-error');
                    if (data.status == 0) {
                      // //('masuk status 0');

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
                      // //('masuk status 1');
                      $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                        '<strong>Sukses!</strong> ' + data.message +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                        '</div>');
                      $('#modalEntryForm').modal('toggle');
                      sdatbl.api().ajax.reload(null, false);
                    }
                    $('#frmEntry').waitMe('hide');
                  })
                  .fail(function(data) {
                    // //('masuk fail');
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

    $(document).on('click', '.btnView', function(e) {

      $('#judul-form').html('LIHAT ');

      var data = sdatbl.api().row($(this).parents('tr')).data();
      // //(data.id_sektor);
      e.stopPropagation();
      formReset();

      $('#id_produksi_sda').val(data.id_produksi_sda);
      $('#id_sektor').select2('val', data.id_sektor);
      // $('#id_komoditi').val(data.id_komoditi).trigger('change');
      loadKomoditi(data.id_sektor);

      // //(data.id_sektor);
      setTimeout(() => {
        // //('data.id_sektor');
        $('#id_komoditi').val(data.id_komoditi).trigger('change');
      }, 1000);
      // $('#tahun').select2('val', data.tahun);
      $('#tahun').val(data.tahun).trigger('change');
      $('#produksi').val(data.produksi);



      $('#id_produksi_sda').prop('disabled', true);
      $('#id_sektor').prop('disabled', true);
      $('#id_komoditi').prop('disabled', true);
      $('#tahun').prop('disabled', true);
      $('#produksi').prop('disabled', true);

      $('.lblPass').text('');
      $('#modalEntryForm').modal({
        backdrop: 'static'
      });
    });

    $(document).on('click', '.btnEdit', function(e) {

      $('#judul-form').html('LIHAT ');

      var data = sdatbl.api().row($(this).parents('tr')).data();
      // //(data);
      e.stopPropagation();
      formReset();
      $('#formEntry').attr('action', site + 'sda/peternakan/update');


      // //('id_produksi_sda');
      // //(data.id_produksi_sda);
      $('#id_produksi_sda').val(data.id_produksi_sda);
      $('#id_sektor').select2('val', data.id_sektor);

      loadKomoditi(data.id_sektor);

      // //(data.id_sektor);
      setTimeout(() => {
        // //('data.id_sektor');
        $('#id_komoditi').val(data.id_komoditi).trigger('change');
      }, 1000);


      $('#tahun').val(data.tahun).trigger('change');

      $('#produksi').val(data.produksi);

      $('.lblPass').text('');
      $('#modalEntryForm').modal({
        backdrop: 'static'
      });
    });

    $(document).on('click', '.btnDelete', function(e) {

      e.preventDefault();

      var idproduksiSDA = $(this).data('id');
      var postData = {
        'id_produksi_sda': idproduksiSDA,
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
                  url: site + 'sda/peternakan/delete',
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
                    sdatbl.api().ajax.reload(null, false);
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

    //cetak laporan excel
    $(document).on('click', '#printExcel', function(e) {
      let sektor = $('#formFilter').find('select[name="tahun"]').val();
      let komoditi = $('#formFilter').find('select[name="id_komoditi_filter"]').val();
      url = site + 'sda/produksi/export-to-excel?sektor=' + sektor + '&komoditi=' + komoditi;
      window.location.href = url;
    });

  })
</script>