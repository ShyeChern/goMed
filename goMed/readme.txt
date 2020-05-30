***************************************************************************
				goMed
***************************************************************************

goMed contain 3 types of users and allow to do following action

1. Visitor of the website (gomed/index.html)
- Allow to search/view their disease with the disease name
- Allow to search/view their disease with the symptom
- Allow to view the disease detail
- Allow to make a prediagnos of their disease with the symptom
- Allow to view the nearby hospital location in their area.


2. Doctor (gomed/doctor/index.html)
- Login
- Give consultation to the patient
- Add new disease


3. Admin (gomed/admin/index.html)
- Login
- View doctor / Delete doctor
- Add doctor


*** NOTE ***
import gomed.sql into database gomed
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gomed";