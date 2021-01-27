package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.text.format.DateFormat;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.model.BaseResponse;
import com.skripsi.penjadwalan.model.Lab;
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

public class Tambah_Pinjam_Lab extends AppCompatActivity {

    private ArrayList<Lab> labs;
    private android.widget.Spinner spinner,spinnerJamMulai,spinnerJamSelesai;
    private List<String> LabId = new ArrayList<String>();//add ids in this list
    private ArrayList<String> LabNama = new ArrayList<String>();

    String id_spinner,jam_mulai_str,jam_selesai_str,tanngal,no_hp;

    private ImageView tgl_pinjam;
    private String[] Item = {"07:00","08:00","09:00","10:00", "11:00","12:00","13:00","14:00","15.00"};
    private String[] Item2 = {"10:00", "11:00","12:00","13:00","14:00","15.00"};

    Calendar myCalendar;
    String bulan_ar[] = {"Januari", "Februari", "Maret","April", "Mei", "Juni","Juli","Agustus", "Oktober","September", "November","Desember"};
    TextView txt_tgl;
    Button tambah;
    EditText nama,judul,keterangan,email,nohp;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tambah__pinjam__lab);

        spinner = findViewById(R.id.spn_lab);
        spinnerJamMulai = findViewById(R.id.spn_jamMulai);
        spinnerJamSelesai = findViewById(R.id.spn_jamSelesai);
        tgl_pinjam = findViewById(R.id.img_tgl_pinjam);
        txt_tgl = findViewById(R.id.txt_tgl_pinjam);
        tambah = findViewById(R.id.btn_tambah);
        nama = findViewById(R.id.txt_nama_pinjam);
        judul = findViewById(R.id.txt_judul_pinjam);
        keterangan = findViewById(R.id.txt_keterangan_pinjam);
        email = findViewById(R.id.txt_email_pinjam);
        nohp = findViewById(R.id.txt_no_hp_pinjam);



        final ArrayAdapter<String> adapter = new ArrayAdapter<>(this,
            android.R.layout.simple_spinner_dropdown_item,Item);
        final ArrayAdapter<String> adapter2 = new ArrayAdapter<>(this,
            android.R.layout.simple_spinner_dropdown_item,Item2);
        spinnerJamMulai.setAdapter(adapter);
        spinnerJamSelesai.setAdapter(adapter2);


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

        fetchJSON();

        spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //id_spinner = parent.getItemAtPosition(position).toString();
                id_spinner = LabId.get(position);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        spinnerJamMulai.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //id_spinner = parent.getItemAtPosition(position).toString();
                jam_mulai_str = adapter.getItem(position);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        spinnerJamSelesai.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //id_spinner = parent.getItemAtPosition(position).toString();
                jam_selesai_str = adapter2.getItem(position);
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        tgl_pinjam.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                DatePickerDialog datePickerDialog = new DatePickerDialog(Tambah_Pinjam_Lab.this, new DatePickerDialog.OnDateSetListener() {
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
                tambahPeminjaman();
            }
        });
    }

    void tambahPeminjaman(){
        String namastr = nama.getText().toString();
        String judulstr = judul.getText().toString();
        String keteranganstr = keterangan.getText().toString();
        String emailstr = email.getText().toString();
        String tanggalstr = tanngal;
        String jam_mulaistr = jam_mulai_str;
        String jam_selesaistr = jam_selesai_str;
        String labstr = id_spinner;
        no_hp = nohp.getText().toString();

        User user = PrefUtil.getUser(this, PrefUtil.USER_SESSION);
        String token = user.getData().getToken();
        String id_user = String.valueOf(user.getData().getId_user());

        Api api = Config.getClient().create(Api.class);
        Call<BaseResponse> update= api.tambah("Bearer "+token,namastr,judulstr,keteranganstr,tanggalstr,jam_mulaistr,
            jam_selesaistr,labstr,emailstr,no_hp,id_user);

        update.enqueue(new Callback<BaseResponse>() {
            @Override
            public void onResponse(Call<BaseResponse> call, Response<BaseResponse> response) {


                if (response.body().isSuccess()){
                    Toast.makeText(Tambah_Pinjam_Lab.this,response.body().getMessage(),Toast.LENGTH_SHORT).show();
                    Intent intent = new Intent(Tambah_Pinjam_Lab.this, Menu.class);
                    startActivity(intent);
                    finish();
                }
                else {
                    Toast.makeText(Tambah_Pinjam_Lab.this,response.body().getMessage(),Toast.LENGTH_SHORT).show();
                }

            }

            @Override
            public void onFailure(Call<BaseResponse> call, Throwable t) {

                Log.d("Retro", "OnFailure");

            }
        });

    }

    private void fetchJSON(){

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
                        spinJSON(jsonresponse);

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

    private void spinJSON(String response){

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

                ArrayAdapter<String> spinnerArrayAdapter = new ArrayAdapter<String>(Tambah_Pinjam_Lab.this, simple_spinner_item, LabNama);
                spinnerArrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item); // The drop down view
                spinner.setAdapter(spinnerArrayAdapter);

            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

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
