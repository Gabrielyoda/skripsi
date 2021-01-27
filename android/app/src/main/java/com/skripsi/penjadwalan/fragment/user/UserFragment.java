package com.skripsi.penjadwalan.fragment.user;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProvider;

import com.skripsi.penjadwalan.R;
import com.skripsi.penjadwalan.activity.Login;
import com.skripsi.penjadwalan.activity.MainActivity;
import com.skripsi.penjadwalan.model.User;
import com.skripsi.penjadwalan.util.PrefUtil;

import org.w3c.dom.Text;

public class UserFragment extends Fragment {

    private UserViewModel notificationsViewModel;
    TextView nama,no_hp,email,jabatan;

    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        notificationsViewModel = new ViewModelProvider(this).get(UserViewModel.class);
        View root = inflater.inflate(R.layout.fragment_user, container, false);
        final Button btn_logout = root.findViewById(R.id.btn_sign_out);
        nama = root.findViewById(R.id.txt_nama);
        no_hp = root.findViewById(R.id.txt_no_hp);
        email = root.findViewById(R.id.txt_email);
        jabatan = root.findViewById(R.id.txt_jabatan);

        User user = PrefUtil.getUser(getActivity(), PrefUtil.USER_SESSION);
        String namastr = user.getData().getNama();
        String no_hpstr = user.getData().getTelepon();
        String emailstr = user.getData().getEmail();
        String jabatanstr = user.getData().getJabatan();

        nama.setText(namastr);
        no_hp.setText(no_hpstr);
        email.setText(emailstr);
        jabatan.setText(jabatanstr);


       // final TextView textView = root.findViewById(R.id.text_notifications);
//        notificationsViewModel.getText().observe(getViewLifecycleOwner(), new Observer<String>() {
//            @Override
//            public void onChanged(@Nullable String s) {
//                textView.setText(s);
//            }
//        });

        btn_logout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                logoutAct();
                Intent intent = new Intent(getActivity(), Login.class);
                startActivity(intent);
                getActivity().finish();
            }
        });
        return root;
    }

    void logoutAct() {
        PrefUtil.clear(getActivity());
    }
}
