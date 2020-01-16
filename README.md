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

#### Teacher 
*Note: The teacher already needs an account in the database, as creating an account is not available. Creating an account with a hashed password is done with [php_root/pages/signup.php](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/php_root_final/pages/signup.php)*

**1.** Teacher logs in on page [php_root/loginPage.php](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/php_root_final/loginPage.php) and after verifying credentials he is redirected to [php_root/pages/logged.php](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/php_root_final/pages/logged.php).

**2.** Teaches uploads a table of students as a photo with 5 columns (id, NUME, PRENUME, PROBA, SALA). This photo is now available to all student on a dashboard page [php_root/dashboard.php](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/php_root_final/dashboard.php). The photo is uploaded in a folder with the **username of the teacher's account** with the name given by the date and hour it is uploaded at.

#### Verifier

**1.** Verifier runs [listaStud.sh](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/listaStud.sh) which copies the photo of the table from the specified folder to the current one (**__the name of the directory from where you are reading the table must be changed in the script__**). The name of the file is "tabel".
Tesseract is run on the table and output is redirected to a file named lista_studenti.txt.
*Note: lista_studenti.txt contains the names of the students that should be present at the exam*

**2.** [face_recog.py](https://github.com/awfulwaffle77/ExamQuickAttendance/blob/master/face_recog.py) is run. This will check the directory given at the beginning of the script (named mainDir, which must be changed accordingly) for pictures of ID Cards of registered students. This script will create a file named *studenti_prezenti.txt* which updates when someone is recognized in front of the camera. Check the script for comments.
*mainDir is the path of the directory that contains the pictures of known students.*

*Note: studenti_prezenti.txt is a file that contains the name of the students that came in front of the camera and, compared with existing photos from their IDs, if matching, their names are written here.*

**3.** [scriptGreen](https://github.com/awfulwaffle77/ExamQuickAttendance/edit/master/scriptGreen.cpp) is run. After reading *lista_studenti.txt* and storing its data in a struct named Student, it will first print the names of all the students that need to be present at the exam. Then it will then check the file *studenti_prezenti.txt* for names that are the same. If a name equality is found, then it will print over the existing content, the name that is found, in a distinct color. The checking is done once a second ```sleep(1)``` due to conflicts with the file(student_prezenti.txt) accessed by both this script and face_recog.py.

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
