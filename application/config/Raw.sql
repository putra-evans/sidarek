SELECT 
	jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    jenis.nama as "jenis_nama",
    jenis.satuan as "jenis_satuan",
    komoditas.nama as "komoditas_nama",
    kategori.nama as "kategori_nama",
    harga.harga
FROM ma_komoditas_jenis jenis
LEFT JOIN ref_komoditas AS komoditas ON komoditas.id_komoditas = jenis.id_komoditas
LEFT JOIN ma_komoditas_kategori AS kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori
JOIN ta_komoditas_harga AS harga ON harga.id_komoditas_jenis = jenis.id_komoditas_jenis



SELECT 
	jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    jenis.nama as "jenis_nama",
    jenis.satuan as "jenis_satuan",
    komoditas.nama as "komoditas_nama",
    kategori.nama as "kategori_nama",
    harga.harga
FROM ma_komoditas_jenis jenis
LEFT JOIN ref_komoditas AS komoditas ON komoditas.id_komoditas = jenis.id_komoditas
LEFT JOIN ma_komoditas_kategori AS kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori
RIGHT JOIN ta_komoditas_harga AS harga ON harga.id_komoditas_jenis = jenis.id_komoditas_jenis
WHERE harga.minggu_tahun = 31
AND YEAR(harga.monday_date) = 2020

UNION

SELECT 
    jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    jenis.nama as "jenis_nama",
    jenis.satuan as "jenis_satuan",
    komoditas.nama as "komoditas_nama",
    kategori.nama as "kategori_nama",
    0
FROM ma_komoditas_jenis as jenis
LEFT JOIN ref_komoditas AS komoditas ON komoditas.id_komoditas = jenis.id_komoditas
LEFT JOIN ma_komoditas_kategori AS kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori
WHERE id_komoditas_jenis NOT IN (
    SELECT id_komoditas_jenis 
    FROM ta_komoditas_harga as harga
    WHERE harga.minggu_tahun = 31
	AND YEAR(harga.monday_date) = 2020
)


SELECT 
	jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    jenis.nama as "jenis_nama",
    jenis.satuan as "jenis_satuan",
    komoditas.nama as "komoditas_nama",
    kategori.nama as "kategori_nama"
FROM ma_komoditas_jenis jenis
LEFT JOIN ref_komoditas AS komoditas ON komoditas.id_komoditas = jenis.id_komoditas
LEFT JOIN ma_komoditas_kategori AS kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori




SELECT 
	jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    jenis.nama as "jenis_nama",
    jenis.satuan as "jenis_satuan",
    komoditas.nama as "komoditas_nama",
    kategori.nama as "kategori_nama",
    harga.harga
FROM ma_komoditas_jenis jenis
LEFT JOIN ref_komoditas AS komoditas ON komoditas.id_komoditas = jenis.id_komoditas
LEFT JOIN ma_komoditas_kategori AS kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori
RIGHT JOIN ta_komoditas_harga AS harga ON harga.id_komoditas_jenis = jenis.id_komoditas_jenis
WHERE harga.minggu_tahun = 32
AND YEAR(harga.monday_date) = 2020

UNION

SELECT 
    jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    jenis.nama as "jenis_nama",
    jenis.satuan as "jenis_satuan",
    komoditas.nama as "komoditas_nama",
    kategori.nama as "kategori_nama",
    0
FROM ma_komoditas_jenis as jenis
LEFT JOIN ref_komoditas AS komoditas ON komoditas.id_komoditas = jenis.id_komoditas
LEFT JOIN ma_komoditas_kategori AS kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori
WHERE id_komoditas_jenis NOT IN (
    SELECT id_komoditas_jenis 
    FROM ta_komoditas_harga as harga
    WHERE harga.minggu_tahun = 32
	AND YEAR(harga.monday_date) = 2020
)



SELECT 
	jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    jenis.nama as "jenis_nama",
    jenis.satuan as "jenis_satuan",
    harga.harga
FROM ma_komoditas_jenis jenis
LEFT JOIN ta_komoditas_harga AS harga ON harga.id_komoditas_jenis = jenis.id_komoditas_jenis
WHERE harga.minggu_tahun = 31
AND YEAR(harga.monday_date) = 2020


SELECT 
	jenis.id_komoditas_jenis,
    jenis.id_komoditas,
    jenis.id_komoditas_kategori,
    komoditas.nama as "nama_komoditas",
    kategori.nama as "kategori_komoditas",
    jenis.satuan,
    jenis.nama as "jenis_komoditas",
    harga.id_komoditas_harga,
    harga.harga
FROM ma_komoditas_jenis jenis
LEFT JOIN ref_komoditas AS komoditas ON komoditas.id_komoditas = jenis.id_komoditas
LEFT JOIN ma_komoditas_kategori AS kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori
LEFT JOIN ta_komoditas_harga AS harga ON harga.id_komoditas_jenis = jenis.id_komoditas_jenis 
AND harga.minggu_tahun = 31
AND YEAR(harga.monday_date) = 2020