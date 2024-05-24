// Khai báo các thư viện
#include <ArduinoJson.h>
#include <ESP8266WiFi.h>
#include <WiFiClientSecure.h>
#include <ESP8266HTTPClient.h>
#include <HX711_ADC.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <math.h> 


// Khai báo biến toàn cục
HX711_ADC LoadCell(12, 13); //DT-D6-GPIO12  SCK-D7-13
LiquidCrystal_I2C lcd(0x27, 16, 2);

// const char* ssid = "58/10 NGO SY LIEN";
// const char* password = "0358102223";

const char* ssid = "Gustav";
const char* password = "cuong2511";

// URL server HTTPS
const char* serverUrl = "https://server-1-c9nx.onrender.com/fruits/receive_fruits";

const int numReadings = 10;
double readings[numReadings];
double accurateWeight = 0.0;
double weightChangeThreshold = 2.0;

unsigned long lastUpdateTime = 0;
const unsigned long updateInterval = 2000; // Khoảng thời gian chờ (2 giây)

// Trong hàm setup và loop bạn có thể sử dụng các biến và đối tượng đã khai báo trên
void setup() {
    Serial.begin(115200);
    Wire.begin(2, 0); // SDA-GPIO2-D4  SCL-GPIO0-D3
    LoadCell.begin();
    LoadCell.start(500);
    LoadCell.setCalFactor(226.065421);
    lcd.init();
    lcd.backlight();

    // Kết nối Wi-Fi
    Serial.print("Connecting to Wi-Fi");
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
        Serial.print(".");
        delay(200);
    }
    Serial.println("\nKết nối Wi-Fi thành công.");
}

void loop() {
    LoadCell.update();
    double currentWeight = LoadCell.getData();

    // Cập nhật mảng readings
    for (int i = 0; i < numReadings - 1; i++) {
        readings[i] = readings[i + 1];
    }
    readings[numReadings - 1] = currentWeight;

    // Tính trọng lượng trung bình
    double sum = 0.0;
    for (int i = 0; i < numReadings; i++) {
        sum += readings[i];
    }
    double currentWeightR = sum / numReadings;
    // Làm tròn currentWeightR đến 2 chữ số thập phân
    currentWeightR = round(currentWeightR * 100) / 100;

    // Tính sự thay đổi trọng lượng
    double weightChange = abs(currentWeightR - accurateWeight);
    if (weightChange >= weightChangeThreshold) {
        accurateWeight = currentWeightR;

        // Cập nhật thời gian cuối cùng khi accurateWeight được thay đổi
        lastUpdateTime = millis();
    }

    // Kiểm tra xem đã đủ thời gian chờ trước khi gửi dữ liệu
    if (millis() - lastUpdateTime >= updateInterval) {
        sendJsonData();
    }

    // Hiển thị trọng lượng trên LCD
    lcd.setCursor(0, 0);
    lcd.print("Weight[g]:");
    lcd.setCursor(0, 1);
    lcd.print(accurateWeight < 3.0 ? 0.0 : accurateWeight);
}

// Khai báo một biến để lưu trữ giá trị weight đã gửi trước đó
double previousWeight = 0.0;

void sendJsonData() {
    // Kiểm tra nếu accurateWeight < 2 gam thì không gửi dữ liệu
    if (accurateWeight < 5.0) {
        return; // Không thực hiện bất kỳ hà  nh động nào
    }

    // Kiểm tra sự khác biệt giữa accurateWeight và previousWeight
    double weightDifference = abs(accurateWeight - previousWeight);
    
    // Nếu sự khác biệt trong khoảng ±3 gam, không gửi dữ liệu
    if (weightDifference <= 3.0) {
        return; // Không thực hiện bất kỳ hành động nào
    }

    // Tạo WiFiClientSecure và thiết lập bỏ qua xác minh chứng chỉ
    WiFiClientSecure wifiClientSecure;
    wifiClientSecure.setInsecure();

    HTTPClient http;

    // Bắt đầu kết nối HTTPS
    http.begin(wifiClientSecure, serverUrl);

    // Thêm header nội dung
    http.addHeader("Content-Type", "application/json");

    // Tạo tài liệu JSON
    DynamicJsonDocument jsonDoc(128);
    // jsonDoc["name"] = "xoai";
    jsonDoc["weight"] = accurateWeight;

    // Serialize tài liệu JSON
    String jsonString;
    serializeJson(jsonDoc, jsonString);

    // Gửi yêu cầu POST
    int httpResponseCode = http.POST(jsonString);
    if (httpResponseCode == HTTP_CODE_OK) {
        Serial.println("Gửi dữ liệu thành công!");
    } else {
        Serial.print("Lỗi gửi dữ liệu. Mã phản hồi HTTP: ");
        Serial.println(httpResponseCode);
    }

    // Cập nhật previousWeight sau khi gửi dữ liệu thành công
    if (httpResponseCode == HTTP_CODE_OK) {
        previousWeight = accurateWeight; // Lưu giá trị weight hiện tại   
    }

    // Kết thúc kết nối
    http.end();
}

