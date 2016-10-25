#include <Time.h>
#include <TimeLib.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

ESP8266WiFiMulti WiFiMulti;
LiquidCrystal_I2C lcd(0x27 , 16, 2);

int detik;
int menit;
int jam;
int tanggal;
int bulan;
int tahun;

void setup() {
  Serial.begin(115200);
  delay(1000);

  Wire.begin(2, 0);
  lcd.begin();
  lcdOut("Starting", 0);
  lcdOut("kangarie.com", 1);
  delay (3000);

  lcdOut("Desktop Clock", 0);
  delay (3000);

  WiFiMulti.addAP("eLearning", "");
  WiFiMulti.addAP("Perpustakaan", "");
  WiFiMulti.addAP("KangArie", "");
  lcdOut("wifi connecting", 0);
}

void loop() {
  if ((WiFiMulti.run() == WL_CONNECTED)) {
    if (timeStatus() == timeNotSet) {
      lcdOut("Get Online Date", 0);
      detik   = getURL("http://api.kangarie.com/clock/detik");
      menit   = getURL("http://api.kangarie.com/clock/menit");
      jam     = getURL("http://api.kangarie.com/clock/jam");
      tanggal = getURL("http://api.kangarie.com/clock/tanggal");
      bulan   = getURL("http://api.kangarie.com/clock/bulan");
      tahun   = getURL("http://api.kangarie.com/clock/tahun");

      setTime(jam, menit, detik, tanggal, bulan, tahun);
      lcd.clear();
    }

    lcd.setCursor (0, 0);
    lcd.print(year());
    lcd.print("/");
    lcd.print(angka(month()));
    lcd.print("/");
    lcd.print(angka(day()));
    lcd.print(" ");

    lcd.setCursor (0, 1);
    lcd.print(angka(hour()));
    lcd.print(":");
    lcd.print(angka(minute()));
    lcd.print(":");
    lcd.print(angka(second()));

  }
  delay(1000);
}

String angka(int n) {
  String tmp;
  if (n < 10) {
    tmp = String(0) + String(n);
  }
  else {
    tmp = String(n);
  }
  return tmp;
}

int getURL(String url) {
  HTTPClient http;
  String out;
  int httpCode;

  http.begin(url);
  httpCode = http.GET();
  out = http.getString();
  http.end();

  delay(1);

  return out.toInt();
}

void lcdOut(String text, int line) {
  lcd.setCursor (0, line);
  lcd.print(text);
}
