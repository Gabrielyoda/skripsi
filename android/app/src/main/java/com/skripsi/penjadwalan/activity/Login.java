package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.network.service.LoginService;
import com.skripsi.penjadwalan.util.PrefUtil;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class Login extends AppCompatActivity {
    EditText usernameText,passwordText;
    Button btn_login;

    private LoginService loginService;

    public static void start(Context context) {
        Intent intent = new Intent(context, Login.class);
        context.startActivity(intent);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        usernameText = findViewById(R.id.username_user);
        passwordText = findViewById(R.id.password_user);
        btn_login = findViewById(R.id.btn_log_in);

        if(isSessionLogin()) {
            MainActivity.start(this);
            Login.this.finish();
        }

        btn_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loginAct();
            }
        });
    }

    void loginAct() {
        btn_login.setEnabled(false);
        btn_login.setText("Loading...");
        String username = usernameText.getText().toString().trim();
        String password = passwordText.getText().toString();

        if(TextUtils.isEmpty(username)) {
            btn_login.setEnabled(true);
            btn_login.setText("Log In");
            usernameText.setError("Email Tidak Boleh Kosong");
            return;
        }

//        if(Patterns.EMAIL_ADDRESS.matcher(email).matches()){
//
//        }
//        else{
//            btn_login.setEnabled(true);
//            btn_login.setText("Log In");
//            emailText.setError("Format Email Tidak Sesuai");
//            return;
//        }

        if(TextUtils.isEmpty(password)) {
            btn_login.setEnabled(true);
            btn_login.setText("Log In");
            passwordText.setError("Password Tidak Boleh Kosong");
            return;
        }

        loginService = new LoginService(this);
        loginService.doLogin(username, password, new Callback() {
            @Override
            public void onResponse(Call call, Response response) {
                User user = (User) response.body();

                if(user != null) {
                    if(!user.isError()) {
                        Toast.makeText(Login.this, "Login Berhasil", Toast.LENGTH_SHORT).show();
                        PrefUtil.putUser(Login.this, PrefUtil.USER_SESSION, user);
                        MainActivity.start(Login.this);
                        Login.this.finish();
                    }
                    else {
                        Toast.makeText(Login.this, user.getMessage(), Toast.LENGTH_SHORT).show();
                    }

                    Toast.makeText(Login.this, user.getMessage(), Toast.LENGTH_SHORT).show();
                }
                else{
                    Toast.makeText(Login.this, "Email atau password salah", Toast.LENGTH_SHORT).show();
                    btn_login.setEnabled(true);
                    btn_login.setText("Log In");
                }
            }

            @Override
            public void onFailure(Call call, Throwable t) {
                Toast.makeText(Login.this, "Tidak bisa Mengakses server", Toast.LENGTH_SHORT).show();
                btn_login.setEnabled(true);
                btn_login.setText("Log In");
            }
        });
    }

    boolean isSessionLogin() {
        return PrefUtil.getUser(this, PrefUtil.USER_SESSION) != null;
    }

    @Override
    public void onBackPressed() {
        finish();
    }
}
