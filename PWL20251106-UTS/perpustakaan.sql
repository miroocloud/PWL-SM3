SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = '';

CREATE DATABASE IF NOT EXISTS perpustakaan_uts
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE perpustakaan_uts;

DROP VIEW IF EXISTS v_buku_lengkap;
DROP TABLE IF EXISTS buku;
DROP TABLE IF EXISTS penulis;

CREATE TABLE penulis (
    id_penulis INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    telepon VARCHAR(20) DEFAULT NULL,
    alamat TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_penulis),
    UNIQUE KEY uk_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE buku (
    id_buku INT NOT NULL AUTO_INCREMENT,
    judul VARCHAR(200) NOT NULL,
    id_penulis INT DEFAULT NULL,
    isbn VARCHAR(30) DEFAULT NULL,
    tahun_terbit INT DEFAULT NULL,
    kategori VARCHAR(50) DEFAULT NULL,
    penerbit VARCHAR(100) DEFAULT NULL,
    jumlah_halaman INT DEFAULT NULL,
    deskripsi TEXT DEFAULT NULL,
    status ENUM('tersedia','dipinjam','rusak') DEFAULT 'tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_buku),
    UNIQUE KEY uk_isbn (isbn),
    CONSTRAINT fk_buku_penulis FOREIGN KEY (id_penulis)
        REFERENCES penulis (id_penulis)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO penulis (nama, email, telepon, alamat) VALUES
('Tere Liye', 'tere.liye@email.com', '081234567890', 'Jakarta, Indonesia'),
('Pramoedya Ananta Toer', 'pramoedya@email.com', '081234567891', 'Blora, Jawa Tengah'),
('Andrea Hirata', 'andrea.hirata@email.com', '081234567892', 'Belitung, Bangka Belitung'),
('Dee Lestari', 'dee.lestari@email.com', '081234567893', 'Bandung, Jawa Barat'),
('Raditya Dika', 'raditya.dika@email.com', '081234567894', 'Jakarta, Indonesia'),
('Fiersa Besari', 'fiersa.besari@email.com', '081234567895', 'Yogyakarta, Indonesia'),
('Boy Candra', 'boy.candra@email.com', '081234567896', 'Batam, Kepulauan Riau'),
('Sapardi Djoko Damono', NULL, NULL, 'Solo, Jawa Tengah'),
('Seno Gumira Ajidarma', 'seno.gumira@email.com', '081234567898', 'Boston, Amerika Serikat'),
('Ahmad Tohari', NULL, '081234567899', 'Purbalingga, Jawa Tengah');

INSERT INTO buku (judul, id_penulis, isbn, tahun_terbit, kategori, penerbit, jumlah_halaman, deskripsi, status) VALUES
('Hujan', 1, '978-602-291-667-2', 2016, 'Fiksi', 'Gramedia Pustaka Utama', 320, 'Novel tentang perjalanan spiritual seorang pemuda dalam menemukan jati dirinya.', 'tersedia'),
('Bumi Manusia', 2, '978-979-22-2080-0', 1980, 'Sejarah', 'Hasta Mitra', 536, 'Tetralogi Buru yang mengisahkan kehidupan di masa kolonial Belanda.', 'tersedia'),
('Laskar Pelangi', 3, '978-979-22-2592-8', 2005, 'Fiksi', 'Bentang Pustaka', 529, 'Kisah inspiratif anak-anak Belitung dalam menempuh pendidikan.', 'dipinjam'),
('Supernova: Kesatria, Putri, dan Bintang Jatuh', 4, '978-979-22-0871-6', 2001, 'Fiksi', 'Truedee Books', 226, 'Novel yang memadukan sains, filosofi, dan spiritualitas.', 'tersedia'),
('Kambing Jantan', 5, '978-602-291-234-6', 2005, 'Humor', 'Gagas Media', 200, 'Kumpulan cerita humor dari pengalaman hidup Raditya Dika.', 'tersedia'),
('Garis Waktu', 6, '978-602-06-1234-5', 2018, 'Puisi', 'Media Kita', 150, 'Kumpulan puisi tentang perjalanan waktu dan kehidupan.', 'tersedia'),
('Origami Hati', 7, '978-602-06-5678-9', 2017, 'Puisi', 'Bukune', 180, 'Kumpulan puisi cinta dan kehidupan sehari-hari.', 'tersedia'),
('Hujan Bulan Juni', 8, '978-979-22-3456-7', 1994, 'Puisi', 'Gramedia Pustaka Utama', 120, 'Kumpulan puisi klasik Indonesia yang penuh makna.', 'rusak'),
('Saksi Mata', 9, '978-602-291-789-1', 2002, 'Fiksi', 'Galang Press', 280, 'Novel yang mengangkat isu sosial dan politik Indonesia.', 'tersedia'),
('Ronggeng Dukuh Paruk', 10, '978-979-22-4567-8', 1982, 'Fiksi', 'Gramedia Pustaka Utama', 400, 'Trilogi tentang kehidupan seorang ronggeng di desa Jawa.', 'tersedia'),
('Pulang', 1, '978-602-291-888-9', 2018, 'Fiksi', 'Gramedia Pustaka Utama', 450, 'Kelanjutan novel Hujan yang mengisahkan perjalanan pulang.', 'tersedia'),
('Perahu Kertas', 4, '978-979-22-5678-9', 2009, 'Fiksi', 'Bentang Pustaka', 456, 'Novel romantis tentang cinta dan mimpi anak muda Jakarta.', 'dipinjam'),
('Cinta Brontosaurus', 5, '978-602-291-999-0', 2006, 'Humor', 'Gagas Media', 220, 'Lanjutan dari Kambing Jantan dengan cerita humor yang fresh.', 'tersedia'),
('Edensor', 3, '978-979-22-6789-0', 2007, 'Fiksi', 'Bentang Pustaka', 425, 'Sekuel dari Laskar Pelangi tentang petualangan Ikal di Eropa.', 'tersedia'),
('Negeri 5 Menara', NULL, '978-602-291-111-1', 2009, 'Fiksi', 'Gramedia Pustaka Utama', 640, 'Novel tentang perjuangan santri menggapai mimpi pendidikan.', 'tersedia');

CREATE OR REPLACE ALGORITHM=MERGE
VIEW v_buku_lengkap AS
SELECT
    b.id_buku,
    b.judul,
    b.isbn,
    b.tahun_terbit,
    b.kategori,
    b.penerbit,
    b.jumlah_halaman,
    b.deskripsi,
    b.status,
    p.id_penulis,
    p.nama AS nama_penulis,
    p.email AS email_penulis,
    b.created_at,
    b.updated_at
FROM buku AS b
LEFT JOIN penulis AS p ON b.id_penulis = p.id_penulis;

SET FOREIGN_KEY_CHECKS = 1;
