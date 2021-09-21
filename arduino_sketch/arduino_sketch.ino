#include <ESP8266HTTPClient.h>
#include <CayenneMQTTESP8266.h>
#include <DHT.h>

#define CAYENNE_PRINT Serial

//WiFi Credential (Connect to WiFi)
char ssid[] = "CANALBOX-BA81";
char wifi_password[] = "8955819532";

//char ssid[] = "CANALBOX-DBD6";
//char wifi_password[] = " 1316523275";

//Cayenne Credentials 
char username[] = "00be5fb0-0976-11ec-9b2d-abd5fca49150";
char password[] = "b38634a5f495ea8fd5bc897f7864c056a615186a";
char clientID[] = "5ad07260-137e-11ec-9b2d-abd5fca49150";

//Capacitive soil moisture sensor setings
//-------------------------------------------------------------//
int sensor_pin = A0;
//const int constant_value_in_air  = 0; //this is must be higher than the value in water
//const int constant_value_in_water = 0; //this must be lower than the value in air.
int moisture_value = 0;
float sensor_voltage = 0;
int soil_moisture_percent = 0;

//DHT 11 Settings
//-------------------------------------------------------------//
#define DHTPIN 5
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE); 
//Variables to hold temperature and humidity
float t;
float h;

int actuator = 4;

WiFiClient client;
WiFiClient client1;

void setup() {
  Serial.begin(9600);
  Cayenne.begin(username, password, clientID, ssid, wifi_password);
  dht.begin();
  pinMode(A0, OUTPUT);
  pinMode(actuator, OUTPUT);
}

void loop() {
  Cayenne.loop();
  
  moisture_value = analogRead(sensor_pin);

//  Displaying soil moisture value to Serial Monitor
  Serial.print("Moisture Value: ");
  Serial.println(moisture_value);
  
  t = dht.readTemperature();
  h = dht.readHumidity();
  
  Serial.print("Temperature: ");
  Serial.print(t);
  Serial.println("C");
  Serial.print("Humidity: ");
  Serial.print(h);
  Serial.println("%");
  
//  virtualWrite(channel_number, value, "type value", "unit value");
  //or use map form 0 to 100
//  Cayenne.virtualWrite(1, map(ldr_data, 0, 1024, 0, 100));

//  Pushing sensors values to Cayene dashboard
//-------------------------------------------------------------//
  Cayenne.virtualWrite(0, moisture_value);
  Cayenne.virtualWrite(1, t);
  Cayenne.virtualWrite(2, h);

// Pushing sensors values to MySql database
//-------------------------------------------------------------//
  HTTPClient http; 
  
  String send_t, send_h, s_moisture, postData;
  send_t = String(t);
  send_h = String(h);
  s_moisture = String(moisture_value);
  
  postData = "send_t=" + send_t + "&send_h=" + send_h + "&s_moisture=" + s_moisture;
  
  http.begin(client, "http://192.168.1.219/Smart_Agri/db_push.php");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData);
  
  if(httpCode == 200){
    Serial.println("Connected to local server successfully");
    String playload = http.getString();
    Serial.println(playload + "\n");
  }else{
    Serial.println(httpCode);
    Serial.println("Failed to upload valules");
    http.end();
  }

//http to get data from the server(database)
  HTTPClient httpGet;

  httpGet.begin(client1, "http://192.168.1.219/Smart_Agri/getData.php");
  httpGet.addHeader("Content-Type", "application/x-www-form-urlencoded");

//  getData = "ID=" + String(id);
//  int httpCodeGet = httpGet.POST(getData); 

  int httpCode1 = httpGet.GET();
  if(httpCode1 == 200){
    Serial.println("Connected successfully");
    String payloadGet = httpGet.getString();
    Serial.print("Irrigaion status from db: ");
    Serial.println(payloadGet);

//Turn on irrigation if value returned from db is 1 and soil_moisture value is greater than or equal 700.
//Turn off irrigation if value returned from the db is 0 and soil moisture value is less than or equal to 580.

    if(payloadGet == "1"){
        digitalWrite(actuator, HIGH);
      }else{
        digitalWrite(actuator, LOW);
      }
    
  }else{
    Serial.println("Not Connected");
  }
  
  delay(5000); //Posting data every 5seconds 
}

CAYENNE_IN(0) {
  
}
