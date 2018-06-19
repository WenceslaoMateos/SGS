        
        /**
          *Vector que que contiene los puntos de recorrido del barco.
          */
         var vector = new ol.layer.Vector({
            style: styleFunction
          });
  
          /**
            *Funcion que le da un estilo al vector correspondiente a los barcos.
            */
            var styleFunction = function(feature) {
              var propiedades = feature.getProperties();
              var rotation = (propiedades['angulo'] * Math.PI) / 180;
              if (propiedades['type']==='point' && propiedades['angulo']!= ""){
                style = new ol.style.Style({
                  image: new ol.style.Icon({
                    src: './images/arrow.png',
                    opacity: 1,
                    scale: 0.1,
                    rotateWithView: true,
                    rotation: rotation
                  })
                });
              }
              else{
                style = new ol.style.Style({
                  stroke: new ol.style.Stroke({
                    color: '#777777',
                    width: 2
                  })
                })
              }
            return [style]
          };  
  
          /**
            *1-Hacer un mapa
            *2-Conseguir las pps
            *3-???????????
            *4-profit
            */
            var overlay = new ol.Overlay({
            element: container,
            autoPan: true,
            autoPanAnimation: {duration: 250}
          });
  
          /**
            *Mapa completo con todos sus elementos, los layers se muestran por orden y se superponen uno arriba
            *de otro de izquierda a derecha.
            */
          var map = new ol.Map({
            layers: [openStreetMap, openSeaMapLayer, hidroAnt, hidroArg, hidroUru, hidroNamuncura, hidroBsAs, hidroSta, hidroStaSur, hidroTDF, hidroStaChu, hidroCaleta, hidroBahiaUs, vector],
            target: 'map',
            overlays: [overlay],
            view: new ol.View({
              maxZoom: 18,
              center: ol.proj.transform([8.5550875,53.566916333333], 'EPSG:4326', 'EPSG:3857'),
              zoom: 2
            })
          });
  
          /**
            *Extrae las coordenadas del "field of view" y las retorna en un array.
            */
          function cuadro(){
            var extent = map.getView().calculateExtent(map.getSize());
            var bottomLeft = ol.proj.transform(ol.extent.getBottomLeft(extent),'EPSG:3857', 'EPSG:4326');
            var topRight = ol.proj.transform(ol.extent.getTopRight(extent),'EPSG:3857', 'EPSG:4326');
            var arr = {
              'x1':bottomLeft[0],
              'x2':topRight[0],
              'y2':topRight[1],
              'y1':bottomLeft[1]
            };
            return arr;
          }
  
          /**
            *Cada vez que es llamada busca el "field of view" y vuelve a buscar el source del vector con los 
            *los datos de el/los barcos para que lo vuelva a plotear.
            */
          function changeVector(){
            var cuadrado = cuadro();
            vector.setSource(new ol.source.Vector({
              url: "buscaDatosDB.php?x1=" + cuadrado['x1'] + '&x2=' + cuadrado['x2'] + '&y2=' + cuadrado['y2'] + '&y1=' + cuadrado['y1'],
              format: new ol.format.KML({extractStyles: false})
            }));
            vector.setStyle(styleFunction);
          };
          
          //Al terminar de moverse vuelve a buscar los puntos de los barcos.
          //map.on('moveend', changeVector);
  
          //Es preciso llamarlo una vez por que no reconoce el Style de entrada (problema de openlayer?)
          changeVector();
  
          var container = document.getElementById('popup');
          var content = document.getElementById('popup-content');
          var closer = document.getElementById('popup-closer');
  
          /**
            *Funcion que al hacer click en el closer se cierra en degrade.
            */
          closer.onclick = function(){
            overlay.setPosition(undefined);
            closer.blur();
            return false;
          };
  
          /**
            *Funcion que al seleccionar "that" busca los atributos del "that" y los escribe dentro del popup.
            */
          function hacerCuandoSeleccione(that){
            if (that.selected.length >= 1){
              var geometria = that.selected[0].getGeometry();
              var posicion = geometria.getFirstCoordinate();  
              var propiedades = that.selected[0].getProperties()
              overlay.setPosition(posicion);
              content.innerHTML = "";
              var claves = Object.keys(propiedades);
              claves = claves.filter(item => item != "geometry");
              claves = claves.filter(item => item != "type");
              claves = claves.filter(item => item != "styleUrl");
              claves.forEach(function(clave){
                if (propiedades[clave] != ""){
                  content.innerHTML += clave + ": " + propiedades[clave] + "<br>";
                }
              });
            }
          }
  
          //Al seleccionar un elemento este debe desplegar el popup
          var select = new ol.interaction.Select({condition: ol.events.condition.click});
          map.addInteraction(select);
          select.on('select', hacerCuandoSeleccione, this);
          
  