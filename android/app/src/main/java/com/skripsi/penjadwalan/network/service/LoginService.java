package com.skripsi.penjadwalan.network.service;

import android.content.Context;

import com.skripsi.penjadwalan.network.config.RetrofitBuilder;
import com.skripsi.penjadwalan.network.interfaces.Api;

import retrofit2.Callback;

public class LoginService {
    private Api loginInterface;


    public LoginService(Context context) {
        loginInterface = RetrofitBuilder.builder(context)
            .create(Api.class);
    }

    public void doLogin(String username, String password, Callback callback) {
        loginInterface.login(username, password).enqueue(callback);
    }
}
