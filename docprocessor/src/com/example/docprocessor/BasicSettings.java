package com.example.docprocessor;

import android.os.Bundle;
import android.app.Activity;
import android.content.ContentValues;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.text.TextUtils;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class BasicSettings extends Activity {
	Button btnSet, btnExit;
	DocProcessorDB helper;
	EditText etURL,etNickname;
	TextView tvToken;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.basic_setting);

    	etURL = (EditText)findViewById(R.id.editTextRemoteURL);
    	etNickname = (EditText)findViewById(R.id.editTextNickname);
		
		helper = new DocProcessorDB(this);
		SQLiteDatabase db = helper.getReadableDatabase();
        Cursor c = db.query("PERSONAL_SETTING", new String[]{"docprocessor_url","nickname"},"userid=1",null,null,null,null);
        c.moveToFirst();
        if(!TextUtils.isEmpty(c.getString(0)))
        {
        	etURL.setText(c.getString(0));
        }
        if(!TextUtils.isEmpty(c.getString(1)))
        {
        	etNickname.setText(c.getString(1));
        }
        db.close();
		
		btnSet = (Button)findViewById(R.id.buttonSet);
		btnSet.setOnClickListener(new Button.OnClickListener(){
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				SQLiteDatabase db = helper.getWritableDatabase();
				ContentValues args = new ContentValues();
				args.put("docprocessor_url", etURL.getText().toString());
				args.put("nickname", etNickname.getText().toString());
		        if(db.update("PERSONAL_SETTING", args,"userid=1",null)>0)
		        {
		        	tvToken=(TextView)findViewById(R.id.textViewSetResult);
		        	tvToken.setText(R.string.set_succeeded);
		        }
		        else
		        {
		        	tvToken.setText(R.string.set_failed);
		        }
		        
			}
        });
		
		btnExit = (Button)findViewById(R.id.buttonExit);
		btnExit.setOnClickListener(new Button.OnClickListener(){
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				finish();
			}
        });
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

}
