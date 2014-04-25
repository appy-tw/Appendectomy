package com.example.docprocessor;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.database.sqlite.SQLiteDatabase;
import android.view.Menu;
import android.view.View;
import android.widget.Button;

public class MainActivity extends Activity {
	Button btnBasicSettings, btnProcessing;
	DocProcessorDB helper;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		helper = new DocProcessorDB(this);
		SQLiteDatabase db = helper.getReadableDatabase();
		btnBasicSettings = (Button)findViewById(R.id.buttonSetting);
		btnBasicSettings.setOnClickListener(new Button.OnClickListener(){
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
    			Intent intent = new Intent(MainActivity.this,BasicSettings.class);
                startActivity(intent);
			}
        });
		
		btnProcessing = (Button)findViewById(R.id.buttonProcessing);
		btnProcessing.setOnClickListener(new Button.OnClickListener(){
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
    			Intent intent = new Intent(MainActivity.this,DocProcessing.class);
                startActivity(intent);
			}
        });
		db.close();
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

}
