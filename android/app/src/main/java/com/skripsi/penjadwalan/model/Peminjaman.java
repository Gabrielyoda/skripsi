package com.skripsi.penjadwalan.model;

public class Peminjaman {

    private String id_peminjaman;
    private String judul,nama,jam,lab,email,keterangan;

    public String getJudul() {
        return judul;
    }

    public void setJudul(String judul) {
        this.judul = judul;
    }

    public String getNama() {
        return nama;
    }

    public void setNama(String nama) {
        this.nama = nama;
    }

    public String getJam() {
        return jam;
    }

    public void setJam(String jam) {
        this.jam = jam;
    }

    public String getLab() {
        return lab;
    }

    public void setLab(String lab) {
        this.lab = lab;
    }

    public String getId_peminjaman() {
        return id_peminjaman;
    }

    public void setId_peminjaman(String id_peminjaman) {
        this.id_peminjaman = id_peminjaman;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getKeterangan() {
        return keterangan;
    }

    public void setKeterangan(String keterangan) {
        this.keterangan = keterangan;
    }
}
