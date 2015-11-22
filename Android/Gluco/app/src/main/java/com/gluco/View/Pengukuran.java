package com.gluco.View;


import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.app.Fragment;
import android.os.Handler;
import android.os.Message;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ToggleButton;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.gluco.Controller.AppController;
import com.gluco.MainActivity;
import com.gluco.R;
import com.gluco.modul.Bluetooth;
import com.gluco.modul.Constanta;
import com.jjoe64.graphview.GraphView;
import com.jjoe64.graphview.GridLabelRenderer;
import com.jjoe64.graphview.Viewport;
import com.jjoe64.graphview.series.DataPoint;
import com.jjoe64.graphview.series.LineGraphSeries;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;


/**
 * A simple {@link Fragment} subclass.
 */
public class Pengukuran extends Fragment {

    View v;
    public final String TAG = "Main";
    public String hp;
    TextView txtHasil;
    Button btnKirim;
    double lastX = 0;
    ToggleButton btnSS;
    private Bluetooth bt;
    int a = 0;
    LineGraphSeries<DataPoint> series;
    public Pengukuran() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_pengukuran, container, false);
        return v;
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        txtHasil = (TextView) getActivity().findViewById(R.id.txtHasil);

        btnKirim = (Button) getActivity().findViewById(R.id.btnKirim);

        btnSS = (ToggleButton) getActivity().findViewById(R.id.btnSS);

        bt = new Bluetooth(getActivity(), mHandler);

        btnSS.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btnSSClick();
            }
        });

        btnKirim.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btnKirimClick();
            }
        });

        GraphView graph = (GraphView) getActivity().findViewById(R.id.graph);
        series = new LineGraphSeries<DataPoint>();

        graph.addSeries(series);
        graph.getGridLabelRenderer().setHorizontalLabelsVisible(false);
        graph.getGridLabelRenderer().setVerticalLabelsVisible(false);
        graph.getGridLabelRenderer().setGridStyle(GridLabelRenderer.GridStyle.NONE);
        //series.setTitle("Random Curve 1");
        series.setColor(Color.GREEN);

        Viewport viewport = graph.getViewport();
        viewport.setXAxisBoundsManual(true);
        viewport.setMinX(0);
        viewport.setMaxX(10);
        viewport.setScrollable(true);
    }

    private void btnSSClick() {
        if(btnSS.isChecked()){
            connectService();
            //bt.start();
        }else{
            bt.stop();
        }
    }

    private void btnKirimClick() {
        if (txtHasil.getText().toString() == "0") {

        }else{
            simpanHasil();
        }

    }

    public void connectService(){
        try {
            BluetoothAdapter bluetoothAdapter = BluetoothAdapter.getDefaultAdapter();
            if (bluetoothAdapter.isEnabled()) {
                bt.start();
                bt.connectDevice("HC-05");
                Log.d(TAG, "Btservice started - listening");
            } else {
                Log.w(TAG, "Btservice started - bluetooth is not enabled");
            }
        } catch (Exception e) {
            Log.e(TAG, "Unable to start bt ", e);
        }
    }

    private final Handler mHandler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            byte[] writeBuf = (byte[]) msg.obj;
            int begin = (int)msg.arg1;
            int end = (int)msg.arg2;
            switch (msg.what) {
                case Bluetooth.MESSAGE_STATE_CHANGE:
                    Log.d(TAG, "MESSAGE_STATE_CHANGE: " + msg.arg1);
                    break;
                case Bluetooth.MESSAGE_WRITE:
                    Log.d(TAG, "MESSAGE_WRITE ");
                    break;
                case Bluetooth.MESSAGE_READ:
                    Log.d(TAG, "MESSAGE_READ ");
                    String writeMessage = new String(writeBuf);
                    writeMessage = writeMessage.substring(begin, end);
                    //String[] dtaEp = writeMessage.split(":");
                    //denyut.setText(dtaEp[0].trim());
                    //suhu.setText(dtaEp[1].trim());
                    Log.d(TAG, writeMessage);
                    txtHasil.setText(writeMessage.trim());
                    lastX += 1d;
                    series.appendData(new DataPoint(lastX,Double.valueOf(txtHasil.getText().toString())),true,10);
                    break;
                case Bluetooth.MESSAGE_DEVICE_NAME:
                    Log.d(TAG, "MESSAGE_DEVICE_NAME "+msg);
                    break;
                case Bluetooth.MESSAGE_TOAST:
                    Log.d(TAG, "MESSAGE_TOAST "+msg);
                    break;
            }
        }
    };

    public void simpanHasil(){
        final String TAG="MAIN";
        // Tag used to cancel the request
        final String tag_json_obj = "json_obj_req";

        String url = "http://eng.unhas.ac.id/ikas2/api/save_hasil.php";

        final ProgressDialog pDialog = new ProgressDialog(getActivity());
        pDialog.setMessage("Loading...");
        pDialog.show();

        StringRequest jsonObjReq = new StringRequest(Request.Method.POST,
                url,
                new Response.Listener<String>() {

                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jObj = new JSONObject(response);
                            boolean error = jObj.getBoolean("error");

                            if (!error) {
                                String successMsg = jObj.getString("msg");
                                Toast.makeText(getActivity().getApplicationContext(),
                                        successMsg, Toast.LENGTH_LONG).show();
                                pDialog.hide();

                            }else{
                                String errorMsg = jObj.getString("error_msg");
                                Toast.makeText(getActivity().getApplicationContext(),
                                        errorMsg, Toast.LENGTH_LONG).show();
                                pDialog.hide();
                            }
                        }catch (JSONException e){
                            e.printStackTrace();
                        }
                        //Log.d(TAG, response.toString());

                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                Log.d(TAG, "Error: " + error.getMessage());
                pDialog.hide();
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("hasil", "hasil");
                params.put("id", Constanta.ID_USER);
                params.put("hp", txtHasil.getText().toString());

                return params;
            }

        };

        AppController.getInstance().addToRequestQueue(jsonObjReq,tag_json_obj);
    }

    
}
