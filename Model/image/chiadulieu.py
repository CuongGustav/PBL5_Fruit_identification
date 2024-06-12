import os
import shutil
from glob import glob

# Đường dẫn thư mục gốc chứa các ảnh
source_dir = 'all_image'

# Đường dẫn tới các thư mục đích
val_dir = 'val'
test_dir = 'test'

# Tạo thư mục val và test nếu chúng không tồn tại
os.makedirs(val_dir, exist_ok=True)
os.makedirs(test_dir, exist_ok=True)

# Lấy danh sách tất cả các ảnh trong thư mục source_dir
image_files = glob(os.path.join(source_dir, '*.jpg'))

# Sắp xếp các ảnh theo tên
image_files.sort()

# Dictionary để lưu trữ các ảnh theo nhóm
image_dict = {}

for image_file in image_files:
    # Lấy tên ảnh mà không có số và đuôi .jpg
    image_name = os.path.basename(image_file)
    base_name = ''.join([i for i in image_name if not i.isdigit()]).replace('.jpg', '')
    
    if base_name not in image_dict:
        image_dict[base_name] = []
    image_dict[base_name].append(image_file)

# Chia các ảnh vào các thư mục val và test
for base_name, files in image_dict.items():
    for idx, file in enumerate(files):
        if idx % 2 == 0:
            shutil.copy(file, val_dir)
        else:
            shutil.copy(file, test_dir)

print("Đã hoàn thành việc chia ảnh vào thư mục val và test.")
