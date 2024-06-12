import cv2
import argparse
import numpy as np
from collections import Counter

from ultralytics import YOLO
import supervision as sv

import requests
import time
ZONE_POLYGON = np.array([
    [0, 0],
    [0.374, 0],
    [0.374, 0.445],
    [0, 0.445]
])
def parse_arguments() -> argparse.Namespace:
    parser = argparse.ArgumentParser(description="YOLOv8 live")
    parser.add_argument("--webcam-resolution", default=[1280, 720], nargs=2, type=int)
    args = parser.parse_args()
    return args
def send_results_to_server(object_name):
    server_url = "https://server-1-c9nx.onrender.com/fruits/receive_fruits"
    
    data_to_send = {
        "name": object_name,
        #"weight": 10
    }

    try:
        response = requests.post(server_url, json=data_to_send)
        response.raise_for_status()  # Nếu có lỗi trong quá trình gửi yêu cầu, ném một ngoại lệ
        return response.json()  # Trả về dữ liệu nhận được từ server dưới dạng từ điển JSON
    except requests.exceptions.RequestException as e:
        print("Đã xảy ra lỗi trong quá trình gửi yêu cầu:", e)
        return None

def main():
    args = parse_arguments()

    # Đặt kích thước cửa sổ hiển thị
    window_width, window_height = 640, 480

    frame_width, frame_height = args.webcam_resolution

    cap = cv2.VideoCapture('http://192.168.25.211:81/stream')
    cap.set(cv2.CAP_PROP_FRAME_WIDTH, frame_width)
    cap.set(cv2.CAP_PROP_FRAME_HEIGHT, frame_height)

    model = YOLO("best4.pt")

    box_annotator = sv.BoxAnnotator(
        thickness=2,
        text_thickness=2,
        text_scale=1
    )

    zone_polygon = (ZONE_POLYGON * np.array(args.webcam_resolution)).astype(int)
    zone = sv.PolygonZone(polygon=zone_polygon, frame_resolution_wh=tuple(args.webcam_resolution))
    zone_annotator = sv.PolygonZoneAnnotator(
        zone=zone, 
        color=sv.Color.red(),
        thickness=2,
        text_thickness=4,
        text_scale=2
    )

    detecting = True
    detection_count = 0
    detected_objects = []
    detections = None

    while True:
        ret, frame = cap.read()
        result = model(frame, agnostic_nms=True)[0]
        detections = sv.Detections.from_yolov8(result)
        if detecting:
            labels = [
                f"{model.model.names[class_id]} {confidence:0.2f}"
                for _, confidence, class_id, _
                in detections
            ]
            frame = box_annotator.annotate(
                scene=frame, 
                detections=detections, 
                labels=labels
            )
            if len(detections) > 0:
                for _, _, class_id, _ in detections:
                    detected_objects.append(model.model.names[class_id])
                detection_count += 1
                if detection_count == 35:
                    detecting = False
                    most_common_object = Counter(detected_objects).most_common(1)[0][0]
                    # print("Dữ liệu gửi lên server:", most_common_object)

                    server_response = send_results_to_server(most_common_object)
                    if server_response is not None:
                        print("Dữ liệu gửi lên server:", most_common_object)
                        print("Dữ liệu nhận được từ server:", server_response)
                    else:
                        print("Không nhận được phản hồi từ server.")
                    time.sleep(5)
      
        if detections is not None:
            zone.trigger(detections=detections)
        frame = zone_annotator.annotate(scene=frame)

        # Thay đổi kích thước khung hình trước khi hiển thị
        frame_resized = cv2.resize(frame, (window_width, window_height))

        cv2.imshow("yolov8", frame_resized)
        if len(detections)<1:
            detecting = True
            detection_count = 0
            detected_objects = []

        key = cv2.waitKey(1)
        if key == ord('q'):
            break
        # elif key == ord('s'):
        #     if not detecting:  # Bật chế độ nhận diện khi chưa nhận diện
        #         detecting = True
        #         detection_count = 0
        #         detected_objects = []q

    cap.release()
    cv2.destroyAllWindows()

if __name__ == "__main__":
    main()

