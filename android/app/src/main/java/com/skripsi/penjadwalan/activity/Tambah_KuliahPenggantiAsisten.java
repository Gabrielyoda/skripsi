package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.app.DatePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.model.BaseResponse;
import com.skripsi.penjadwalan.model.Lab;
import com.skripsi.penjadwalan.model.Matakuliah;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.network.config.Config;
import com.skripsi.penjadwalan.network.interfaces.Api;
import com.skripsi.penjadwalan.util.PrefUtil;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.scalars.ScalarsConverterFactory;

import static android.R.layout.simple_spinner_item;

public class Tambah_KuliahPengganti extends AppCompatActivity {
    private ArrayList<Lab> labs;
    private ArrayList<Matakuliah> matakuliahs;
    private ArrayList<Matakuliah> dosen;
    private ArrayList<Matakuliah> kelompok;
    private android.widget.Spinner spinner_lab,spinner_mtk,spinner_dosen,spinner_kelompok,spinner_jam;
    private List<String> LabId = new ArrayList<String>();//add ids in this list
    private ArrayList<String> LabNama = new ArrayList<String>();
    private List<String> MtkId = new ArrayList<String>();//add ids in this list
    private ArrayList<String> MtkNama = new ArrayList<String>();
    private ArrayList<String> MtkSks = new ArrayList<String>();
    private List<String> DosenId = new ArrayList<String>();//add ids in this list
    private ArrayList<String> DosenNama = new ArrayList<String>();
    private ArrayList<String> KelompokNama = new ArrayList<String>();

    String ruang_lab,tanngal,id_mtk,sks,id_dosen,kelompokstr,jam_ajarstr;

    private ImageView tgl_pinjam;
    private String[] Item = {"07:10 - 08:50","08:00 - 09:40","08:55 - 10:35","09:45 - 11:30",
                            "10:40 - 12:25","11:35 - 13:20","12:30 - 14:15","13:25 - 15:10","14:20 - 16:05","15:15 - 17:00",
                            "16:10 - 17:55","17:05 - 18:50"};

    private String[] Item2 = {"07:10 - 09:40", "08:00 - 10:35", "08:55 - 11:30", "09:45 - 12:25", "10:40 - 13:20",
                            "11:35 - 14:15", "12:30 - 15:10", "13:25 - 16:05", "14:20 - 17:00", "15:15 - 17:55", "16:10 - 18:50"};

    Calendar myCalendar;
    String bulan_ar[] = {"Januari", "Februari", "Maret","April", "Mei", "Juni","Juli","Agustus", "Oktober","September", "November","Desember"};
    TextView txt_tgl;
    Button tambah;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tambah__kuliah_pengganti);

        spinner_lab = findViewById(R.id.spn_lab);
        spinner_mtk = findViewById(R.id.spn_mtk);
        spinner_dosen = findViewById(R.id.spn_dosen);
        spinner_kelompok = findViewById(R.id.spn_kelompok);
        spinner_jam = findViewById(R.id.spn_jamAjar);
        spinner_kelompok = findViewById(R.id.spn_kelompok);

        tgl_pinjam = findViewById(R.id.img_tgl_pengganti);
        txt_tgl = findViewById(R.id.txt_tgl_pinjam);

        tambah = findViewById(R.id.btn_tambah);

        dataLab();
        dataMtk();


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
        tanngal = tanggal_text + " " + bulan_text + " " + tahun_text;
        String tanggal_all =Hari + ","+ tanngal;

        txt_tgl.setText(tanggal_all);

        spinner_mtk.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //id_spinner = parent.getItemAtPosition(position).toString();
                id_mtk = MtkId.get(position);
                sks = MtkSks.get(position);
                DosenId.clear();
                DosenNama.clear();
                spinJam(sks);
                dataDosen(id_mtk);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        spinner_dosen.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //id_spinner = parent.getItemAtPosition(position).toString();
                id_dosen = DosenId.get(position);
                KelompokNama.clear();
                dataKelompok(id_mtk, id_dosen);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        spinner_kelompok.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //id_spinner = parent.getItemAtPosition(position).toString();
                kelompokstr = KelompokNama.get(position);

            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        spinner_lab.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //id_spinner = parent.getItemAtPosition(position).toString();
                ruang_lab = LabId.get(position);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        tgl_pinjam.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                DatePickerDialog datePickerDialog = new DatePickerDialog(Tambah_KuliahPengganti.this, new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                        view.setMinDate(System.currentTimeMillis() - 1000);
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
                        tanngal = tanggal_text + " " + bulan_text + " " + tahun_text;
                        String tanggal_all =Hari + ","+ tanngal;


                        txt_tgl.setText(tanggal_all);
                    }
                },
                    myCalendar.get(Calendar.YEAR), myCalendar.get(Calendar.MONTH),
                    myCalendar.get(Calendar.DAY_OF_MONTH));
                datePickerDialog.getDatePicker().setMinDate(System.currentTimeMillis() - 1000);
                datePickerDialog.show();
            }
        });



        tambah.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                tambahKp();
            }
        });
    }

    private void dataLab(){

        Retrofit retrofit = new Retrofit.Builder()
            .baseUrl(Config.BASE_URL)
            .addConverterFactory(ScalarsConverterFactory.create())
            .build();

        Api api = retrofit.create(Api.class);

        Call<String> call = api.getJSONString();

        call.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                Log.i("Responsestring", response.body().toString());
                //Toast.makeText()
                if (response.isSuccessful()) {
                    if (response.body() != null) {
                        Log.i("onSuccess", response.body().toString());

                        String jsonresponse = response.body().toString();
                        spinLab(jsonresponse);

                    } else {
                        Log.i("onEmptyResponse", "Returned empty response");//Toast.makeText(getContext(),"Nothing returned",Toast.LENGTH_LONG).show();
                    }
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });
    }

    private void dataMtk(){

        Retrofit retrofit = new Retrofit.Builder()
            .baseUrl(Config.BASE_URL)
            .addConverterFactory(ScalarsConverterFactory.create())
            .build();

        Api api = retrofit.create(Api.class);

        Call<String> call = api.getMatakuliah();

        call.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                Log.i("Responsestring", response.body().toString());
                //Toast.makeText()
                if (response.isSuccessful()) {
                    if (response.body() != null) {
                        Log.i("onSuccess", response.body().toString());

                        String jsonresponse = response.body().toString();
                        spinMtk(jsonresponse);

                    } else {
                        Log.i("onEmptyResponse", "Returned empty response");//Toast.makeText(getContext(),"Nothing returned",Toast.LENGTH_LONG).show();
                    }
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });
    }

    private void dataDosen(String id_mtk){

        Retrofit retrofit = new Retrofit.Builder()
            .baseUrl(Config.BASE_URL)
            .addConverterFactory(ScalarsConverterFactory.create())
            .build();

        Api api = retrofit.create(Api.class);

        Call<String> call = api.getDosen(id_mtk);

        call.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                Log.i("Responsestring", response.body().toString());
                //Toast.makeText()
                if (response.isSuccessful()) {
                    if (response.body() != null) {
                        Log.i("onSuccess", response.body().toString());

                        String jsonresponse = response.body().toString();
                        spinDosen(jsonresponse);

                    } else {
                        Log.i("onEmptyResponse", "Returned empty response");//Toast.makeText(getContext(),"Nothing returned",Toast.LENGTH_LONG).show();
                    }
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });
    }

    private void dataKelompok(String id_mtk,String id_dosen){

        Retrofit retrofit = new Retrofit.Builder()
            .baseUrl(Config.BASE_URL)
            .addConverterFactory(ScalarsConverterFactory.create())
            .build();

        Api api = retrofit.create(Api.class);

        Call<String> call = api.getkelompok(id_mtk, id_dosen);

        call.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                Log.i("Responsestring", response.body().toString());
                //Toast.makeText()
                if (response.isSuccessful()) {
                    if (response.body() != null) {
                        Log.i("onSuccess", response.body().toString());

                        String jsonresponse = response.body().toString();
                        spinKelompok(jsonresponse);

                    } else {
                        Log.i("onEmptyResponse", "Returned empty response");//Toast.makeText(getContext(),"Nothing returned",Toast.LENGTH_LONG).show();
                    }
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {

            }
        });
    }

    private void spinMtk(String response){

        try {

            JSONObject obj = new JSONObject(response);
            if(obj.optString("error").equals("false")){

                matakuliahs = new ArrayList<>();
                JSONArray dataArray  = obj.getJSONArray("data");

                for (int i = 0; i < dataArray.length(); i++) {

                    Matakuliah spinnerModel = new Matakuliah();
                    JSONObject dataobj = dataArray.getJSONObject(i);


                    spinnerModel.setId_mtk(dataobj.getString("id_mtk"));
                    spinnerModel.setNama_mtk(dataobj.getString("nama_mtk"));
                    spinnerModel.setSks_mtk(dataobj.getString("sks_mtk"));
                    matakuliahs.add(spinnerModel);

                }

                for (int i = 0; i < matakuliahs.size(); i++){
                    MtkId.add(matakuliahs.get(i).getId_mtk());
                    MtkNama.add(matakuliahs.get(i).getNama_mtk().toString());
                    MtkSks.add(matakuliahs.get(i).getSks_mtk().toString());
                }

                ArrayAdapter<String> spinnerArrayAdapter = new ArrayAdapter<String>(Tambah_KuliahPengganti.this, simple_spinner_item, MtkNama);
                spinnerArrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item); // The drop down view
                spinner_mtk.setAdapter(spinnerArrayAdapter);

            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

    }

    private void spinDosen(String response){

        try {

            JSONObject obj = new JSONObject(response);
            if(obj.optString("error").equals("false")){

                dosen = new ArrayList<>();
                JSONArray dataArray  = obj.getJSONArray("data");

                for (int i = 0; i < dataArray.length(); i++) {

                    Matakuliah spinnerModel = new Matakuliah();
                    JSONObject dataobj = dataArray.getJSONObject(i);


                    spinnerModel.setId_dosen(dataobj.getString("id_user"));
                    spinnerModel.setNama_dosen(dataobj.getString("nama"));
                    dosen.add(spinnerModel);

                }

                for (int i = 0; i < dosen.size(); i++){
                    DosenId.add(dosen.get(i).getId_dosen());
                    DosenNama.add(dosen.get(i).getNama_dosen().toString());
                }

                ArrayAdapter<String> spinnerArrayAdapter = new ArrayAdapter<String>(Tambah_KuliahPengganti.this, simple_spinner_item, DosenNama);
                spinnerArrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item); // The drop down view
                spinner_dosen.setAdapter(spinnerArrayAdapter);

            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

    }

    private void spinKelompok(String response){

        try {

            JSONObject obj = new JSONObject(response);
            if(obj.optString("error").equals("false")){

                kelompok = new ArrayList<>();
                JSONArray dataArray  = obj.getJSONArray("data");

                for (int i = 0; i < dataArray.length(); i++) {

                    Matakuliah spinnerModel = new Matakuliah();
                    JSONObject dataobj = dataArray.getJSONObject(i);


                    spinnerModel.setKelompok(dataobj.getString("kelompok"));
                    kelompok.add(spinnerModel);

                }

                for (int i = 0; i < kelompok.size(); i++){
                    KelompokNama.add(kelompok.get(i).getKelompok());
                }

                ArrayAdapter<String> spinnerArrayAdapter = new ArrayAdapter<String>(Tambah_KuliahPengganti.this, simple_spinner_item, KelompokNama);
                spinnerArrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item); // The drop down view
                spinner_kelompok.setAdapter(spinnerArrayAdapter);

            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

    }

    private void spinLab(String response){

        try {

            JSONObject obj = new JSONObject(response);
            if(obj.optString("error").equals("false")){

                labs = new ArrayList<>();
                JSONArray dataArray  = obj.getJSONArray("data");

                for (int i = 0; i < dataArray.length(); i++) {

                    Lab spinnerModel = new Lab();
                    JSONObject dataobj = dataArray.getJSONObject(i);


                    spinnerModel.setId_lab(dataobj.getString("id_lab"));
                    spinnerModel.setNama_lab(dataobj.getString("nama_lab"));
                    labs.add(spinnerModel);

                }

                for (int i = 0; i < labs.size(); i++){
                    LabId.add(labs.get(i).getId_lab());
                    LabNama.add(labs.get(i).getNama_lab().toString());
                }

                ArrayAdapter<String> spinnerArrayAdapter = new ArrayAdapter<String>(Tambah_KuliahPengganti.this, simple_spinner_item, LabNama);
                spinnerArrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item); // The drop down view
                spinner_lab.setAdapter(spinnerArrayAdapter);

            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

    }

    private void spinJam(String sks){
        int sks2 = Integer.parseInt(sks);

        if (sks2 == 2){
            final ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_dropdown_item,Item);
            spinner_jam.setAdapter(adapter);

            spinner_jam.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
                @Override
                public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                    //id_spinner = parent.getItemAtPosition(position).toString();
                    jam_ajarstr = adapter.getItem(position);

                }

                @Override
                public void onNothingSelected(AdapterView<?> parent) {

                }
            });
        }
        else {
            final ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_dropdown_item,Item2);
            spinner_jam.setAdapter(adapter);

            spinner_jam.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
                @Override
                public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                    //id_spinner = parent.getItemAtPosition(position).toString();
                    jam_ajarstr = adapter.getItem(position);

                }

                @Override
                public void onNothingSelected(AdapterView<?> parent) {

                }
            });
        }
    }

    void tambahKp(){

        User user = PrefUtil.getUser(this, PrefUtil.USER_SESSION);
        String token = user.getData().getToken();

        Api api = Config.getClient().create(Api.class);
        Call<BaseResponse> update= api.tambahkp("Bearer "+token,id_mtk,id_dosen,kelompokstr,ruang_lab,tanngal,
            jam_ajarstr);

        update.enqueue(new Callback<BaseResponse>() {
            @Override
            public void onResponse(Call<BaseResponse> call, Response<BaseResponse> response) {


                if (response.body().isSuccess()){
                    Toast.makeText(Tambah_KuliahPengganti.this,response.body().getMessage(),Toast.LENGTH_SHORT).show();
                    Intent intent = new Intent(Tambah_KuliahPengganti.this, Menu.class);
                    startActivity(intent);
                    finish();
                }
                else {
                    Toast.makeText(Tambah_KuliahPengganti.this,response.body().getMessage(),Toast.LENGTH_SHORT).show();
                }


            }

            @Override
            public void onFailure(Call<BaseResponse> call, Throwable t) {

                Log.d("Retro", "OnFailure");

            }
        });

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
}
