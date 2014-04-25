package com.example.docprocessor;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioGroup;
import android.widget.EditText;

public class DocProcessing extends Activity {
	Button btnStart, btnExit;
	EditText etToken;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.doc_process_goal);
		
		btnStart = (Button)findViewById(R.id.buttonStart);
		btnStart.setOnClickListener(new Button.OnClickListener(){
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent intent = new Intent("com.google.zxing.client.android.SCAN");	//開啟條碼掃描器
				intent.putExtra("SCAN_MODE", "QR_CODE_MODE");	//設定QR Code參數
				startActivityForResult(intent, 1);	//要求回傳1
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
		etToken=(EditText)findViewById(R.id.valuePassword);
		etToken.clearFocus();
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		// TODO Auto-generated method stub
		super.onActivityResult(requestCode, resultCode, data);
 
		if (requestCode == 1) {	//startActivityForResult回傳值
			if (resultCode == RESULT_OK) {
				String contents = data.getStringExtra("SCAN_RESULT");	//取得QR Code內容
				String SetAs="";
				Intent intent = new Intent(DocProcessing.this,DocProcessResult.class);
				RadioGroup rg = (RadioGroup) findViewById(R.id.linearLayoutAs);
				EditText evtoken = (EditText)findViewById(R.id.valuePassword); 
				switch(rg.getCheckedRadioButtonId()){
                	case R.id.radioButtonAsReceived:
                			SetAs="received";
                			break;
                	case R.id.radioButtonAsSent:
                			SetAs="sent";
                			break;
                	case R.id.radioButtonAsRefused:
            			SetAs="refused";
            			break;
                	case R.id.radioButtonAsVoided:
            			SetAs="voided";
            			break;
				}
				intent.putExtra("SET_AS",SetAs);
				intent.putExtra("STAFF_PWD",evtoken.getText().toString());
				intent.putExtra("SCAN_CONTENT", contents);
                startActivity(intent);
			}
		}
	}

}
