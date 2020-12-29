package com.skripsi.penjadwalan.fragment.view_model;

import android.util.Log;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.skripsi.penjadwalan.model.Jadwal;
import com.skripsi.penjadwalan.model.Pengganti;
import com.skripsi.penjadwalan.network.config.Config;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;

public class PenggantiViewModel extends ViewModel {
    private static MutableLiveData<ArrayList<Pengganti>> listPengganti = new MutableLiveData<>();

    public void setPengganti(String token) {
        AsyncHttpClient client = new AsyncHttpClient();
        final ArrayList<Pengganti> listItems = new ArrayList<>();
        client.addHeader("Authorization", "Bearer " + token);
        String url = Config.BASE_URL + "jadwal/jam-sekarang";

        client.get(url, new AsyncHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, byte[] responseBody) {
                try {
                    String result = new String(responseBody);

                    JSONObject responseObject = new JSONObject(result);
                    JSONArray list = responseObject.getJSONArray("datapengganti");

                    for (int i = 0; i < list.length(); i++) {
                        JSONObject user = list.getJSONObject(i);
                        Pengganti items = new Pengganti();
                        items.setKelompok(user.getString("kelompok"));
                        items.setNama_matkul(user.getString("nama_mtk"));
                        items.setNama_dosen(user.getString("nama"));
                        items.setJam(user.getString("jam_pengganti"));
                        items.setLab(user.getString("nama_lab"));

                        listItems.add(items);
                    }
                    listPengganti.postValue(listItems);
                } catch (Exception e) {
                    Log.d("Exception", e.getMessage());
                }
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, byte[] responseBody, Throwable error) {
                Log.d("onFailure", error.getMessage());
                Log.d("Failed", ""+statusCode);
                Log.d("Error", ""+error);
            }
        });
    }

    public LiveData<ArrayList<Pengganti>> getPengganti() {
        return listPengganti;
    }

}
