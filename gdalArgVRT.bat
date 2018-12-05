REM call "%~dp0\bin\o4w_env.bat"
call "C:\OSGeo4W\bin\o4w_env.bat"
REM Argentina
gdal_translate -of vrt -expand rgba datos\H5001.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\Arg
REM uruguay
gdal_translate -of vrt -expand rgba datos\H101.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\Ur
REM Antartida
gdal_translate -of vrt -expand rgba datos\H6001.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\ant
REM Sur BS as
gdal_translate -of vrt -expand rgba datos\H20001.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\BsAs
REM Santa cruz/chubut
gdal_translate -of vrt -expand rgba datos\H31001.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\StaChu
rem Santa cruz
gdal_translate -of vrt -expand rgba datos\H31701.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\Sta
rem Caleta olivia santa cruz casi chubut
gdal_translate -of vrt -expand rgba datos\H35901.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\Caleta
rem sur santa cruz
gdal_translate -of vrt -expand rgba datos\H41301.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\StaSur
rem norte tierra del fuego
gdal_translate -of vrt -expand rgba datos\H41601.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\TDF
rem bahia usuahia
gdal_translate -of vrt -expand rgba datos\H48001.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\BahiaUs
rem Area namuncura
gdal_translate -of vrt -expand rgba datos\H501401.kap temp\temp.vrt
gdal2tiles temp\temp.vrt mapas\Namuncura
del temp\temp.vrt