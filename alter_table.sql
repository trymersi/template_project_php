-- Tambahkan kolom deskripsi ke tabel produk
USE template_project_php;
ALTER TABLE produk ADD COLUMN deskripsi TEXT NULL AFTER stok; 