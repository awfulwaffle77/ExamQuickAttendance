# ExamQuickAttendance
Has an online(.php) platform where teachers can post schedules of their exam, a face recognition script for attendance and a script to show who has to attend and who is present.
*This is nothing more than a school project*

## Initalize stuff
-> Need the database with proffesors
-> Gotta login and update some tables

Note: *Tables should use Calibri text and should be cropped without any white spaces except for the table for best OCR by Tesseract*
## Before running
Set up in listaStud.sh the path from which you are reading the students that are going to be present at the exam.This will make a file named "tabel" in the current directory that will be tesseract-ed.

## How to run
```
./listaStud.sh
python face_recog.py
./scriptGreen
```

Note: *The project does not support live update of directory with ID files.*
