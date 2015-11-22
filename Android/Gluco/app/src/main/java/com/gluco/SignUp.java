package com.gluco;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.gluco.Controller.AppController;
import com.gluco.modul.Constanta;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;


public class SignUp extends Activity {
    EditText txtUser, txtEmail, txtPass, txtCPass;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);

        txtUser = (EditText) findViewById(R.id.txtUser);
        txtEmail = (EditText) findViewById(R.id.txtEmail);
        txtPass = (EditText) findViewById(R.id.txtPass);
        txtCPass = (EditText) findViewById(R.id.txtCPass);


    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_sign_up, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    public void save(View v) {
        final String user, email, pass, cpass;
        int cek;
        user = txtUser.getText().toString();
        email = txtEmail.getText().toString();
        pass = txtPass.getText().toString();
        cpass = txtCPass.getText().toString();

        if (user.isEmpty() || user == "") {
            cek = 0;
            Toast.makeText(this, "Username harus diisi!.", Toast.LENGTH_LONG).show();
        } else {
            cek = 1;
        }

        if (email.isEmpty() || email == "") {
            cek = 0;
            Toast.makeText(this, "Email harus diisi!.", Toast.LENGTH_LONG).show();
        } else {
            cek = 1;
        }

        if (pass.isEmpty() || pass == "") {
            cek = 0;
            Toast.makeText(this, "Password harus diisi!.", Toast.LENGTH_LONG).show();
        } else {
            cek = 1;
        }

        if (cpass.isEmpty() || cpass == "") {
            cek = 0;
            Toast.makeText(this, "Confirm Password harus diisi!.", Toast.LENGTH_LONG).show();
        } else {
            cek = 1;
        }

        if (cek == 1) {
            if (pass == cpass) {
                final String TAG = "MAIN";
                // Tag used to cancel the request
                final String tag_json_obj = "json_obj_req";

                String url = "http://eng.unhas.ac.id/ikas2/api/register.php";

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
                                        String successMsg = jObj.getString("msg");
                                        pDialog.hide();
                                        Toast.makeText(getApplicationContext(),
                                                successMsg, Toast.LENGTH_LONG).show();
                                        Intent intent = new Intent(SignUp.this, SignUpNext.class);
                                        startActivity(intent);
                                        finish();
                                    } else {
                                        String errorMsg = jObj.getString("error_msg");
                                        pDialog.hide();
                                        Toast.makeText(getApplicationContext(),
                                                errorMsg, Toast.LENGTH_LONG).show();

                                    }
                                } catch (JSONException e) {
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
                        params.put("reg", "reg");
                        params.put("user", user);
                        params.put("email", email);
                        params.put("pass", pass);

                        return params;
                    }

                };

                AppController.getInstance().addToRequestQueue(jsonObjReq, tag_json_obj);
            }
        }else{
            Toast.makeText(this, "Password tidak sama!.", Toast.LENGTH_LONG).show();
        }
    }
}
