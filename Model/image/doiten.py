import os

def rename_files(folder_path, prefix):
    # Kiểm tra thư mục có tồn tại không
    if not os.path.exists(folder_path):
        print(f"Folder {folder_path} does not exist.")
        return

    # Lấy danh sách tất cả các tệp trong thư mục
    files = os.listdir(folder_path)

    # Biến đếm để tạo tên mới
    counter = 1

    # Duyệt qua từng tệp và đổi tên
    for filename in files:
        # Bỏ qua các thư mục, chỉ xử lý tệp
        if os.path.isfile(os.path.join(folder_path, filename)):
            old_name = os.path.join(folder_path, filename)
            # Lấy phần mở rộng của tệp
            file_extension = os.path.splitext(filename)[1]
            # Tạo tên mới
            new_name = os.path.join(folder_path, f"{prefix}{counter}{file_extension}")

            # Đổi tên tệp
            os.rename(old_name, new_name)

            # In ra tên tệp mới để kiểm tra
            print(f"Renamed {old_name} to {new_name}")

            # Tăng biến đếm
            counter += 1

# Đường dẫn tới thư mục chứa các tệp cần đổi tên
folder_path = r"D:\ENDPBL5\image_train\xoai"  # Sử dụng đường dẫn tuyệt đối và tiền tố r để chỉ định raw string
prefix = "xoai"

# Gọi hàm đổi tên tệp
rename_files(folder_path, prefix)
