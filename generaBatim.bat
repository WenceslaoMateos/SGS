REM grdimage map.tmp -B1 -Bz1000+l"cosito" -BWSneZ+b+tmapitachoto -R-58/-56/-39/-37/-100/100 -JM5i -JZ6i -p200/30 -P > map.ps
REM grdimage map.tmp -B1 -Bz1000+l"cosito" -BWSneZ+b+tmapitachoto -R-58/-56/-39/-37 -JM7i -P > map.ps
REM grdview map.tmp -B1 -Bz1000+l"cosito" -BWSneZ+b+tmapitachoto -JM8.5i -Qs -JZ1i -p70/20 -Csealand.cpt > map.ps
REM grdcut map.tmp -R-58/-56/-39/-37 -Gmap2.tmp

REM -Wc marca las lineas de nivel
REM -B1a2 marca los ejes de coordenada
REM -BWSneZ+b+tmapitachoto Pone el titulo en un lugar y formato determinado
REM -JM7i marca lo que parece la "relación de aspecto"
REM -JZ8i establece que tan marcadas son las profundidades
REM -Qm/s/i : m --> plot mesh, s --> surface, or  i --> image
REM -p#A/#B: #A marca la rotación del grafico y #B lo ensancha o achata

grdview datos\map2.tmp -Wc -B1a2 -BWSneZ+b+tmapitachoto -JM-57/-38/7i -Qs -JZ4i -P -p170/20 -Cseafloor2.cpt > map.ps
psconvert -Tf map.ps
map.pdf
del map.ps  
del gmt.history