package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

import com.skripsi.penjadwalan.R;

public class DetailPeminjaman extends AppCompatActivity {
    ProgressDialog pd;
    TextView nama,judul,keterangan,email;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_peminjaman);

        nama = findViewById(R.id.txt_nama_pinjam);
        judul = findViewById(R.id.txt_judul_pinjam);
        keterangan = findViewById(R.id.txt_keterangan_pinjam);
        email = findViewById(R.id.txt_email_pinjam);

        Intent data = getIntent();
        nama.setText(data.getStringExtra("nama_pinjam"));
        judul.setText(data.getStringExtra("judul_pinjam"));
        keterangan.setText(data.getStringExtra("keterangan_pinjam"));
        email.setText(data.getStringExtra("email_pinjam"));

    }
}
