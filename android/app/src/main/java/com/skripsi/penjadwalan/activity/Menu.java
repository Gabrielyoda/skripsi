package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.LinearLayout;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.util.PrefUtil;

public class Menu extends AppCompatActivity {
    LinearLayout peminjaman,kp,view;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);

        peminjaman = findViewById(R.id.lnr_peminjaman_lab);
        kp = findViewById(R.id.lnr_kp);
        view = findViewById(R.id.lnr_view_peminjaman);

        User user = PrefUtil.getUser(this, PrefUtil.USER_SESSION);
        String jabatan = user.getData().getJabatan();

        kp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(jabatan.equals("Dosen")){
                    Intent intent = new Intent(Menu.this, Tambah_KuliahPenggantiDosen.class);
                    startActivity(intent);
                }
                else {
                    Intent intent = new Intent(Menu.this, Tambah_KuliahPenggantiAsisten.class);
                    startActivity(intent);
                }
            }
        });

        view.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Menu.this, Peminjaman_Lab.class);
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
