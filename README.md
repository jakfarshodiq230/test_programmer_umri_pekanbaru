# Buat Tabel

Buat tabel mahasiswa
Kolom :

1. Nim
2. Nama
3. Program studi (relasi ke tabel prodi)
4. Tanggal lahir
5. password

Tabel prodi
Kolom :

1. Id
2. Nama prodi

Tabel jenis_bayar
Kolom :

1. id
2. nama_pembayaran

Tabel bayar
Kolom :

1. id
2. tanggal
3. id_jenis_bayar (relasi ke tabel jenis_bayar)
4. id_mahasiswa (relasi ke tabel mahasiswa) 5. jumlah

# Instruksi

1. buat login dengan tabel mahasiswa menggunakan nim & password
2. buat crud tabel prodi, mahasiswa, dan pembayaran
3. Buat laporan data siswa, dan pembayaran siswa
