ECHO on
grd2xyz datos31.0_30.0_-19.0_42.0.nc > map.ps
psxyz datos.dat -B1 -Bz1000+l"cosito" -BWSneZ+b+tmapitachoto -R-170/170/-80/80/-6000/0 -JM5i -JZ6i -p200/30 -So0.0833333ub-5000 -P -Wthinnest -Glightgreen > map.ps
gmt psconvert -Tb map.ps
map.bmp