import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns

# Ma trận dữ liệu
data = np.array([
    [0, 9, 0, 0, 0, 0, 0, 0,0,0, 0],
    [1, 0, 5, 0, 0, 0, 0, 0,0,0, 2],
    [1, 0, 0, 5, 0, 0, 0, 0,0,1, 0],
    [0, 0, 0, 0, 8, 0, 0, 0,0,0, 0],
    [0, 0, 0, 0, 0, 7, 0, 0,1,0, 0],
    [0, 0, 0, 0, 0, 0, 8, 0,0,0, 0],
    [0, 0, 0, 0, 0, 0, 0, 7,0,0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0,9,0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0,1,8, 0],
    [0, 0, 0, 0, 3, 0, 0, 0,0,0, 8]
])

# Biểu đồ heatmap
plt.figure(figsize=(10, 6))
sns.heatmap(data, annot=True, fmt='d', cmap='YlGnBu', xticklabels=['0','Bơ', 'Cam', 'Chuối', 'Lê', 'Mận', 'Măng Cụt', 'Ổi', 'Táo', 'Thanh Long'], yticklabels=['Bơ','Cam','Chuối', 'Lê', 'Mận', 'Măng Cụt', 'Ổi', 'Táo', 'Thanh Long', 'Xoài'])
plt.xticks(rotation=30)
plt.xlabel('Nhãn dự đoán')
plt.ylabel('Nhãn thực tế')
plt.title('kết quả nhận diện trên tập test')
plt.show()
