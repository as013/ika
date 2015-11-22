package com.gluco;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Request.Method;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.gluco.Controller.AppController;
import com.gluco.modul.Constanta;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;


public class Login extends Activity {
    private static final String TAG = SignUp.class.getSimpleName();
    public static String idUsr;
    private EditText user,pass;
    String usr,pas;
    private ProgressDialog pDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        user = (EditText) findViewById(R.id.txtUser);
        pass = (EditText) findViewById(R.id.txtPass);

        pDialog = new ProgressDialog(this);
        pDialog.setCancelable(false);

    }

    public void loginProses(View v){
        usr = user.getText().toString();
        pas = pass.getText().toString();

        if(usr != "" && pas != "") {
            cekLogin(usr, pas);
            //Toast.makeText(getApplicationContext(),
            //        "Error"+usr+" : "+pas, Toast.LENGTH_LONG).show();
        }else{
            Toast.makeText(getApplicationContext(),
                    "Error1", Toast.LENGTH_LONG).show();
        }

    }

    public void cekLogin(final String user, final String pass) {
        final String TAG="MAIN";
        // Tag used to cancel the request
        final String tag_json_obj = "json_obj_req";

        String url = "http://eng.unhas.ac.id/ikas2/api/signin.php";

        final ProgressDialog pDialog = new ProgressDialog(this);
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
                                idUsr = jObj.getString("uid");
                                Constanta.ID_USER = jObj.getString("uid");
                                Constanta.NAMA = jObj.getString("nama");
                                Constanta.EMAIL = jObj.getString("email");
                                Constanta.URL_IMAGE = jObj.getString("foto");
                                pDialog.hide();
                                Intent intent = new Intent(Login.this, MainActivity.class);
                                startActivity(intent);
                                finish();
                            }else{
                                String errorMsg = jObj.getString("error_msg");
                                Toast.makeText(getApplicationContext(),
                                        errorMsg, Toast.LENGTH_LONG).show();
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
                params.put("tag", "login");
                params.put("user", user);
                params.put("pass", pass);

                return params;
            }

        };

        AppController.getInstance().addToRequestQueue(jsonObjReq,tag_json_obj);

    }

    public void signupProses(View v){
        Intent intent = new Intent(this, SignUp.class);
        startActivity(intent);
        finish();
    }

    private void showDialog() {
        if (!pDialog.isShowing())
            pDialog.show();
    }

    private void hideDialog() {
        if (pDialog.isShowing())
            pDialog.dismiss();
    }

    @Override
    public void onBackPressed() {

    }
}
