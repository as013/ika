package com.gluco.View;


import android.app.ProgressDialog;
import android.os.Bundle;
import android.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.Toast;
import com.gluco.modul.Constanta;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.gluco.Controller.AppController;
import com.gluco.R;
import com.gluco.modul.Constanta;
import com.gluco.modul.DataRekam;
import com.gluco.modul.RekamAdapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;


/**
 * A simple {@link Fragment} subclass.
 */
public class MyHistori extends Fragment {

    private RekamAdapter mAdapter;

    public MyHistori() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_my_histori, container, false);
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);

        mAdapter = new RekamAdapter(getActivity());

        ListView listView = (ListView) getView().findViewById(R.id.listView);
        listView.setAdapter(mAdapter);

        ambil_data();
    }

    private void ambil_data() {
        final String TAG="MAIN";
        // Tag used to cancel the request
        final String tag_json_obj = "json_obj_req";

        String url = "http://eng.unhas.ac.id/ikas2/api/rekam.php?idu="+Constanta.ID_USER;

        JsonObjectRequest jsonObjReq = new JsonObjectRequest(url,null,
                new Response.Listener<JSONObject>() {

                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            List<DataRekam> imageRecords = parse(response);
                            mAdapter.swapRekamRecords(imageRecords);
                            /*
                            JSONObject jObj = new JSONObject(response);
                            boolean error = jObj.getBoolean("error");

                            if (!error) {
                                JSONArray data = jObj.getJSONArray("hasil");
                                for(int i=0; i<data.length(); i++){
                                    JSONObject rekam = data.getJSONObject(i);
                                }
                                pDialog.hide();

                            }else{
                                String errorMsg = jObj.getString("error_msg");
                                Toast.makeText(getActivity().getApplicationContext(),
                                        errorMsg, Toast.LENGTH_LONG).show();
                                pDialog.hide();
                            }*/
                        }catch (JSONException e){
                            e.printStackTrace();
                        }
                        //Log.d(TAG, response.toString());

                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                Log.d(TAG, "Error: " + error.getMessage());
            }
        });/* {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("rekam", "rekam");
                params.put("id", Constanta.ID_USER);

                return params;
            }

        };*/

        AppController.getInstance().addToRequestQueue(jsonObjReq, tag_json_obj);
    }

    private List<DataRekam> parse(JSONObject json) throws JSONException {
        ArrayList<DataRekam> records = new ArrayList<DataRekam>();

        JSONArray data = json.getJSONArray("hasil");
        int no = 0;
        for(int i =0; i < data.length(); i++) {
            no++;
            JSONObject hasil = data.getJSONObject(i);
            String nomor = String.valueOf(no);
            String hglu = "Glukosa : " + hasil.getString("hasil");
            String tgl = "Tgl : " + hasil.getString("tanggal");
            String jam = "Jam : " + hasil.getString("jam");

            DataRekam record = new DataRekam();
            record.setNo(nomor);
            record.setHasil(hglu);
            record.setTanggal(tgl);
            record.setJam(jam);


            records.add(record);
        }

        return records;
    }
}
