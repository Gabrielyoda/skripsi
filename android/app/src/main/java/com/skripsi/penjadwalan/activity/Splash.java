package com.skripsi.penjadwalan.activity;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;

import com.skripsi.penjadwalan.R;

public class Splash extends AppCompatActivity {
    Animation splash;
    ImageView app_logo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);

        splash = AnimationUtils.loadAnimation(this, R.anim.splash);

        app_logo = findViewById(R.id.app_logo);
        app_logo.startAnimation(splash);

        Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                Intent intent = new Intent(Splash.this, Login.class);
                startActivity(intent);
                finish();

            }
        }, 2000);
    }
}
