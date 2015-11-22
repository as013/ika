package com.gluco.modul;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.gluco.R;

import java.util.List;

/**
 * Created by User on 11/2/2015.
 */
public class RekamAdapter extends ArrayAdapter<DataRekam> {

    public RekamAdapter(Context context) {
        super(context, R.layout.rekam_list);

        //mImageLoader = new ImageLoader(VolleyApplication.getInstance().getRequestQueue(), new BitmapLruCache());
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if(convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(R.layout.rekam_list, parent, false);
        }
        TextView txtNo = (TextView) convertView.findViewById(R.id.txtNo);
        TextView txtHasil = (TextView) convertView.findViewById(R.id.txtHasil);
        TextView txtTgl = (TextView) convertView.findViewById(R.id.txtTgl);
        TextView txtJam = (TextView) convertView.findViewById(R.id.txtJam);

        DataRekam dataRekam = getItem(position);

        txtNo.setText(dataRekam.getNo());
        txtHasil.setText(dataRekam.getHasil());
        txtTgl.setText(dataRekam.getTanggal());
        txtJam.setText(dataRekam.getJam());

        return convertView;
    }

    public void swapRekamRecords(List<DataRekam> objects) {
        clear();

        for(DataRekam object : objects) {
            add(object);
        }

        notifyDataSetChanged();
    }
}
