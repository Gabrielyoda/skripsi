package com.skripsi.penjadwalan.adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.activity.DetailPeminjaman;
import com.skripsi.penjadwalan.activity.Peminjaman_Lab;
import com.skripsi.penjadwalan.model.Peminjaman;
import com.skripsi.penjadwalan.model.Pengganti;

import java.util.ArrayList;

public class PeminjamanAdapter extends RecyclerView.Adapter<PeminjamanAdapter.HolderPeminjaman> {
    private ArrayList<Peminjaman> dataPeminjaman;
    private LayoutInflater inflater;

    private Context ctx;

    public PeminjamanAdapter(Context ctx, ArrayList<Peminjaman> mList) {
        this.ctx = ctx;
        inflater = LayoutInflater.from(ctx);
        this.dataPeminjaman = mList;
    }

    @NonNull
    @Override
    public HolderPeminjaman onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_jadwal, parent, false);
        return new PeminjamanAdapter.HolderPeminjaman(mView);
    }

    @Override
    public void onBindViewHolder(@NonNull HolderPeminjaman holder, int position) {
        final Peminjaman jadwal = dataPeminjaman.get(position);
        holder.nama_acara.setText(jadwal.getJudul());
        holder.nama.setText(jadwal.getNama());
        holder.waktu.setText(jadwal.getJam());
        holder.lab.setText(jadwal.getLab());

        holder.lyt_parent.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(ctx, DetailPeminjaman.class);
                intent.putExtra("id_pinjam",jadwal.getId_peminjaman());
                intent.putExtra("nama_pinjam",jadwal.getNama());
                intent.putExtra("judul_pinjam",jadwal.getJudul());
                intent.putExtra("keterangan_pinjam",jadwal.getKeterangan());
                intent.putExtra("email_pinjam",jadwal.getEmail());
                ctx.startActivity(intent);
//
            }
        });
    }

    @Override
    public int getItemCount() {
        return dataPeminjaman.size();
    }

    public class HolderPeminjaman extends RecyclerView.ViewHolder {
        TextView nama_acara,nama,waktu,lab;
        public View lyt_parent;
        public HolderPeminjaman(@NonNull View itemView) {
            super(itemView);
            nama_acara = itemView.findViewById(R.id.txt_nama_matkul);
            nama = itemView.findViewById(R.id.txt_nama_dosen);
            waktu = itemView.findViewById(R.id.txt_jam);
            lab = itemView.findViewById(R.id.txt_lab);
            lyt_parent = itemView.findViewById(R.id.lyt_parent);
        }
    }
}
