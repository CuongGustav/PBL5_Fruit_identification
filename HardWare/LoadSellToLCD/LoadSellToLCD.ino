#include <HX711_ADC.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

HX711_ADC LoadCell(6, 7);
LiquidCrystal_I2C lcd(0x27, 16, 2);

float accurateWeight = 0.0; // Giá trị cân nặng chính xác ban đầu
float currentWeight = 0.0; // Giá trị cân nặng hiện tại
float weightChangeThreshold = 2.0; // Ngưỡng thay đổi cân nặng (ví dụ: 2 gam)

void setup() {
  LoadCell.begin();
  LoadCell.start(2000);
  LoadCell.setCalFactor(226.065421);
  lcd.init();
  lcd.backlight();
}
const int numReadings = 10; // Số lượng phần tử trong mảng
float readings[numReadings]; // Mảng lưu trữ giá trị

void loop() {
  LoadCell.update();
  currentWeight = LoadCell.getData();

  // Lưu giá trị vào mảng
  for (int i = 0; i < numReadings - 1; i++) {
    readings[i] = readings[i + 1];
  }
  readings[numReadings - 1] = currentWeight;

  // Tính giá trị trung bình
  float sum = 0.0;
  for (int i = 0; i < numReadings; i++) {
    sum += readings[i];
  }
  float currentWeightR = sum / numReadings;

  // Kiểm tra sự thay đổi và hiển thị lên LCD
  float weightChange = abs(currentWeightR - accurateWeight);
  if (weightChange >= weightChangeThreshold) {
    accurateWeight = currentWeightR;
  }

  lcd.setCursor(0, 0);
  lcd.print("Weight[g]:");
  lcd.setCursor(0, 1);
  // Display weight or 0 if it's less than 2g
  if (accurateWeight < 2.0) {
    accurateWeight = 0.00000000;
  }
  lcd.print(accurateWeight);
}

