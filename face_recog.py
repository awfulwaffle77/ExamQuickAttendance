import PyQt5
import face_recognition
from PIL import Image
import cv2
import numpy as np
import os
import pytesseract
import subprocess

mainDir="/home/magikarp/ProjPSO/iknow"

if os.path.exists("studenti_prezenti.txt"):
    os.remove("studenti_prezenti.txt");

studentList = list()

def getListOfFiles(dirName):
    # create a list of file and sub directories 
    # names in the given directory 
    listOfFile = os.listdir(dirName)
    allFiles = list()
    # Iterate over all the entries
    for entry in listOfFile:
        # Create full path
        fullPath = os.path.join(dirName, entry)
        # If entry is a directory then get the list of files in this directory 
        if os.path.isdir(fullPath):
            allFiles = allFiles + getListOfFiles(fullPath)
        else:
            allFiles.append(fullPath)
                
    return allFiles   

pictures=getListOfFiles(mainDir)
print(pictures)


# Get a reference to webcam #0 (the default one)
video_capture = cv2.VideoCapture(0)

known_face_encodings=list()
known_face_names=list()

for face in pictures: # searching in all pictures in the folder
    face_loader=face_recognition.load_image_file(face)
    face_loader_encoding=face_recognition.face_encodings(face_loader)[0]     

    known_face_encodings.append(face_loader_encoding)
    cmd="tesseract -l fra " + face + " - 2> /dev/null | grep IDROU | sed s/IDROU// | sed -E s/\<+/\ /g" # command to extract name
    name = subprocess.check_output(cmd, shell=True)   
    print(str(name.rstrip().decode('UTF-8')))
    if name is None:
        name = "NDEF" # undefined
    known_face_names.append(str(name.rstrip().decode('UTF-8')))

face_locations = []
face_encodings = []
face_names = []
process_this_frame = True

while True:
    
    presentStudents=open("studenti_prezenti.txt","a")
    # Grab a single frame of video
    ret, frame = video_capture.read()

    # Resize frame of video to 1/4 size for faster face recognition processing
    small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)

    # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
    rgb_small_frame = small_frame[:, :, ::-1]

    # Only process every other frame of video to save time
    if process_this_frame:
        # Find all the faces and face encodings in the current frame of video
        face_locations = face_recognition.face_locations(rgb_small_frame)
        face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)

        face_names = []
        for face_encoding in face_encodings:
            # See if the face is a match for the known face(s)
            matches = face_recognition.compare_faces(known_face_encodings, face_encoding)
            name = "Who dat?"
            color = (0,0,255) # red

            # # If a match was found in known_face_encodings, just use the first one.
            # if True in matches:
            #     first_match_index = matches.index(True)
            #     name = known_face_names[first_match_index]
           # Or instead, use the known face with the smallest distance to the new face
            face_distances = face_recognition.face_distance(known_face_encodings, face_encoding)
            best_match_index = np.argmin(face_distances)
            if matches[best_match_index]:
                name = known_face_names[best_match_index]
                color = (0,255,0)
                if name not in studentList:
                    studentList.append(name)
                    print(studentList)
                    presentStudents.write(name + '\n')
                    presentStudents.close()
                    
            face_names.append(name)

    process_this_frame = not process_this_frame


    # Display the results
    for (top, right, bottom, left), name in zip(face_locations, face_names):
        # Scale back up face locations since the frame we detected in was scaled to 1/4 size
        top *= 4
        right *= 4
        bottom *= 4
        left *= 4

        # Draw a box around the face
        cv2.rectangle(frame, (left, top), (right, bottom), color, 2)

        # Draw a label with a name below the face
        #cv2.rectangle(frame, (left, bottom - 35), (right, bottom), color) # green box :)
        #font = cv2.FONT_HERSHEY_DUPLEX
        #cv2.putText(frame, " ", (left + 6, bottom - 6), font, 1.0, (255, 255, 255), 1)

    # Display the resulting image
    cv2.imshow('Video', frame)

    # Hit 'q' on the keyboard to quit!
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# Release handle to the webcam
video_capture.release()
cv2.destroyAllWindows()
