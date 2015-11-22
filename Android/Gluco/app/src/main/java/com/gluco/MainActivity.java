package com.gluco;

import android.app.Fragment;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.PorterDuff;
import android.graphics.PorterDuffXfermode;
import android.graphics.Rect;
import android.graphics.RectF;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.support.v7.app.ActionBarDrawerToggle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.StringRequest;
import com.gluco.Controller.AppController;
import com.gluco.View.About;
import com.gluco.View.Home;
import com.gluco.View.Kontak;
import com.gluco.View.MyHistori;
import com.gluco.View.Pengukuran;
import com.gluco.modul.Constanta;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;


public class MainActivity extends ActionBarActivity{

    Fragment fragment;
    private DrawerLayout drawerLayout;
    private ListView listView;

    TextView txtNMUser, txtEmailUser;

    private ActionBarDrawerToggle drawerListener;
    private MyAdapter myAdapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        fragment = new Home();
        this.getFragmentManager().beginTransaction().replace(R.id.mainContent, fragment).commit();



        //Bitmap bm = BitmapFactory.decodeResource(getResources(),
        //        R.drawable.capture);

        listView = (ListView) findViewById(R.id.drawerList);
        myAdapter = new MyAdapter(this);
        listView.setAdapter(myAdapter);

        drawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawerListener = new ActionBarDrawerToggle(this, drawerLayout,
                R.string.drawer_open, R.string.drawer_close){
            @Override
            public void onDrawerClosed(View drawerView) {
                //Toast.makeText(MainActivity.this, "Drawer Close", Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onDrawerOpened(View drawerView) {
                //Toast.makeText(MainActivity.this, "Drawer Open", Toast.LENGTH_SHORT).show();
            }
        };
        drawerLayout.setDrawerListener(drawerListener);

        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                displayFragment(position);
                listView.setItemChecked(position, true);
                drawerLayout.closeDrawers();
            }
        });

        final ImageView mImage = (ImageView) findViewById(R.id.imageView6);
        //mImage.setImageBitmap(getCircleBitmap(bm));

        txtNMUser = (TextView) findViewById(R.id.txtNMuser);
        txtEmailUser = (TextView) findViewById(R.id.txtEmailUser);

        txtNMUser.setText(Constanta.NAMA);
        txtEmailUser.setText(Constanta.EMAIL);

        ImageLoader imageLoader = AppController.getInstance().getImageLoader();

        // If you are using normal ImageView
        imageLoader.get(Constanta.URL_IMAGE, new ImageLoader.ImageListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                //Log.e(TAG, "Image Load Error: " + error.getMessage());
            }

            @Override
            public void onResponse(ImageLoader.ImageContainer response, boolean arg1) {
                if (response.getBitmap() != null) {
                    // load image into imageview

                    mImage.setImageBitmap(getCircleBitmap(response.getBitmap()));
                }
            }
        });
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if(drawerListener.onOptionsItemSelected(item)){
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
        drawerListener.onConfigurationChanged(newConfig);
    }

    @Override
    public void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        drawerListener.syncState();
    }
    /*
        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
            setTitle(""+position);
        }
    */
    public void selectItem(int position) {
        listView.setItemChecked(position, true);

    }

    public void setTitle(String title){
        getSupportActionBar().setTitle(title);
    }

    private void displayFragment(int i){
        switch (i){
            case 0:
                fragment = new Home();
                break;
            case 1:
                fragment = new Pengukuran();
                break;
           // case 2:
            //    fragment = new Kontak();
            //    break;
            case 2:
                fragment = new MyHistori();
                break;
            case 3:
                //fragment = new About();
                Intent intent = new Intent(this,Login.class);
                startActivity(intent);
                finish();
                break;
            default:
                break;
        }

        if(fragment != null){
            this.getFragmentManager().beginTransaction().replace(R.id.mainContent, fragment).commit();
        }
    }

    public void changeFrag(Fragment fragment){
        this.getFragmentManager().beginTransaction().replace(R.id.mainContent, fragment).commit();
    }

    @Override
    public void onBackPressed() {

    }

    private Bitmap getCircleBitmap(Bitmap bitmap) {
        final Bitmap output = Bitmap.createBitmap(bitmap.getWidth(),
                bitmap.getHeight(), Bitmap.Config.ARGB_8888);
        final Canvas canvas = new Canvas(output);

        final int color = Color.RED;
        final Paint paint = new Paint();
        final Rect rect = new Rect(0, 0, bitmap.getWidth(), bitmap.getHeight());
        final RectF rectF = new RectF(rect);

        paint.setAntiAlias(true);
        canvas.drawARGB(0, 0, 0, 0);
        paint.setColor(color);
        canvas.drawOval(rectF, paint);

        paint.setXfermode(new PorterDuffXfermode(PorterDuff.Mode.SRC_IN));
        canvas.drawBitmap(bitmap, rect, rect, paint);

        bitmap.recycle();

        return output;
    }


}


class MyAdapter extends BaseAdapter {

    private Context context;
    String[] menu;
    int[] icn = {R.drawable.home,
            R.drawable.ukur,
            R.drawable.about,
           // R.drawable.about,
            R.drawable.logout};

    public MyAdapter(Context context){
        this.context = context;
        menu = context.getResources().getStringArray(R.array.menu);
    }
    @Override
    public int getCount() {
        return menu.length;
    }

    @Override
    public Object getItem(int position) {
        return menu[position];
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        View row;
        if(convertView == null){
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            row = inflater.inflate(R.layout.custom_row, null);
        }else{
            row = convertView;
        }

        TextView txtMenu = (TextView) row.findViewById(R.id.textView3);
        ImageView iconQ = (ImageView) row.findViewById(R.id.imageView);

        txtMenu.setText(menu[position]);
        iconQ.setImageResource(icn[position]);
        return row;
    }
}