from flask import Flask, Response, request, jsonify, render_template_string
from picamera2 import Picamera2
from picamera2.encoders import JpegEncoder
from picamera2.outputs import FileOutput
from PIL import Image, ImageDraw, ImageFont
from threading import Condition
import io
import threading

app = Flask(__name__)
picam2 = Picamera2()
message = "Welcome to Dobot Control Panel!"
picam2.configure(picam2.create_video_configuration(main={"size": (640,480), "format": "RGB888"}))
picam2.start()
class StreamingOutput(io.BufferedIOBase):
    def __init__(self):
        self.frame = None
        self.condition = Condition()

    def write(self, buf):
        with self.condition:
            self.frame = buf
            self.condition.notify_all()

def generate_stream():
    global message
    global picam2
    output = StreamingOutput()
    #picam2.configure(picam2.create_video_configuration(main={"size": (640,480), "format": "RGB888"}))
    #picam2.start_recording(JpegEncoder(),FileOutput(output))
    #picam2.start()
    while True:
        frame = picam2.capture_array()
        img = Image.fromarray(frame)
        draw = ImageDraw.Draw(img)
        font = ImageFont.load_default()

        # Desenează mesajul pe imagine
        #text_size = get_text_dimensions(message, font=font)
        text_position = (10, 450)
        #draw.rectangle((text_position[0] - 5, text_position[1] - 5, text_position[0] + text_size[0] + 5, text_position[1] + text_size[1] + 5), fill=(255, 255, 255, 127))
        text_box = draw.textbbox(text_position,message, font)
        draw.rectangle((text_box[0]-5,text_box[1]-5,text_box[2]+5,text_box[3]+5),fill=(255,255,255,127))
        draw.text(text_position, message, font=font, fill=(0, 0, 0))

        # Convertim imaginea în MJPEG
        with io.BytesIO() as output:
            img.save(output, format="JPEG")
            frame_data = output.getvalue()

        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame_data + b'\r\n')

@app.route('/video_feed')
def video_feed():
    return Response(generate_stream(),
                    mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/set_message', methods=['POST'])
def set_message():
    global message
    new_message = request.json.get('message')
    if new_message:
        message = new_message
        return jsonify({"status": "success"}), 200
    else:
        return jsonify({"status": "failure", "reason": "No message provided"}), 400

@app.route('/')
def index():
    return render_template_string('''
    <html>
    <body>
        <img src="/video_feed">
    </body>
    </html>
    ''')

if __name__ == '__main__':
    threading.Thread(target=lambda: app.run(host='0.0.0.0', port=8000, threaded=True, use_reloader=False)).start()

