package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.app.ProgressDialog;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.adapter.PeminjamanAdapter;
import com.skripsi.penjadwalan.model.Peminjaman;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.network.config.Config;
import com.skripsi.penjadwalan.util.PrefUtil;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class Peminjaman_Lab extends AppCompatActivity {
    ProgressDialog pd;
    ArrayList<Peminjaman> dataPeminjaman;
    private PeminjamanAdapter adapterPeminjaman;
    private RecyclerView mRecycler_Peminjaman;
    LinearLayoutManager HorizontalLayout;

    RecyclerView.LayoutManager RecyclerViewLayoutManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_peminjaman__lab);

        DataPeminjaman();
    }

    private void DataPeminjaman(){
        User user = PrefUtil.getUser(this, PrefUtil.USER_SESSION);
        final String token = user.getData().getToken();
        int id = user.getData().getId_user();


        pd = new ProgressDialog(this);
        pd.setMessage("Loading ...");
        pd.setCancelable(false);
        pd.show();
        StringRequest stringRequest = new StringRequest(Request.Method.GET, Config.BASE_URL +"pinjam/lihat?id_user=" + id,
            new com.android.volley.Response.Listener<String>() {
                @Override
                public void onResponse(String response) {

                    Log.d("strrrrr", ">>" + response);

                    try {

                        pd.hide();

                        JSONObject obj = new JSONObject(response);
                        if(obj.optString("success").equals("true")){

                            dataPeminjaman = new ArrayList<>();
                            JSONArray dataArray  = obj.getJSONArray("data");

                            for (int i = 0; i < dataArray.length(); i++) {

                                Peminjaman pinjam= new Peminjaman();
                                JSONObject dataobj = dataArray.getJSONObject(i);

                                pinjam.setId_peminjaman(dataobj.getString("id_pinjam"));
                                pinjam.setNama(dataobj.getString("nama_pinjam"));
                                pinjam.setJudul(dataobj.getString("judul_pinjam"));
                                pinjam.setJam(dataobj.getString("jam_pinjam"));
                                pinjam.setLab(dataobj.getString("nama_lab"));
                                pinjam.setEmail(dataobj.getString("email_pinjam"));
                                pinjam.setKeterangan(dataobj.getString("keterangan_pinjam"));

                                dataPeminjaman.add(pinjam);

                            }
                            setupRecyclerCategory();
//                                mAdapter.notifyDataSetChanged();
                        }

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            },
            new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //displaying the error in toast if occurrs
                    Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }){
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("Authorization", "Bearer "+token);
                return params;
            }
        };

        // request queue
        RequestQueue requestQueue = Volley.newRequestQueue(this);

        requestQueue.add(stringRequest);

    }

    private void setupRecyclerCategory(){
        adapterPeminjaman = new PeminjamanAdapter(this,dataPeminjaman);
        mRecycler_Peminjaman = (RecyclerView) findViewById(R.id.recyclerPeminjaman);

        mRecycler_Peminjaman.setAdapter(adapterPeminjaman);
        RecyclerViewLayoutManager = new LinearLayoutManager(getApplicationContext());
        mRecycler_Peminjaman.setLayoutManager(RecyclerViewLayoutManager);
        HorizontalLayout = new LinearLayoutManager(Peminjaman_Lab.this, LinearLayoutManager.VERTICAL, false);
        mRecycler_Peminjaman.setLayoutManager(HorizontalLayout);


    }
}
