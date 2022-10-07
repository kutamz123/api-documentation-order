@echo off
setlocal EnableDelayedExpansion
SET pathreal=%~dp0
SET pathexec=%pathreal:\=/%
for /F "tokens=*" %%i in ('date /t') do set mydate=%%i
java -jar C:/dcmsyst/dcmPacsMpps/server-2.17.1/bin/editmwl.jar -a -f %pathexec%risworklist.xml -u jnp://127.0.0.1:31099 > logrequest.txt 2> logresponse.txt
set /P request=<logrequest.txt
set /P response=<logresponse.txt
cd %pathexec:public/= %
php artisan log:ris-modality %mydate% protocol %request% protocol %response:~0,-25%
exit
