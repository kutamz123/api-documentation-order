@echo off
setlocal EnableDelayedExpansion
SET pathreal=%~dp0
SET pathexec=%pathreal:\=/%
for /F "tokens=*" %%i in ('date /t') do set mydate=%%i
java -jar C:/dcmsyst/dcmPacsMpps/server-2.17.1/bin/editmwl.jar -a -f %pathexec%risworklist.xml -u jnp://127.0.0.1:31099 > logrequest.txt 2> logresponse.txt
SET mytime=%time%
@REM SET /P request=<logrequest.txt
SET /P response=<logresponse.txt
cd %pathexec:public/= %
php artisan log:ris-modality %mydate% %mytime%  protocol %request% protocol %response%
exit
