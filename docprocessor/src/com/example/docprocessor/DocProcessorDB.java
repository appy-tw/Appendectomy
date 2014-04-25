package com.example.docprocessor;

import java.util.Random;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteStatement;
import android.database.sqlite.SQLiteDatabase.CursorFactory;
import android.database.sqlite.SQLiteOpenHelper;

public class DocProcessorDB extends SQLiteOpenHelper {
	final private static int DATABASE_VERSION = 1;
	final private static String DATABASE_NAME = "DocProcessorDB";
	public DocProcessorDB(Context context){
		super(context, DATABASE_NAME, null, DATABASE_VERSION);
	}
	public DocProcessorDB(Context context, String name, CursorFactory factory, int version){
		super(context, name, factory, version);
	}

	//政黨資料陣列
	private String [][] PARTY_DATA = {
			{"0","無黨籍","no_party"},
			{"1","中國國民黨","kmt"},
			{"2","民主進步黨","ddp"},
			{"3","台灣團結聯盟","tsu"},
			{"4","親民黨","pfp"},
			{"5","無黨團結聯盟","npsu"}
	};

	//立委類別資料陣列
	private String[][] LEGISLATOR_TYPE = {
			{"0","全國不分區","全國","all_no"},
			{"1","一般分區","分區","normal_dist"},
			{"2","平地原住民","平原","plain_native"},
			{"3","山區原住民","山員","mount_native"},
			{"4","僑居國外國民","僑居","foreign"}
	};

	//立委選區資料陣列
	private String[][] LEGIST_DIST_DATA = {
			{"1","臺北市第01選區","臺北01"},
			{"2","臺北市第02選區","臺北02"},
			{"3","臺北市第03選區","臺北03"},
			{"4","臺北市第04選區","臺北04"},
			{"5","臺北市第05選區","臺北05"},
			{"6","臺北市第06選區","臺北06"},
			{"7","臺北市第07選區","臺北07"},
			{"8","臺北市第08選區","臺北08"},
			{"100","基隆市選區","基隆市"},
			{"201","新北市第01選區","新北01"},
			{"202","新北市第02選區","新北02"},
			{"203","新北市第03選區","新北03"},
			{"204","新北市第04選區","新北04"},
			{"205","新北市第05選區","新北05"},
			{"206","新北市第06選區","新北06"},
			{"207","新北市第07選區","新北07"},
			{"208","新北市第08選區","新北08"},
			{"209","新北市第09選區","新北09"},
			{"210","新北市第10選區","新北10"},
			{"211","新北市第11選區","新北11"},
			{"212","新北市第12選區","新北12"},
			{"300","宜蘭縣選區","宜蘭縣"},
			{"401","桃園縣第01選區","桃園01"},
			{"402","桃園縣第02選區","桃園02"},
			{"403","桃園縣第03選區","桃園03"},
			{"404","桃園縣第04選區","桃園04"},
			{"405","桃園縣第05選區","桃園05"},
			{"406","桃園縣第06選區","桃園06"},
			{"500","新竹市選區","新竹市"},
			{"600","新竹縣選區","新竹縣"},
			{"701","苗栗縣第01選區","苗縣01"},
			{"702","苗栗縣第02選區","苗縣02"},
			{"801","臺中市第01選區","臺中01"},
			{"802","臺中市第02選區","臺中02"},
			{"803","臺中市第03選區","臺中03"},
			{"804","臺中市第04選區","臺中04"},
			{"805","臺中市第05選區","臺中05"},
			{"806","臺中市第06選區","臺中06"},
			{"807","臺中市第07選區","臺中07"},
			{"808","臺中市第08選區","臺中08"},
			{"901","彰化縣第01選區","彰化01"},
			{"902","彰化縣第02選區","彰化02"},
			{"903","彰化縣第03選區","彰化03"},
			{"904","彰化縣第04選區","彰化04"},
			{"1001","南投縣第01選區","南投01"},
			{"1002","南投縣第02選區","南投02"},
			{"1101","雲林縣第01選區","雲林01"},
			{"1102","雲林縣第02選區","雲林02"},
			{"1200","嘉義市選區","嘉義市"},
			{"1301","嘉義縣第01選區","嘉縣01"},
			{"1302","嘉義縣第02選區","嘉縣02"},
			{"1401","臺南市第01選區","臺南01"},
			{"1402","臺南市第02選區","臺南02"},
			{"1403","臺南市第03選區","臺南03"},
			{"1404","臺南市第04選區","臺南04"},
			{"1405","臺南市第05選區","臺南05"},
			{"1501","高雄市第01選區","高雄01"},
			{"1502","高雄市第02選區","高雄02"},
			{"1503","高雄市第03選區","高雄03"},
			{"1504","高雄市第04選區","高雄04"},
			{"1505","高雄市第05選區","高雄05"},
			{"1506","高雄市第06選區","高雄06"},
			{"1507","高雄市第07選區","高雄07"},
			{"1508","高雄市第08選區","高雄08"},
			{"1509","高雄市第09選區","高雄09"},
			{"1601","屏東縣第01選區","屏東01"},
			{"1602","屏東縣第02選區","屏東02"},
			{"1603","屏東縣第03選區","屏東03"},
			{"1700","臺東縣選區","臺東縣"},
			{"1800","花蓮縣選區","花蓮縣"},
			{"1900","澎湖縣選區","澎湖縣"},
			{"2000","金門縣選區","金門縣"},
			{"2100","連江縣選區","連江縣"},
			{"2200","平地原住民","平地原"},
			{"2300","山地原住民","山地原"},
			{"2400","僑居國外國民","僑外居"},
			{"9999","全國不分區","不分區"}
	};

	//立委基本資料陣列
	private String[][] LEGISLATOR_DATA ={
			{"1","丁守中","1","1","1"},
			{"2","孔文吉","3","2300","1"},
			{"3","尤美女","0","9999","2"},
			{"4","王廷升","1","1800","1"},
			{"5","王育敏","0","9999","1"},
			{"6","王金平","0","9999","1"},
			{"7","王惠美","1","901","1"},
			{"8","王進士","1","1602","1"},
			{"9","田秋堇","0","9999","2"},
			{"10","江啟臣","1","808","1"},
			{"11","江惠貞","1","207","1"},
			{"12","何欣純","1","807","2"},
			{"13","吳育仁","0","9999","1"},
			{"14","吳育昇","1","201","1"},
			{"15","吳宜臻","0","9999","2"},
			{"16","吳秉叡","0","9999","2"},
			{"17","呂玉玲","1","405","1"},
			{"18","呂學樟","1","500","1"},
			{"19","李昆澤","1","1506","2"},
			{"20","李俊俋","1","1200","2"},
			{"21","李桐豪","0","9999","4"},
			{"22","李貴敏","0","9999","1"},
			{"23","李慶華","1","212","1"},
			{"24","李應元","0","9999","2"},
			{"25","李鴻鈞","1","204","1"},
			{"26","林佳龍","1","806","2"},
			{"27","林岱樺","1","1504","2"},
			{"28","林明溱","1","1002","1"},
			{"29","林郁方","1","5","1"},
			{"30","林國正","1","1509","1"},
			{"31","林淑芬","1","202","2"},
			{"32","林滄敏","1","902","1"},
			{"33","林德福","1","209","1"},
			{"34","林鴻池","1","206","1"},
			{"35","邱文彥","0","9999","1"},
			{"36","邱志偉","1","1502","2"},
			{"37","邱議瑩","1","1501","2"},
			{"38","姚文智","1","2","2"},
			{"39","柯建銘","0","9999","2"},
			{"40","段宜康","0","9999","2"},
			{"41","洪秀柱","0","9999","1"},
			{"42","紀國棟","0","9999","1"},
			{"43","孫大千","1","406","1"},
			{"44","徐少萍","0","9999","1"},
			{"45","徐欣瑩","1","600","1"},
			{"46","徐耀昌","1","702","1"},
			{"47","翁重鈞","1","1301","1"},
			{"48","馬文君","1","1001","1"},
			{"49","高志鵬","1","203","2"},
			{"50","高金素梅","3","2300","5"},
			{"51","張嘉郡","1","1101","1"},
			{"52","張慶忠","1","208","1"},
			{"53","周倪安","0","9999","3"},
			{"54","許添財","1","1404","2"},
			{"55","許智傑","1","1508","2"},
			{"56","陳其邁","0","9999","2"},
			{"57","陳怡潔","0","9999","4"},
			{"58","陳明文","1","1302","2"},
			{"59","陳亭妃","1","1403","2"},
			{"60","陳唐山","1","1405","2"},
			{"61","陳根德","1","401","1"},
			{"62","陳淑慧","0","9999","1"},
			{"63","陳雪生","1","2100","0"},
			{"64","陳超明","1","701","1"},
			{"65","陳節如","0","9999","2"},
			{"66","陳碧涵","0","9999","1"},
			{"67","陳歐珀","1","300","2"},
			{"68","陳學聖","1","403","1"},
			{"69","陳鎮湘","0","9999","1"},
			{"70","曾巨威","0","9999","1"},
			{"71","費鴻泰","1","7","1"},
			{"72","賴振昌","0","9999","3"},
			{"73","黃志雄","1","205","1"},
			{"74","黃昭順","1","1503","1"},
			{"75","黃偉哲","1","1402","2"},
			{"76","楊玉欣","0","9999","1"},
			{"77","楊應雄","1","2000","1"},
			{"78","楊曜","1","1900","2"},
			{"79","楊瓊瓔","1","803","1"},
			{"80","楊麗環","1","404","1"},
			{"81","葉宜津","1","1401","2"},
			{"82","葉津鈴","0","9999","3"},
			{"83","詹凱臣","4","2400","1"},
			{"84","廖正井","1","402","1"},
			{"85","廖國棟","2","2200","1"},
			{"86","管碧玲","1","1505","2"},
			{"87","趙天麟","1","1507","2"},
			{"88","劉建國","1","1102","2"},
			{"89","劉櫂豪","1","1700","2"},
			{"90","潘孟安","1","1603","2"},
			{"91","潘維剛","0","9999","1"},
			{"92","蔡正元","1","4","1"},
			{"93","蔡其昌","1","801","2"},
			{"94","蔡煌瑯","0","9999","2"},
			{"95","蔡錦隆","1","804","1"},
			{"96","蔣乃辛","1","6","1"},
			{"97","鄭天財","2","2200","1"},
			{"98","鄭汝芬","1","903","1"},
			{"99","鄭麗君","0","9999","2"},
			{"100","盧秀燕","1","805","1"},
			{"101","盧嘉辰","1","210","1"},
			{"102","蕭美琴","0","9999","2"},
			{"103","賴士葆","1","8","1"},
			{"104","薛凌","0","9999","2"},
			{"105","謝國樑","1","100","1"},
			{"106","簡東明","3","2300","1"},
			{"107","顏寬恒","1","802","1"},
			{"108","魏明谷","1","904","2"},
			{"109","羅明才","1","211","1"},
			{"110","羅淑蕾","1","3","1"},
			{"111","蘇清泉","0","9999","1"},
			{"112","蘇震清","1","1601","2"}
	};

	@Override
	public void onCreate(SQLiteDatabase db) {
		// TODO Auto-generated method stub
		db.execSQL("DROP TABLE IF EXISTS DATABASE_NAME");
		SQLiteStatement stmt;
		try{
			
			//CREATE TABLE PARTY_DATA（政黨）
			String sqlPARTY_DATA = 
					"CREATE TABLE PARTY_DATA (" +
					"party_id INTEGER primary key autoincrement," +
					"party_name var not null," +
					"party_icon_path var not null);";
			db.execSQL(sqlPARTY_DATA);
	
			//INSERT DATA OF PARTY_DATA
			stmt = db.compileStatement("insert into PARTY_DATA values (?,?,?);");
			for(String[] party_content:PARTY_DATA){
				stmt.bindString(1,party_content[0]);
				stmt.bindString(2,party_content[1]);
				stmt.bindString(3,party_content[2]);
				stmt.executeInsert();
			}

			//CREATE TABLE LEGISLATOR_TYPE（立委類型）
			String sqlLEGISLATOR_TYPE = "CREATE TABLE LEGISLATOR_TYPE (" +
					"legislator_type_id INTEGER primary key autoincrement," +
					"legislator_type_name var not null," +
					"legislator_type_name_abbr var not null," +
					"legislator_type_icon_path var not null" +
					");";
			db.execSQL(sqlLEGISLATOR_TYPE);

			//INSERT DATA OF LEGISLATOR_TYPE
			stmt = db.compileStatement("insert into LEGISLATOR_TYPE values (?,?,?,?);");
			for(String[] legislator_type_content:LEGISLATOR_TYPE){
				stmt.bindString(1,legislator_type_content[0]);
				stmt.bindString(2,legislator_type_content[1]);
				stmt.bindString(3,legislator_type_content[2]);
				stmt.bindString(4,legislator_type_content[3]);
				stmt.executeInsert();
			}
			
			//CREATE TABLE LEGISLATOR_DIST_LIST（選區清單）
			String sqlLEGIST_DIST_LIST = "CREATE TABLE LEGISLATOR_DIST_LIST(" +
					"legislator_dist_id INTEGER primary key autoincrement," +
					"legislator_dist_name var not null,"+
					"legislator_dist_name_abbr var not null);";
			db.execSQL(sqlLEGIST_DIST_LIST);

			//INSERT DATA OF LEGISLATOR_DIST_LIST
			stmt = db.compileStatement("insert into LEGISLATOR_DIST_LIST values (?,?,?);");
			for(String[] legist_dist_content:LEGIST_DIST_DATA){
				stmt.bindString(1,legist_dist_content[0]);
				stmt.bindString(2,legist_dist_content[1]);
				stmt.bindString(3,legist_dist_content[2]);
				stmt.executeInsert();
			}

			//CREATE TABLE LEGISLATOR DATA（立委資料）
			String sqlLEGISLATOR_DATA = "CREATE TABLE LEGISLATOR_DATA (" +
					"legislator_id INTEGER primary key autoincrement," +
					"legislator_name var not null," +
					"legislator_type_id INTEGER not null DEFAULT 0," +
					"legislator_dist_id INTEGER not null DEFAULT 0," +
					"legislator_party_id INTEGER not null DEFAULT 0," +
					"legislator_effective INTEGER not null DEFAULT 1," +
					"FOREIGN KEY(legislator_type_id) REFERENCES LEGISLATOR_TYPE(legislator_type_id) ON UPDATE CASCADE ON DELETE SET DEFAULT," +
					"FOREIGN KEY(legislator_party_id) REFERENCES PARTY_DATA(party_id) ON UPDATE CASCADE ON DELETE SET DEFAULT," +
					"FOREIGN KEY(legislator_dist_id) REFERENCES LEGISLATOR_DIST_LIST(legislator_dist_id) ON UPDATE CASCADE ON DELETE SET DEFAULT);";
			db.execSQL(sqlLEGISLATOR_DATA);
			
			//INSERT DATA OF LEGISLATOR_DATA
			stmt = db.compileStatement("insert into LEGISLATOR_DATA values (?,?,?,?,?,?);");
			for(String[] legislator_data_content:LEGISLATOR_DATA){
				stmt.bindString(1,legislator_data_content[0]);
				stmt.bindString(2,legislator_data_content[1]);
				stmt.bindString(3,legislator_data_content[2]);
				stmt.bindString(4,legislator_data_content[3]);
				stmt.bindString(5,legislator_data_content[4]);
				stmt.bindString(6,"1");
				stmt.executeInsert();
			}
			
			//CREATE TABLE PERSONAL_SETTING（使用者資料設定）
			String sqlPERSONAL_SETTING = "CREATE TABLE PERSONAL_SETTING (" +
					"userid INTEGER primary key autoincrement," +
					"legislator_dist_id INTEGER," +
					"current_district_legislator_id INTEGER," +
					"current_district_legislator_name var," +
					"nickname var," +
					"staff_id var," +
					"docprocessor_url var," +
					"app_instance_id INTEGER," +
					"app_instance_id_key var," +
					"FOREIGN KEY(current_district_legislator_id) REFERENCES LEGISLATOR_DATA(legislator_id) ON UPDATE CASCADE ON DELETE SET NULL," +
					"FOREIGN KEY(legislator_dist_id) REFERENCES LEGISLATOR_DIST_LIST(legislator_dist_id) ON UPDATE CASCADE ON DELETE SET NULL" +
					");";
			db.execSQL(sqlPERSONAL_SETTING);
			
			//輸入第一筆資料
			String[] keyStoneString = {"0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"};
			String keyString = "";
			Random r = new Random();
			for(int i=0;i<16;i++)
			{
				keyString = keyString+keyStoneString[r.nextInt(15)];
			}
			sqlPERSONAL_SETTING = "INSERT INTO PERSONAL_SETTING (userid,app_instance_id_key) VALUES('1','"+keyString+"')";
			db.execSQL(sqlPERSONAL_SETTING);
		}
		catch(Exception ex){
		}
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		// TODO Auto-generated method stub
		db.execSQL("DROP TABLE IF EXISTS 'PARTY_DATA'");
		db.execSQL("DROP TABLE IF EXISTS 'LEGISLATOR_TYPE'");
		db.execSQL("DROP TABLE IF EXISTS 'LEGISLATOR_DIST_LIST'");
		db.execSQL("DROP TABLE IF EXISTS 'LEGISLATOR_DATA'");
		db.execSQL("DROP TABLE IF EXISTS 'PERSONAL_SETTING'");
		onCreate(db);		
	}
	
	@Override   
	public void onOpen(SQLiteDatabase db) {     
		super.onOpen(db);       
	           // TODO 每次成功打開數據庫後首先被執行     
    } 
	 
	@Override
	public synchronized void close() {
		super.close();
    }
}