package com.skripsi.penjadwalan.model;

public class Matakuliah {
    String id_mtk,nama_mtk,sks_mtk;
    String id_dosen,nama_dosen,kelompok;

    public String getId_mtk() {
        return id_mtk;
    }

    public void setId_mtk(String id_mtk) {
        this.id_mtk = id_mtk;
    }

    public String getNama_mtk() {
        return nama_mtk;
    }

    public void setNama_mtk(String nama_mtk) {
        this.nama_mtk = nama_mtk;
    }

    public String getSks_mtk() {
        return sks_mtk;
    }

    public void setSks_mtk(String sks_mtk) {
        this.sks_mtk = sks_mtk;
    }

    public String getId_dosen() {
        return id_dosen;
    }

    public void setId_dosen(String id_dosen) {
        this.id_dosen = id_dosen;
    }

    public String getNama_dosen() {
        return nama_dosen;
    }

    public void setNama_dosen(String nama_dosen) {
        this.nama_dosen = nama_dosen;
    }

    public String getKelompok() {
        return kelompok;
    }

    public void setKelompok(String kelompok) {
        this.kelompok = kelompok;
    }
}
