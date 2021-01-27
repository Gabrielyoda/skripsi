package com.skripsi.penjadwalan.fragment.home;

import android.app.ProgressDialog;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProviders;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.adapter.JadwalAdapter;
import com.skripsi.penjadwalan.adapter.PenggantiAdapter;
import com.skripsi.penjadwalan.fragment.view_model.JadwalViewModel;
import com.skripsi.penjadwalan.fragment.view_model.PenggantiViewModel;
import com.skripsi.penjadwalan.model.Jadwal;
import com.skripsi.penjadwalan.model.Pengganti;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.util.PrefUtil;

import java.util.ArrayList;

public class HomeFragment extends Fragment {
    private ArrayList<Jadwal> list = new ArrayList<>();
    private ArrayList<Pengganti> list2 = new ArrayList<>();
    private JadwalAdapter adapter;
    private PenggantiAdapter adapter2;
    private ProgressBar progressBar;
    ProgressDialog pd;


    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View root = inflater.inflate(R.layout.fragment_home, container, false);
        progressBar = root.findViewById(R.id.progressBar);
        RecyclerView rvJadwal = root.findViewById(R.id.recyclerJadwal);
        RecyclerView rvPengganti = root.findViewById(R.id.recyclerPengganti);

        adapter = new JadwalAdapter(list);
        adapter.notifyDataSetChanged();

        adapter2 = new PenggantiAdapter(list2);
        adapter2.notifyDataSetChanged();

        rvJadwal.setLayoutManager(new LinearLayoutManager(getContext()));
        rvJadwal.setAdapter(adapter);

        rvPengganti.setLayoutManager(new LinearLayoutManager(getContext()));
        rvPengganti.setAdapter(adapter2);

        User user = PrefUtil.getUser(getActivity(), PrefUtil.USER_SESSION);
        String token = user.getData().getToken();


        final JadwalViewModel jadwalViewModel = ViewModelProviders.of(this).get(JadwalViewModel.class);
        jadwalViewModel.getJadwal().observe(getViewLifecycleOwner(), getJadwal);
        jadwalViewModel.setJadwal(token);

        final PenggantiViewModel penggantiViewModel = ViewModelProviders.of(this).get(PenggantiViewModel.class);
        penggantiViewModel.getPengganti().observe(getViewLifecycleOwner(), getPenggati);
        penggantiViewModel.setPengganti(token);
        showLoading(true);
        pd = new ProgressDialog(getActivity());
        pd.setMessage("Loading ...");
        pd.setCancelable(false);
        pd.show();

        return root;
    }

    private Observer<ArrayList<Jadwal>> getJadwal = new Observer<ArrayList<Jadwal>>() {
        @Override
        public void onChanged(ArrayList<Jadwal> jadwals) {

            if (jadwals != null) {
                adapter.setData(jadwals);
            }
        }
    };

    private Observer<ArrayList<Pengganti>> getPenggati = new Observer<ArrayList<Pengganti>>() {
        @Override
        public void onChanged(ArrayList<Pengganti> pengganti) {
            showLoading(true);

            if (pengganti != null) {
                adapter2.setData(pengganti);
                showLoading(false);
                pd.hide();
            }
        }
    };

    private void showLoading(Boolean state) {
        if (state) {
            progressBar.setVisibility(View.VISIBLE);
        } else {
            progressBar.setVisibility(View.GONE);
        }
    }
}
