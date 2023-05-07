import cv2
import numpy as np
import mysql.connector

# Load the YOLO model and configuration files
net = cv2.dnn.readNet('parts.weights', 'parts.cfg')
classes = []
with open('parts.names', 'r') as f:
    classes = [line.strip() for line in f.readlines()]

# Set up the video capture
cap = cv2.VideoCapture('v1.mp4')

# Define the font and color for the bounding boxes
font = cv2.FONT_HERSHEY_PLAIN
colors = np.random.uniform(0, 255, size=(len(classes), 3))

# Set the parameters for the vertical line
line_position = 700  # Adjust the position of the line as needed
line_thickness = 2
line_color = (0, 255, 0)  # Green color

# Establish a connection to the database
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root",
    database="phoenix"
)
cursor = db.cursor()

# Create the 'product' table if it doesn't exist
cursor.execute("CREATE TABLE IF NOT EXISTS product (product_name VARCHAR(255), product_quantity INT)")

# Initialize the object counts, passed_line dictionary, and cooldown_counter dictionary
object_counts = {class_name: 0 for class_name in classes}
passed_line = {class_name: False for class_name in classes}
cooldown_duration = 375  # Adjust the cooldown duration as needed
cooldown_counter = {class_name: 0 for class_name in classes}

# Loop through the frames of the video
while True:
    # Read the frame from the video capture
    ret, frame = cap.read()
    if not ret:
        break

    # Preprocess the frame
    blob = cv2.dnn.blobFromImage(frame, 1 / 255, (416, 416), (0, 0, 0), True, crop=False)

    # Set the input to the network
    net.setInput(blob)

    # Get the detections and draw bounding boxes
    outs = net.forward(net.getUnconnectedOutLayersNames())
    class_ids = []
    confidences = []
    boxes = []
    for out in outs:
        for detection in out:
            scores = detection[5:]
            class_id = np.argmax(scores)
            confidence = scores[class_id]

            if confidence > 0.5:
                # Calculate the bounding box coordinates
                center_x = int(detection[0] * frame.shape[1])
                center_y = int(detection[1] * frame.shape[0])
                w = int(detection[2] * frame.shape[1])
                h = int(detection[3] * frame.shape[0])
                x = int(center_x - w/2)
                y = int(center_y - h/2)

                # Add the detection results to the lists
                class_ids.append(class_id)
                confidences.append(float(confidence))
                boxes.append([x, y, w, h])

                # ...

                # Check if the bounding box passes through the vertical line
                if x <= line_position <= (x + w):
                    if not passed_line[classes[class_id]] and cooldown_counter[classes[class_id]] == 0:
                        object_name = classes[class_id]

                        # Update the object count locally
                        object_counts[object_name] += 1

                        # Update the database by incrementing the existing value by one
                        cursor.execute(
                            "UPDATE product SET product_quantity = product_quantity + 1 WHERE product_name = %s",
                            (object_name,))
                        db.commit()

                        cooldown_counter[object_name] = cooldown_duration
                    passed_line[classes[class_id]] = True
                else:
                    passed_line[classes[class_id]] = False

                # ...

    # Decrease the cooldown counter for each class
    for class_name in classes:
        cooldown_counter[class_name] = max(0, cooldown_counter[class_name] - 1)

    # Apply non-maximum suppression to remove overlapping bounding boxes
    indices = cv2.dnn.NMSBoxes(boxes, confidences, 0.5, 0.4)

    # Draw the final bounding boxes on the frame
    if len(indices) > 0:
        for i in indices.flatten():
            box = boxes[i]
            x, y, w, h = box
            class_id = class_ids[i]
            class_name = classes[class_id]
            color = colors[class_id]
            cv2.rectangle(frame, (x, y), (x+w, y+h), color, 2)
            cv2.putText(frame, class_name, (x, y-5), font, 1, color, 2)

    # Draw the vertical line
    cv2.line(frame, (line_position, 0), (line_position, frame.shape[0]), line_color, line_thickness)

    # Display the object counts
    text_y = 30
    for class_name, count in object_counts.items():
        cv2.putText(frame, "{}: {}".format(class_name, count), (10, text_y), font, 1, (0, 0, 255), 2)
        text_y += 20

    # Show the resulting frame
    cv2.imshow('frame', frame)

    # Exit the loop if the 'q' key is pressed
    if cv2.waitKey(1) == ord('q'):
        break

# Release the video capture and close all windows
cap.release()
cv2.destroyAllWindows()

