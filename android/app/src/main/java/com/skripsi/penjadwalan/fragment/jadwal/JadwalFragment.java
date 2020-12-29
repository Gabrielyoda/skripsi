package com.skripsi.penjadwalan.fragment.jadwal;

import android.app.DatePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.DatePicker;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProviders;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.skripsi.penjadwalan.activity.Menu;
import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.adapter.JadwalAdapter;
import com.skripsi.penjadwalan.fragment.view_model.JadwalHarianViewModel;
import com.skripsi.penjadwalan.model.Jadwal;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.util.PrefUtil;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;

public class JadwalFragment extends Fragment {
    ImageView btn_jadwal;
    TextView tanggal;
    Calendar myCalendar;
    String bulan_ar[] = {"Januari", "Februari", "Maret","April", "Mei", "Juni","Juli","Agustus", "Oktober","September", "November","Desember"};
    FloatingActionButton menu;

    private ArrayList<Jadwal> list = new ArrayList<>();
    private JadwalAdapter adapter;
    private ProgressBar progressBar;

    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View root = inflater.inflate(R.layout.fragment_jadwal, container, false);
        btn_jadwal = root.findViewById(R.id.img_jadwal);
        tanggal = root.findViewById(R.id.txt_tanggal_jadwal);
        progressBar = root.findViewById(R.id.progressBar);
        menu = root.findViewById(R.id.fab1);
        RecyclerView rvJadwal = root.findViewById(R.id.recyclerJadwalTanggal);

        adapter = new JadwalAdapter(list);
        adapter.notifyDataSetChanged();

        rvJadwal.setLayoutManager(new LinearLayoutManager(getContext()));
        rvJadwal.setAdapter(adapter);

        User user = PrefUtil.getUser(getActivity(), PrefUtil.USER_SESSION);
        String token = user.getData().getToken();


        //ini untuk dapetin hari
        SimpleDateFormat hari = new SimpleDateFormat("EEEE");
        Date d=new Date();
        String date = hari.format(d);

        myCalendar = Calendar.getInstance();
        String formatTanggal = "dd-MM-yyyy";
        SimpleDateFormat sdf = new SimpleDateFormat(formatTanggal);

        String formattgl = "yyyy-MM-dd";
        SimpleDateFormat sdftgl = new SimpleDateFormat(formattgl);
        String tgl = sdftgl.format(myCalendar.getTime());

        String tanggal_string = sdf.format(myCalendar.getTime());
        String tanggal_text = tanggal_string.substring(0,2);
        int bulan_angka = Integer.parseInt(tanggal_string.substring(3,5));
        String bulan_text = bulan_ar[bulan_angka-1];
        String tahun_text = tanggal_string.substring(6);
        String Hari = namaHari(date);
        String tanggal_all =Hari + ","+ tanggal_text + " " + bulan_text + " " + tahun_text;

        final JadwalHarianViewModel jadwalViewModel = ViewModelProviders.of(this).get(JadwalHarianViewModel.class);
        jadwalViewModel.getJadwalHarian().observe(getViewLifecycleOwner(), getJadwal);
        jadwalViewModel.setJadwalHarian(token, tgl, Hari);

        tanggal.setText(tanggal_all);

        btn_jadwal.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new DatePickerDialog(getActivity(), new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {

                        myCalendar.set(Calendar.YEAR, year);
                        myCalendar.set(Calendar.MONTH, month);
                        myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);

                        //ini untuk hari
                        SimpleDateFormat simpledateformat = new SimpleDateFormat("EEEE");
                        Date date = new Date(year, month, dayOfMonth-1);
                        String dayOfWeek = simpledateformat.format(date);

                        String formattgl = "yyyy-MM-dd";
                        SimpleDateFormat sdftgl = new SimpleDateFormat(formattgl);
                        String tgl = sdftgl.format(myCalendar.getTime());

                       // String formatTanggal = "yyyy-MM-dd";
                        String formatTanggal = "dd-MM-yyyy";
                        SimpleDateFormat sdf = new SimpleDateFormat(formatTanggal);
                        String tanggal_string = sdf.format(myCalendar.getTime());
                        int bulan_angka = Integer.parseInt(tanggal_string.substring(3,5));
                        String tanggal_text = tanggal_string.substring(0,2);
                        String bulan_text = bulan_ar[bulan_angka-1];
                        String tahun_text = tanggal_string.substring(6);
                        String Hari = namaHari(dayOfWeek);
                        String tanggal_all =Hari+","+ tanggal_text + " " + bulan_text + " " + tahun_text;

                        jadwalViewModel.getJadwalHarian().observe(getViewLifecycleOwner(), getJadwal);
                        jadwalViewModel.setJadwalHarian(token, tgl, Hari);


                        tanggal.setText(tanggal_all);
                    }
                },
                    myCalendar.get(Calendar.YEAR), myCalendar.get(Calendar.MONTH),
                    myCalendar.get(Calendar.DAY_OF_MONTH)).show();
            }
        });

        menu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getActivity(), Menu.class);
                startActivity(intent);
            }
        });

        return root;
    }



    String namaHari(String nama_hari){
        switch(nama_hari){
            case "Monday"
                :nama_hari = "Senin";
            break;
            case "Tuesday"
                :nama_hari = "Selasa";
            break;
            case "Wednesday"
                :nama_hari = "Rabu";
            break;
            case "Thursday"
                :nama_hari = "Kamis";
            break;
            case "Friday"
                :nama_hari = "Jumat";
            break;
            case "Saturday"
                :nama_hari = "Sabtu";
            break;
            case "Sunday"
                :nama_hari = "Minggu";
            break;

            default:nama_hari = "Tidak diketahui";
            break;
        }

        return nama_hari;
    }

    private Observer<ArrayList<Jadwal>> getJadwal = new Observer<ArrayList<Jadwal>>() {
        @Override
        public void onChanged(ArrayList<Jadwal> jadwals) {

            if (jadwals != null) {
                adapter.setData(jadwals);
            }
        }
    };
}
