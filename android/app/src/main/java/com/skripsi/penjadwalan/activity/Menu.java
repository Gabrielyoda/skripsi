package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.LinearLayout;

import com.skripsi.penjadwalan.R;

public class Menu extends AppCompatActivity {
    LinearLayout peminjaman,kp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);

        peminjaman = findViewById(R.id.lnr_peminjaman_lab);
        kp = findViewById(R.id.lnr_kp);

        kp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Menu.this, Tambah_KuliahPengganti.class);
                startActivity(intent);
            }
        });

        peminjaman.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Menu.this, Tambah_Pinjam_Lab.class);
                startActivity(intent);
            }
        });
    }
}
