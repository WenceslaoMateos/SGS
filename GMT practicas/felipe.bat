ECHO on

set arg1=%1
set arg2=%2

:added by djc for gmt 
SET NETCDF=c:\programs\gmt\lib 
SET GMTHOME=c:\programs\gmt 
SET HOME=c:\programs\gmt\temp 
set GMT_DATADIR=c:\programs\gmt\share\dbase 
SET PATH=%PATH%;%GMTHOME%;%GMTHOME%\bin;%NETCDF% 

$HOME\felipe.exe