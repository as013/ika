package com.gluco.modul;

/**
 * Created by Epenk on 9/12/2015.
 */
import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import java.util.HashMap;

public class SQLiteHandler extends SQLiteOpenHelper {

    private static final String TAG = SQLiteHandler.class.getSimpleName();
    private static final int DATABASE_VERSION = 1;
    private static final String DATABASE_NAME = "okftuho1_login";
    private static final String TABLE_LOGIN = "users";
    private static final String TABLE_HASIL = "hasil";
    private static final String KEY_ID = "id";
    private static final String KEY_NAME = "name";
    private static final String KEY_EMAIL = "email";
    private static final String KEY_UID = "uid";
    private static final String KEY_CREATED_AT = "created_at";
    private static final String KEY_AGE = "age";
    private static final String KEY_GENDER = "gender";
    private static final String KEY_ID_HASIL = "id";
    private static final String KEY_ID_USER = "idUser";
    private static final String KEY_DENYUT = "denyut";
    private static final String KEY_SUHU = "suhu";
    private static final String KEY_TANGGAL = "tanggal";

    public SQLiteHandler(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }
    @Override
    public void onCreate(SQLiteDatabase db) {
        String CREATE_LOGIN_TABLE = "CREATE TABLE " + TABLE_LOGIN + "("
                + KEY_ID + " INTEGER PRIMARY KEY," + KEY_NAME + " TEXT,"
                + KEY_EMAIL + " TEXT UNIQUE," + KEY_UID + " TEXT,"
                + KEY_CREATED_AT + " TEXT,"  + KEY_AGE + " INTEGER,"
                + KEY_GENDER + "TEXT" + ")";
        db.execSQL(CREATE_LOGIN_TABLE);

        String CREATE_HASIL_TABLE = "CREATE TABLE " + TABLE_HASIL + "("
                + KEY_ID_HASIL + " INTEGER PRIMARY KEY," + KEY_ID_USER + " TEXT,"
                + KEY_DENYUT + " TEXT," + KEY_SUHU + " TEXT,"
                + KEY_TANGGAL + " TEXT" + ")";
        db.execSQL(CREATE_HASIL_TABLE);

        Log.d(TAG, "Database tables created");
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_LOGIN);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_HASIL);
        onCreate(db);
    }
    public void addUser(String name, String email, String uid, String created_at, String age, String gender) {
        SQLiteDatabase db = this.getWritableDatabase();

        ContentValues values = new ContentValues();
        values.put(KEY_NAME, name);
        values.put(KEY_EMAIL, email);
        values.put(KEY_UID, uid);
        values.put(KEY_CREATED_AT, created_at);
        values.put(KEY_AGE, age);
        values.put(KEY_GENDER, gender);
        long id = db.insert(TABLE_LOGIN, null, values);
        db.close();

        Log.d(TAG, "New user inserted into sqlite: " + id);
    }

    public void addHasil(String idUser, String denyut, String suhu, String tanggal) {
        SQLiteDatabase db = this.getWritableDatabase();

        ContentValues values = new ContentValues();
        values.put(KEY_ID_USER, idUser);
        values.put(KEY_DENYUT, denyut);
        values.put(KEY_SUHU, suhu);
        values.put(KEY_TANGGAL, tanggal);
        long id = db.insert(TABLE_HASIL, null, values);
        db.close();

        Log.d(TAG, "New user inserted into sqlite: " + id);
    }
    public HashMap<String, String> getUserDetails() {
        HashMap<String, String> user = new HashMap<String, String>();
        String selectQuery = "SELECT  * FROM " + TABLE_LOGIN;

        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.rawQuery(selectQuery, null);
        cursor.moveToFirst();
        if (cursor.getCount() > 0) {
            user.put("name", cursor.getString(1));
            user.put("email", cursor.getString(2));
            user.put("uid", cursor.getString(3));
            user.put("created_at", cursor.getString(4));
            user.put("age", cursor.getString(5));
            user.put("gander", cursor.getString(6));
        }
        cursor.close();
        db.close();
        Log.d(TAG, "Fetching user from Sqlite: " + user.toString());

        return user;
    }

    public HashMap<String, String> getHasilDetails() {
        HashMap<String, String> hasil = new HashMap<String, String>();
        String selectQuery = "SELECT  * FROM " + TABLE_HASIL;

        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.rawQuery(selectQuery, null);
        cursor.moveToFirst();
        if (cursor.getCount() > 0) {
            hasil.put("idUser", cursor.getString(1));
            hasil.put("denyut", cursor.getString(2));
            hasil.put("suhu", cursor.getString(3));
            hasil.put("tanggal", cursor.getString(4));
        }
        cursor.close();
        db.close();
        Log.d(TAG, "Fetching user from Sqlite: " + hasil.toString());

        return hasil;
    }
    public int getRowCount() {
        String countQuery = "SELECT  * FROM " + TABLE_LOGIN;
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.rawQuery(countQuery, null);
        int rowCount = cursor.getCount();
        db.close();
        cursor.close();
        return rowCount;
    }

    public int getCountHasil() {
        String countQuery = "SELECT  * FROM " + TABLE_HASIL;
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.rawQuery(countQuery, null);
        int rowCount = cursor.getCount();
        db.close();
        cursor.close();
        return rowCount;
    }

    public void deleteUsers() {
        SQLiteDatabase db = this.getWritableDatabase();
        db.delete(TABLE_LOGIN, null, null);
        db.close();

        Log.d(TAG, "Deleted all user info from sqlite");
    }
}