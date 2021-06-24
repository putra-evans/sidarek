<script type="text/javascript">
    $(function() {

        // Global Variabel
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var site = '<?php echo site_url(); ?>';
        var idProfilBU = '<?php echo isset($id_profil_bu) ? $id_profil_bu : ''; ?>';
        var ntptbl;

        // Define Datatable
        ntptbl = $('#ntptbl').dataTable({
            processing: true,
            searching: true,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                searchPlaceholder: "Search records"
            },
            serverSide: true,
            ordering: false,
            ajax: {
                url: site + "ntp/ntp/listview/" + idProfilBU,
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
                    data: "bulan_ntp",
                    className: "text-center",
                },
                {
                    data: "ket_ntp",
                    className: "text-left",
                },
                // {
                //     data: "penyertaan_modal",
                //     className: "text-right",
                //     sDefaultContent: '0',
                //     render: function(data, type, row, meta) {
                //         return numberWithCommas(row.penyertaan_modal);
                //     }
                // },
                // {
                //     data: "dividen",
                //     className: "text-right",
                //     sDefaultContent: '0',
                //     render: function(data, type, row, meta) {
                //         return numberWithCommas(row.dividen);
                //     }
                // },
                {
                    data: null,
                    className: "text-center",
                    render: function(data, type, row, meta) {

                        if (row.nilai_tukar_petani_ntpp_a == 0 || row.nilai_tukar_usaha_pertanian_a == 0 || row.indeks_harga_diterima_petani_a == 0 || row.padi_a == 0 || row.palawijaya_a == 0 || row.indeks_harga_dibayar_petani_a == 0 || row.indeks_konsumsi_rumah_tangga_a == 0 || row.indeks_bppbm_a == 0)
                            var aHTML = '<button type="button" class="btn btn-xs btn-belt-warning nilaintp" data-title="Tanaman Pangan" data-tbl="tp" data-idtbl="tp" title="View data">Tanaman Pangan</button>&nbsp;';
                        else
                            var aHTML = '<button type="button" class="btn btn-xs btn-belt-success nilaintp" data-title="Tanaman Pangan" data-tbl="tp" data-idtbl="tp" title="View data">Tanaman Pangan</button>&nbsp;';


                        if (row.nilai_tukar_petani_ntph_b == 0 || row.nilai_tukar_usaha_pertanian_b == 0 || row.indeks_harga_diterima_petani_b == 0 || row.sayur_sayuran_b == 0 || row.buah_buahan_b == 0 || row.tanaman_obat_b == 0 || row.indeks_harga_dibayar_petani_b == 0 || row.indeks_konsumsi_rumah_tangga_b == 0 || row.indeks_bppbm_b == 0)
                            var bHTML = '<button type="button" class="btn btn-xs btn-belt-warning nilaintp" data-title="Hortikultura" data-tbl="hortikultur" data-idtbl="hortikultur" title="View data">Hortikultura</button>&nbsp;';
                        else
                            var bHTML = '<button type="button" class="btn btn-xs btn-belt-success nilaintp" data-title="Hortikultura" data-tbl="hortikultur" data-idtbl="hortikultur" title="View data">Hortikultura</button>&nbsp;';


                        if (row.nilai_tukar_petani_ntpr_c == 0 || row.nilai_tukar_usaha_pertanian_c == 0 || row.indeks_harga_diterima_petani_c == 0 || row.tanaman_perkebunan_rakyat_tpr_c == 0 || row.indeks_harga_dibayar_petani_c == 0 || row.indeks_konsumsi_rumah_tangga_c == 0 || row.indeks_bppbm_c == 0)
                            var cHTML = '<button type="button" class="btn btn-xs btn-belt-warning nilaintp" data-title="Tanaman Perkebunan Rakyat" data-tbl="perkebunan" data-idtbl="perkebunan" title="View data">Tanaman Perkebunan Rakyat</button>&nbsp;';
                        else
                            var cHTML = '<button type="button" class="btn btn-xs btn-belt-success nilaintp" data-title="Tanaman Perkebunan Rakyat" data-tbl="perkebunan" data-idtbl="perkebunan" title="View data">Tanaman Perkebunan Rakyat</button>&nbsp;';


                        if (row.nilai_tukar_petani_ntpt_d == 0 || row.nilai_tukar_usaha_pertanian_d == 0 || row.indeks_harga_diterima_petani_d == 0 || row.ternak_besar_d == 0 || row.ternak_kecil_d == 0 || row.unggas_d == 0 || row.hasil_ternak_d == 0 || row.indeks_harga_dibayar_petani_d == 0 || row.indeks_konsumsi_rumah_tangga_d == 0 || row.indeks_bppbm_d == 0)
                            var dHTML = '<button type="button" class="btn btn-xs btn-belt-warning nilaintp" data-title="Peternakan" data-tbl="peternakan" data-idtbl="peternakan" title="View data">Peternakan</button>&nbsp;';
                        else
                            var dHTML = '<button type="button" class="btn btn-xs btn-belt-success nilaintp" data-title="Peternakan" data-tbl="peternakan" data-idtbl="peternakan" title="View data">Peternakan</button>&nbsp;';


                        if (row.nilai_tukar_petani_ntnp_e == 0 || row.nilai_tukar_usaha_pertanian_e == 0 || row.indeks_harga_diterima_petani_e == 0 || row.tangkap_e == 0 || row.budidaya_e == 0 || row.indeks_harga_dibayar_petani_e == 0 || row.indeks_konsumsi_rumah_tangga_e == 0 || row.indeks_bppbm_e == 0)
                            var eHTML = '<button type="button" class="btn btn-xs btn-belt-warning nilaintp" data-title="Perikanan" data-tbl="perikanan" data-idtbl="perikanan" title="View data">Perikanan</button>&nbsp;';
                        else
                            var eHTML = '<button type="button" class="btn btn-xs btn-belt-success nilaintp" data-title="Perikanan" data-tbl="perikanan" data-idtbl="perikanan" title="View data">Perikanan</button>&nbsp;';

                        if (row.nilai_tukar_petani_ntn_f == 0 || row.nilai_tukar_usaha_pertanian_f == 0 || row.indeks_harga_diterima_petani_f == 0 || row.penangkapan_perairan_umum_f == 0 || row.penangkapan_laut_f == 0 || row.indeks_harga_dibayar_petani_f == 0 || row.indeks_konsumsi_rumah_tangga_f == 0 || row.indeks_bppbm_f == 0)
                            var fHTML = '<button type="button" class="btn btn-xs btn-belt-warning nilaintp" data-title="Perikanan Tangkap" data-tbl="perikanan_tangkap" data-idtbl="perikanan_tangkap" title="View data">Perikanan Tangkap</button>&nbsp;';
                        else
                            var fHTML = '<button type="button" class="btn btn-xs btn-belt-success nilaintp" data-title="Perikanan Tangkap" data-tbl="perikanan_tangkap" data-idtbl="perikanan_tangkap" title="View data">Perikanan Tangkap</button>&nbsp;';


                        if (row.nilai_tukar_petani_ntpi_g == 0 || row.nilai_tukar_usaha_pertanian_g == 0 || row.indeks_harga_diterima_petani_g == 0 || row.budidaya_air_tawar_g == 0 || row.budidaya_laut_g == 0 || row.indeks_harga_dibayar_petani_g == 0 || row.indeks_konsumsi_rumah_tangga_g == 0 || row.indeks_bppbm_g == 0)
                            var gHTML = '<button type="button" class="btn btn-xs btn-belt-warning nilaintp" data-title="Perikanan Budidaya" data-tbl="perikanan_budidaya" data-idtbl="perikanan_budidaya" title="View data">Perikanan Budidaya</button>&nbsp;';
                        else
                            var gHTML = '<button type="button" class="btn btn-xs btn-belt-success nilaintp" data-title="Perikanan Budidaya" data-tbl="perikanan_budidaya" data-idtbl="perikanan_budidaya" title="View data">Perikanan Budidaya</button>&nbsp;';


                        return aHTML + bHTML + cHTML + dHTML + eHTML + fHTML + gHTML;
                        // + laHTML + cHTML + ekHTML + asHTML;
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

        ntptbl.on('xhr.dt', function(e, settings, json, xhr) {
            // //(json);
            csrfHash = json.csrf.csrfHash;
            $('input[name="' + csrfName + '"]').val(csrfHash);
        });

        $('#ntptbl_filter input').addClass('form-control').attr('placeholder', 'Search Data');
        $('#ntptbl_length select').addClass('form-control');

        // Form Reset
        function formReset() {
            $('#formEntry').attr('action', site + 'ntp/ntp/create');
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

            var data = ntptbl.api().row($(this).parents('tr')).data();
            // //(data);
            e.stopPropagation();
            formReset();

            $('#add_monday_date').val(data.bulan_ntp);
            $('#ket_ntp').val(data.ket_ntp);


            var descBox = $('.descBox');
            descBox.empty();

            var content = "<table class='table table-bordered basic-datatables no-footer'>"
            // Tanaman Pangan
            content += '<tr style="background-color: #f7f8fa;font-weight: bold;"> <td colspan="2">TANAMAN PANGAN : </td></tr>';
            content += '<tr> <td>Nilai Tukar Petani (NTPP)</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_petani_ntpp_a) + '</td></tr>';
            content += '<tr> <td>Nilai Tukar Usaha Pertanian</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_usaha_pertanian_a) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Diterima Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_diterima_petani_a) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Padi</td> <td class="text-right">' + abbreviateNumber(data.padi_a) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Palawijaya</td> <td class="text-right">' + abbreviateNumber(data.palawijaya_a) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Dibayar Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_a) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indeks Konsumsi Rumah Tangga</td> <td class="text-right">' + abbreviateNumber(data.indeks_konsumsi_rumah_tangga_a) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indexs BPPBM</td> <td class="text-right">' + abbreviateNumber(data.indeks_bppbm_a) + '</td></tr>';

            // Hortikultura
            content += '<tr style="background-color: #f7f8fa;font-weight: bold;"> <td colspan="2">HORTIKULTURA : </td></tr>';
            content += '<tr> <td>Nilai Tukar Petani (NTPH)</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_petani_ntph_b) + '</td></tr>';
            content += '<tr> <td>Nilai Tukar Usaha Pertanian</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_usaha_pertanian_b) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Diterima Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_diterima_petani_b) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Sayur-sayuran</td> <td class="text-right">' + abbreviateNumber(data.sayur_sayuran_b) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Buah-buahan</td> <td class="text-right">' + abbreviateNumber(data.buah_buahan_b) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Tanaman Obat</td> <td class="text-right">' + abbreviateNumber(data.tanaman_obat_b) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Dibayar Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_b) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indeks Konsumsi Rumah Tangga</td> <td class="text-right">' + abbreviateNumber(data.indeks_konsumsi_rumah_tangga_b) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indexs BPPBM</td> <td class="text-right">' + abbreviateNumber(data.indeks_bppbm_b) + '</td></tr>';

            // Tanaman Perkebunan Rakyat
            content += '<tr style="background-color: #f7f8fa;font-weight: bold;"> <td colspan="2">TANAMAN PERKEBUNAN RAKYAT : </td></tr>';
            content += '<tr> <td>Nilai Tukar Petani (NTPR)</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_petani_ntpr_c) + '</td></tr>';
            content += '<tr> <td>Nilai Tukar Usaha Pertanian</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_usaha_pertanian_c) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Diterima Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_diterima_petani_c) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Tanaman Perkebunan Rakyat (TPR)</td> <td class="text-right">' + abbreviateNumber(data.tanaman_perkebunan_rakyat_tpr_c) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Dibayar Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_c) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indeks Konsumsi Rumah Tangga</td> <td class="text-right">' + abbreviateNumber(data.indeks_konsumsi_rumah_tangga_c) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indexs BPPBM</td> <td class="text-right">' + abbreviateNumber(data.indeks_bppbm_c) + '</td></tr>';

            // Peternakan
            content += '<tr style="background-color: #f7f8fa;font-weight: bold;"> <td colspan="2">PETERNAKAN : </td></tr>';
            content += '<tr> <td>Nilai Tukar Petani (NTPT)</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_petani_ntpt_d) + '</td></tr>';
            content += '<tr> <td>Nilai Tukar Usaha Pertanian</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_usaha_pertanian_d) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Diterima Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_diterima_petani_d) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Ternak Besar</td> <td class="text-right">' + abbreviateNumber(data.ternak_besar_d) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Ternak Kecil</td> <td class="text-right">' + abbreviateNumber(data.ternak_kecil_d) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Unggas</td> <td class="text-right">' + abbreviateNumber(data.unggas_d) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Hasil Ternak</td> <td class="text-right">' + abbreviateNumber(data.hasil_ternak_d) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Dibayar Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_d) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indeks Konsumsi Rumah Tangga</td> <td class="text-right">' + abbreviateNumber(data.indeks_konsumsi_rumah_tangga_d) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indexs BPPBM</td> <td class="text-right">' + abbreviateNumber(data.indeks_bppbm_d) + '</td></tr>';

            // Perikanan
            content += '<tr style="background-color: #f7f8fa;font-weight: bold;"> <td colspan="2">PERIKANAN : </td></tr>';
            content += '<tr> <td>Nilai Tukar Petani (NTNP)</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_petani_ntnp_e) + '</td></tr>';
            content += '<tr> <td>Nilai Tukar Usaha Pertanian</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_usaha_pertanian_e) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Diterima Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_diterima_petani_e) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Tangkap</td> <td class="text-right">' + abbreviateNumber(data.tangkap_e) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Budidaya</td> <td class="text-right">' + abbreviateNumber(data.budidaya_e) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Dibayar Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_e) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indeks Konsumsi Rumah Tangga</td> <td class="text-right">' + abbreviateNumber(data.indeks_konsumsi_rumah_tangga_e) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indexs BPPBM</td> <td class="text-right">' + abbreviateNumber(data.indeks_bppbm_e) + '</td></tr>';

            // Perikanan Tangkap
            content += '<tr style="background-color: #f7f8fa;font-weight: bold;"> <td colspan="2">PERIKANAN TANGKAP : </td></tr>';
            content += '<tr> <td>Nilai Tukar Petani (NTN)</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_petani_ntn_f) + '</td></tr>';
            content += '<tr> <td>Nilai Tukar Usaha Pertanian</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_usaha_pertanian_f) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Diterima Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_diterima_petani_f) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Penangkapan Perairan Umum</td> <td class="text-right">' + abbreviateNumber(data.penangkapan_perairan_umum_f) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Penangkapan Laut</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_f) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Dibayar Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_f) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indeks Konsumsi Rumah Tangga</td> <td class="text-right">' + abbreviateNumber(data.indeks_konsumsi_rumah_tangga_f) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indexs BPPBM</td> <td class="text-right">' + abbreviateNumber(data.indeks_bppbm_f) + '</td></tr>';

            // Perikanan Budidaya
            content += '<tr style="background-color: #f7f8fa;font-weight: bold;"> <td colspan="2">PERIKANAN BUDIDAYA : </td></tr>';
            content += '<tr> <td>Nilai Tukar Petani (NTPi)</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_petani_ntpi_g) + '</td></tr>';
            content += '<tr> <td>Nilai Tukar Usaha Pertanian</td> <td class="text-right">' + abbreviateNumber(data.nilai_tukar_usaha_pertanian_g) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Diterima Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_diterima_petani_g) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Budidaya Air Tawar</td> <td class="text-right">' + abbreviateNumber(data.budidaya_air_tawar_g) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Budidaya Air Laut</td> <td class="text-right">' + abbreviateNumber(data.budidaya_laut_g) + '</td></tr>';
            content += '<tr> <td>Indeks Harga yang Dibayar Petani</td> <td class="text-right">' + abbreviateNumber(data.indeks_harga_dibayar_petani_g) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indeks Konsumsi Rumah Tangga</td> <td class="text-right">' + abbreviateNumber(data.indeks_konsumsi_rumah_tangga_g) + '</td></tr>';
            content += '<tr> <td>&nbsp;&nbsp;- Indexs BPPBM</td> <td class="text-right">' + abbreviateNumber(data.indeks_bppbm_g) + '</td></tr>';

            content += "</table>"

            descBox.append(content);

            $('.lblPass').text('');
            $('#save').hide();
            $('#modalEntryForm').modal({
                backdrop: 'static'
            });
        });

        $(document).on('click', '.btnEdit', function(e) {

            $('#judul-form').html('EDIT ');

            var data = ntptbl.api().row($(this).parents('tr')).data();
            // //(data);

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

            var id_ntp = $(this).data('id');
            // //(id_ntp);
            var postData = {
                'id_ntp': id_ntp,
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
                                    url: site + 'ntp/ntp/delete',
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
                                        ntptbl.api().ajax.reload(null, false);
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
                                            ntptbl.api().ajax.reload(null, false);
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

        $(document).on('click', '.nilaintp', function(e) {

            // Data penyertaan modal
            var title = $(this).data('title');
            var tbl = $(this).data('tbl');
            var id_tbl = $(this).data('idtbl');
            // //(id_tbl)
            $('#jenis_ntp').html(title.toUpperCase());

            // Data Badan Usaha
            var data = ntptbl.api().row($(this).parents('tr')).data();
            $('#title-ntp').html(data.bulan_ntp.toUpperCase());

            $.ajax({
                url: site + "ntp/ntp/fetch",
                type: "POST",
                data: {
                    csrf_test_name: csrfHash,
                    nm_tbl: tbl,
                    id_tbl: id_tbl,
                    id_ntp: data.id_ntp,
                },
                success: function(data) {
                    // //(data);
                    csrfHash = data.csrf.csrfHash;
                    $('input[name="' + csrfName + '"]').val(csrfHash);
                    $('#id_ntp').val(data.id_ntp);
                    $('#id_tbl').val(data.id_tbl);
                    $('#nm_tbl').val(data.nm_tbl);

                    var boxForm = '';

                    $.each(data.data, function(key, value) {
                        // //(key + ' | ' + value);
                        boxForm += '<div class="form-group required">' +
                            '<label for="' + key + '" class="control-label"><b>' + key.replace("_", " ").substring(0, key.length - 2).toUpperCase() + ' <font color="red">*</font></b></label>' +
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
                                            $('#penyertaanmodal').animate({
                                                scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, textarea, select').first().focus().offset().top - 300)
                                            }, 'slow');
                                        } else {
                                            // //('masuk status 1');
                                            $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                                                '<strong>Sukses!</strong> ' + data.message +
                                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                                '</div>');
                                            $('#penyertaanmodal').modal('toggle');
                                            ntptbl.api().ajax.reload(null, false);
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

        // Filter on Submit
        $('#formFilter').submit(function(e) {
            e.preventDefault();
            var serialized = $(this).serializeArray();
            ntptbl.api().ajax.reload();
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




    });
</script>