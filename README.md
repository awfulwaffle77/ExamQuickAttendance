# ExamQuickAttendance
Has an online(.php) platform where teachers can post schedules of their exam, a face recognition script for attendance and a script to show who has to attend and who is present.
*This is nothing more than a school project*

## How should this work?
### Step by step tutorial (what happens how)
#### Student
*Note: The files used for Student are located in /opt/lampp/htdocs/site in our project.*
**1.** You open your website ([upload.html](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/upload.html)) and you upload a photo of your ID. 
*Note: [upload.html](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/upload.html) uses [sc.js](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/sc.js), [style.css](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/style.css) for style.* 
**2.** [upload-manager.php](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/upload-manager.php) runs after you click on "Incarcati imaginea" and it saves the uploaded photo in the directory **uploads/** with the name given by the date and hour it is uploaded at.

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
