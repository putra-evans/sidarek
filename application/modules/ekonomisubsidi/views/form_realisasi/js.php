<script type="text/javascript">
  $(function() {

    // Select 2
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    // Global Variabel
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var site = '<?php echo site_url(); ?>';
    var idProfilBU = '<?php echo isset($id_profil_bu) ? $id_profil_bu : ''; ?>';
    var mainTbl;

    // Define Datatable
    mainTbl = $('#mainTbl').dataTable({
      processing: true,
      deferRender: true,
      searching: true,
      paging: false,
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
            style: 'margin-right:5px;',
            id: 'btnAdd'
          },
        },
        // {
        //   text: '<i class="fa fa-download"></i> Template',
        //   attr: {
        //     title: 'Template Button',
        //     class: 'btn btn-default',
        //     style: 'margin-right:5px;',
        //     id: 'btnTemplate'
        //   },
        // },
        // {
        //   text: '<i class="fa fa-upload"></i> Import Data',
        //   attr: {
        //     title: 'Import Button',
        //     class: 'btn btn-danger',
        //     style: 'margin-right:5px;',
        //     id: 'btnImport'
        //   },
        // }
      ],
      serverSide: true,
      ordering: false,
      ajax: {
        url: site + "ekonomisubsidi/realisasi/listview",
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
          data: "regency_name",
          className: "text-left",
        },
        {
          data: "subsidi_name",
          className: "text-left",
          render: function(data, type, row, meta) {
            return row.kategori_name + ' - ' + row.subsidi_name;
          }
        },
        {
          data: "tahun",
          className: "text-center",
        },
        {
          data: "alokasi",
          className: "text-right",
        },
        {
          data: "realokasi_i",
          className: "text-right",
        },
        {
          data: "realokasi_ii",
          className: "text-right",
        },
        {
          data: "realisasi",
          className: "text-right",
        },
        {
          data: "persentase",
          className: "text-center",
        },
        {
          data: "rincian",
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
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api();

        api.columns('.sum', {
          page: 'current'
        }).every(function() {
          var sum = this
            .data()
            .reduce(function(a, b) {
              var x = parseFloat(a) || 0;
              var y = parseFloat(b) || 0;
              return x + y;
            }, 0);
          //(sum); //alert(sum);
          $(this.footer()).html(sum);
        });
      }

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
      $('#formEntry').attr('action', site + 'ekonomisubsidi/realisasi/create');
      $('#errEntry').html('');
      $('.help-block').text('');
      $('.required').removeClass('has-error');
      $('form#formEntry').trigger('reset');
      $('.lblPass').text('*');

      $('#id_regency').val('').trigger('change');
      $('#id_subsidi').val('').trigger('change');
      $('#tahun').val('').trigger('change');
      $('#alokasi').val('');
      $('#realokasi_i').val('');
      $('#realokasi_ii').val('');
      $('#realisasi').val('');
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
      //('button closed on clicked');
      formReset();
      $('#modalEntryForm').modal('hide');
      $('#modalSecondForm').modal('hide');
    });

    // Button Add
    $(document).on('click', '#btnAdd', function(e) {

      var descBox = $('.descBox');
      descBox.empty();
      $('.add').show();
      $('.showupdate').hide();
      $('.btnClose').show();
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
      formReset();
      $('#formEntry').attr('action', site + 'ekonomisubsidi/realisasi/update');

      //('data.id_subsidi_realisasi:' + data.id_subsidi_realisasi);
      $('#id_subsidi_realisasi').val(data.id_subsidi_realisasi);
      $('#id_regency').val(data.id_regency).trigger('change');
      $('#id_subsidi').select2('val', data.id_subsidi);
      $('#tahun').select2('val', data.tahun);
      $('#alokasi').val(data.alokasi);
      $('#realokasi_i').val(data.realokasi_i);
      $('#realokasi_ii').val(data.realokasi_ii);
      $('#realisasi').val(data.realisasi);

      $('.lblPass').text('');
      $('#modalEntryForm').modal({
        backdrop: 'static'
      });
    });

    $(document).on('click', '.btnDelete', function(e) {

      e.preventDefault();

      var idSubsidi = $(this).data('id');
      var postData = {
        'id_subsidi_realisasi': idSubsidi,
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
                  url: site + 'ekonomisubsidi/realisasi/delete',
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

    // Get Detail
    $(document).on('click', '.btnDetail', function(e) {

      $('.btnSubmitSecond').hide();
      $('.btnCancel').hide();
      $('.btnEditSecond').show();
      $('.btnClose').show();
      $('#judul-form').html('DATA ');

      var data = mainTbl.api().row($(this).parents('tr')).data();
      //(data);
      e.stopPropagation();

      $('#subsidi_second').html(data.subsidi_name);
      $('#tahun_second').html(data.tahun);
      $('#regency_second').html(data.regency_name);

      //('data.id_subsidi_realisasi:' + data.id_subsidi_realisasi);
      $('#id_subsidi_realisasi_fordetail').val(data.id_subsidi_realisasi);
      $('#id_subsidi_realisasi_fordetail').val(data.id_subsidi_realisasi);


      var postData = {
        'id_subsidi_realisasi': data.id_subsidi_realisasi,
        '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
      };

      run_waitMe($('#frmSecond'));

      $.ajax({
          url: site + '/ekonomisubsidi/detailrealisasi/fetch',
          type: "POST",
          data: postData,
          dataType: "json",
        }).done(function(data) {
          //('data nya apa');
          //(data);
          csrfName = data.csrf.csrfName;
          csrfHash = data.csrf.csrfHash;
          $('input[name="' + csrfName + '"]').val(csrfHash);
          $('.help-block').text('');
          $('.required').removeClass('has-error');
          setTimeout(function() {
            $('#frmSecond').waitMe('hide');
          }, 300);


          if (data.success) {
            var exist = jQuery.isEmptyObject(data.data);
            //('exist:' + exist);
            if (!exist) {
              $.each(data.data, function(key, value) {
                $('input[name="detail[' + key + ']"]').val(value['realisasi']);
                $('input[name="id_subsidi_detail[' + key + ']"]').val(value['id_subsidi_detail']);
              });
              $('[id=detail]').prop("disabled", true);

            } else {
              $('[id=detail]').prop("disabled", true);
              $('#formSecond')[0].reset();
            }

          }
        })
        .fail(function(data) {
          //('masuk fail');
          $('#errEntry').html('<div class="alert alert-danger">' +
            '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
            '</div>');
          $('#frmEntry').waitMe('hide');
        });

      $('.lblPass').text('');
      $('#modalSecondForm').modal({
        backdrop: 'static'
      });
    });

    $(document).on('click', '.btnEditSecond', function(e) {
      $('[id=detail]').prop("disabled", false);
      $('.btnSubmitSecond').show();
      $('.btnCancel').show();

      $('.btnEditSecond').hide();
      $('.btnClose').hide();
    });

    $(document).on('click', '.btnCancel', function(e) {
      $('[id=detail]').prop("disabled", true);
      $('.btnSubmitSecond').hide();
      $('.btnCancel').hide();

      $('.btnEditSecond').show();
      $('.btnClose').show();
    });

    // Form Second On Sumbit
    $('#formSecond').submit(function(e) {
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

                var formData = new FormData(document.getElementById("formSecond"));

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
                      mainTbl.api().ajax.reload(null, false);
                      //('masuk status 0');

                      $('#errEntry').html('<div class="alert alert-danger" id="pesanErr"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                      $.each(data.message, function(key, value) {
                        if (key != 'isi')
                          $('input[name="' + key + '"], select[name="' + key + '"], textarea[name="' + key + '"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                        else {
                          $('#pesanErr').html('<strong>Peringatan!</strong> ' + value);
                        }
                      });
                      $('#modalSecondForm').animate({
                        scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, textarea, select').first().focus().offset().top - 300)
                      }, 'slow');
                    } else {
                      mainTbl.api().ajax.reload(null, false);
                      //('masuk status 1');
                      $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                        '<strong>Sukses!</strong> ' + data.message +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                        '</div>');
                      $('#modalSecondForm').modal('toggle');
                    }
                    $('#frmSecond').waitMe('hide');
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


    //cetak laporan excel
    $(document).on('click', '#printExcel', function(e) {
      let id_subsidi_filter = $('#formFilter').find('select[name="id_subsidi_filter"]').val();
      let id_regency_filter = $('#formFilter').find('select[name="id_regency_filter"]').val();
      let tahun_filter = $('#formFilter').find('select[name="tahun_filter"]').val();

      url = site + 'ekonomisubsidi/realisasi/export-to-excel?subsidi=' + id_subsidi_filter + '&regency=' + id_regency_filter + '&tahun=' + tahun_filter;
      window.location.href = url;
    });





  });
</script>