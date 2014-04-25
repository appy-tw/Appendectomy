package com.example.docprocessor;

import java.io.IOException;

import org.apache.http.HttpResponse;
import org.apache.http.ParseException;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.text.TextUtils;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class DocProcessResult extends Activity {
	public Button btnContinue, btnExit;
	String SCAN_CONTENT="",STAFF_PWD="",SET_AS="";
	String[] DocType= {"提議書","連署書"};
	TextView tvToken;
	DocProcessorDB helper;
	public String remoteURL="",nickname="",SNO="",VC="";
	EditText etToken;
	String[] districtList;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.process_result);
		
		districtList = getResources().getStringArray(R.array.district_array);
		
		helper = new DocProcessorDB(this);
		SQLiteDatabase db = helper.getReadableDatabase();
        Cursor c = db.query("PERSONAL_SETTING", new String[]{"docprocessor_url","nickname"},"userid=1",null,null,null,null);
        c.moveToFirst();
        if(!TextUtils.isEmpty(c.getString(0)))
        {
        	remoteURL=c.getString(0);
        	if((remoteURL.substring(remoteURL.length()-1)).equals("/"))
        	{
        		remoteURL=remoteURL+"processing.php";
        	}
        	else
        	{
        		remoteURL=remoteURL+"/processing.php";
        	}
        	nickname=c.getString(1);
        }
        db.close();

		Bundle extras = getIntent().getExtras();
		if(extras!=null)
		{
			SCAN_CONTENT=extras.getString("SCAN_CONTENT");
			if(!TextUtils.isEmpty(extras.getString("STAFF_PWD")))
				STAFF_PWD=extras.getString("STAFF_PWD");
			if(!TextUtils.isEmpty(extras.getString("SET_AS")))
				SET_AS=extras.getString("SET_AS");
			if(!TextUtils.isEmpty(SCAN_CONTENT))
			{
				parserResult(SCAN_CONTENT,remoteURL);
			}
		}

		

		
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

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		// TODO Auto-generated method stub
		super.onActivityResult(requestCode, resultCode, data);
 
		if (requestCode == 1) {	//startActivityForResult回傳值
			if (resultCode == RESULT_OK) {
				String contents = data.getStringExtra("SCAN_RESULT");	//取得QR Code內容
				parserResult(contents,remoteURL);
			}
		}
	}
	
	public void parserResult(String scannedString,String RemoteURL){
		tvToken=(TextView)findViewById(R.id.valueSerialNo);
		SNO=scannedString.substring(0, 11);
		tvToken.setText(SNO);
		tvToken=(TextView)findViewById(R.id.valueDocType);
		tvToken.setText(DocType[Integer.parseInt(scannedString.substring(4, 5))-1]);
		tvToken=(TextView)findViewById(R.id.valueDistrict);
		VC=scannedString.substring(15);
		tvToken.setText(districtList[Integer.parseInt(scannedString.substring(2, 4))-1]);
		etToken=(EditText)findViewById(R.id.editTextIDL5);
		String url=RemoteURL+"?SNO="+SNO+"&VC="+VC+"&STATUS="+SET_AS+"&STFPWD="+STAFF_PWD+"&NICKNAME="+nickname+"&IDL5="+etToken.getText().toString();
		if(!url.substring(0, 7).equalsIgnoreCase("http://"))
		{
			url="http://"+url;
		}
    	HttpGet httpGet = new HttpGet(url);
    	HttpResponse httpResponse=null;
		try {
			httpResponse = new DefaultHttpClient().execute(httpGet);
		} catch (ClientProtocolException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		if(httpResponse.getStatusLine().getStatusCode()==200)
		{
			try {
				String result = EntityUtils.toString(httpResponse.getEntity());
				if(result.length()>0)
				{
					String[] final_result=result.split(";");
					if(final_result.length>1)
					{
						tvToken=(TextView)findViewById(R.id.valueDocOriStatus);
						tvToken.setText(final_result[0]);
						tvToken=(TextView)findViewById(R.id.valueDocStatus);
						if(final_result[1].equalsIgnoreCase("NOCHANGE"))
						{
							tvToken.setText(final_result[0]);
							tvToken=(TextView)findViewById(R.id.valueStatusUpdatetime);
							tvToken.setText("資料未變動");
						}
						else
						{
							tvToken.setText(SET_AS);
							tvToken=(TextView)findViewById(R.id.valueStatusUpdatetime);
							tvToken.setText(final_result[2]);
						}
						SNO=VC="";
						etToken.setText("");
						etToken.clearFocus();
						
						tvToken=(TextView)findViewById(R.id.valueIDL5);
						tvToken.setText(R.string.no_idl5);
						tvToken=(TextView)findViewById(R.id.valueNextStep);
						tvToken.setText(R.string.nextdoc);
						
						btnContinue = (Button)findViewById(R.id.buttonContinue);
						btnContinue.setOnClickListener(null);
						btnContinue.setOnClickListener(new Button.OnClickListener(){
							@Override
							public void onClick(View v) {
								// TODO Auto-generated method stub
								Intent intent = new Intent("com.google.zxing.client.android.SCAN");	//開啟條碼掃描器
								intent.putExtra("SCAN_MODE", "QR_CODE_MODE");	//設定QR Code參數
								startActivityForResult(intent, 1);	//要求回傳1				
							}
				        });
					}
					else
					{
						if(final_result[0].equals("IDL5"))
						{
							tvToken=(TextView)findViewById(R.id.valueDocOriStatus);
							tvToken.setText(R.string.add_idl5);
							tvToken=(TextView)findViewById(R.id.valueDocStatus);
							tvToken.setText(R.string.add_idl5);
							tvToken=(TextView)findViewById(R.id.valueStatusUpdatetime);
							tvToken.setText(R.string.add_idl5);
							tvToken=(TextView)findViewById(R.id.valueIDL5);
							tvToken.setText(R.string.add_idl5);
							tvToken=(TextView)findViewById(R.id.valueNextStep);
							tvToken.setText(R.string.idl5first);
							
							
							final String innerScannedString=scannedString;
							final String innerRemoteURL=RemoteURL;
							btnContinue = (Button)findViewById(R.id.buttonContinue);
							btnContinue.setOnClickListener(null);
							btnContinue.setOnClickListener(new Button.OnClickListener(){
								@Override
								public void onClick(View v) {
									// TODO Auto-generated method stub
									parserResult(innerScannedString,innerRemoteURL);
								}
					        });						
							etToken.requestFocus();
						}
						else if(final_result[0].equals("STFPWD"))
						{
							tvToken=(TextView)findViewById(R.id.valueDocOriStatus);
							tvToken.setText(R.string.back_for_stfpwd);
							tvToken=(TextView)findViewById(R.id.valueDocStatus);
							tvToken.setText(R.string.back_for_stfpwd);
							tvToken=(TextView)findViewById(R.id.valueStatusUpdatetime);
							tvToken.setText(R.string.back_for_stfpwd);
							tvToken=(TextView)findViewById(R.id.valueIDL5);
							tvToken.setText(R.string.back_for_stfpwd);
							tvToken=(TextView)findViewById(R.id.valueNextStep);
							tvToken.setText(R.string.back_for_stfpwd);
						}
						else if(final_result[0].equals("NA"))
						{
							tvToken=(TextView)findViewById(R.id.valueDocOriStatus);
							tvToken.setText(R.string.no_user);
							tvToken=(TextView)findViewById(R.id.valueDocStatus);
							tvToken.setText(R.string.no_user);
							tvToken=(TextView)findViewById(R.id.valueStatusUpdatetime);
							tvToken.setText(R.string.no_user);
							tvToken=(TextView)findViewById(R.id.valueIDL5);
							tvToken.setText(R.string.no_idl5);
							tvToken=(TextView)findViewById(R.id.valueNextStep);
							tvToken.setText(R.string.updateuser);
						}
					}
				}
			} catch (ParseException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}

		
		
		
//		tvToken=(TextView)findViewById(R.id.valueDocOriStatus);
//		tvToken.setText(remoteURL);
	}
	

}
