package com.skripsi.penjadwalan.adapter;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.model.Jadwal;

import java.util.ArrayList;

public class JadwalAdapter extends RecyclerView.Adapter<JadwalAdapter.ViewHoledor> {
    private ArrayList<Jadwal> jadwals;
    private OnItemClickCallback onItemClickCallback;


    public void setData(ArrayList<Jadwal> items) {
        jadwals.clear();
        jadwals.addAll(items);
        notifyDataSetChanged();
    }

    public void setOnItemClickCallback(OnItemClickCallback onItemClickCallback) {
        this.onItemClickCallback = onItemClickCallback;
    }

    public JadwalAdapter(ArrayList<Jadwal> listJadwal)
    {
        this.jadwals = listJadwal;

    }

    @NonNull
    @Override
    public ViewHoledor onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_jadwal, parent, false);
        return new JadwalAdapter.ViewHoledor(mView);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHoledor holder, int position) {
        final Jadwal jadwal = jadwals.get(position);
        holder.kelompok.setText(jadwal.getKelompok());
        holder.nama_matkul.setText(jadwal.getNama_matkul());
        holder.dosen.setText(jadwal.getNama_dosen());
        holder.waktu.setText(jadwal.getJam());
        holder.lab.setText(jadwal.getLab());

    }

    @Override
    public int getItemCount() {
        return jadwals.size();
    }

    public class ViewHoledor extends RecyclerView.ViewHolder {
        TextView kelompok,nama_matkul,dosen,waktu,lab;
        public ViewHoledor(@NonNull View itemView) {
            super(itemView);
            kelompok = itemView.findViewById(R.id.txt_kelompok);
            nama_matkul = itemView.findViewById(R.id.txt_nama_matkul);
            dosen = itemView.findViewById(R.id.txt_nama_dosen);
            waktu = itemView.findViewById(R.id.txt_jam);
            lab = itemView.findViewById(R.id.txt_lab);
        }
    }

    public interface OnItemClickCallback {
        void onItemClicked(Jadwal data);
    }
}
