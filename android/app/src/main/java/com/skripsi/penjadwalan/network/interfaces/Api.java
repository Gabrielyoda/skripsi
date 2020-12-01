package com.skripsi.penjadwalan.network.interfaces;

import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.network.config.Config;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.POST;

public interface Api {
    @FormUrlEncoded
    @POST(Config.BASE_URL + "login")
    Call<User> login(
        @Field("nim") String username,
        @Field("password") String password);
}
