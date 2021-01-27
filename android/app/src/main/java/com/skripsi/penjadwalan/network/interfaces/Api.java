package com.skripsi.penjadwalan.network.interfaces;

import com.skripsi.penjadwalan.model.BaseResponse;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.network.config.Config;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.Headers;
import retrofit2.http.POST;
import retrofit2.http.Query;
import retrofit2.http.QueryMap;

public interface Api {

    @GET("jadwal/lab")
    Call<String> getJSONString();

    @GET("jadwal/matkul")
    Call<String> getMatakuliah();

    @GET("jadwal/matkuldosen")
    Call<String> getMatakuliahDosen(
        @Query("iddosen") String iddosen
    );

    @GET("jadwal/dosen")
    Call<String> getDosen(
        @Query("idmtk") String idmtk
    );

    @GET("jadwal/kelompok")
    Call<String> getkelompok(
        @Query("idmtk") String idmtk,
        @Query("iddosen") String iddosen
    );

    @FormUrlEncoded
    @POST(Config.BASE_URL + "login")
    Call<User> login(
        @Field("email") String email,
        @Field("password") String password);

    @GET("jadwal/kelompok")
    Call<String> getpeminjamanlab(
        @Header("Authorization") String auth,
        @Query("id_user") String id_user
    );

    @FormUrlEncoded
    @POST( Config.BASE_URL +"pinjam/tambah")
    Call<BaseResponse> tambah(
        @Header("Authorization") String auth,
        @Field ("nama") String nama,
        @Field("judul") String judul,
        @Field("keterangan") String keterangan,
        @Field("tanggal") String tanggal,
        @Field("jamMulai") String jamMulai,
        @Field("jamSelesai") String jamSelesai,
        @Field("lab") String lab,
        @Field("email") String email,
        @Field("nohp") String nohp,
        @Field("id_user") String id_user

    );

    @FormUrlEncoded
    @POST( Config.BASE_URL +"jadwal/tambahkp")
    Call<BaseResponse> tambahkp(
        @Header("Authorization") String auth,
        @Field ("id_matkul") String id_matkul,
        @Field("id_dosen") String id_dosen,
        @Field("kelompok") String kelompok,
        @Field("lab") String lab,
        @Field("tanggal") String tanggal,
        @Field("jam_ajar") String jam_ajar
    );
}
