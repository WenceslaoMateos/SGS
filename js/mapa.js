/**
  *Vector que que contiene los puntos de recorrido del barco.
  */
var vector = new ol.layer.Vector({
  style: styleFunction
});

var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');

/**
  *Funcion que le da un estilo al vector correspondiente a los barcos.
  */
var styleFunction = function (feature) {
  var propiedades = feature.getProperties();
  var rotation = (propiedades['angulo'] * Math.PI) / 180;
  if (propiedades['type'] === 'point' && propiedades['angulo'] != "") {
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
  else {
    style = new ol.style.Style({
      stroke: new ol.style.Stroke({
        color: '#777777',
        width: 4
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
  autoPanAnimation: { duration: 250 }
});

/**
  *Mapa completo con todos sus elementos, los layers se muestran por orden y se superponen uno arriba
  *de otro de izquierda a derecha.
  */
var map = new ol.Map({
  layers: [openStreetMap, openSeaMapLayer, hidroAnt, hidroArg, hidroUru, hidroNamuncura, hidroBsAs, hidroSta, hidroStaSur, hidroTDF, hidroStaChu, hidroCaleta, hidroBahiaUs, vector],
  target: 'map',
  loadTilesWhileAnimating: true,
  overlays: [overlay],
  view: new ol.View({
    maxZoom: 18,
    center: [-6409852, -4571211],
    zoom: 2
  })
});

/**
  *Extrae las coordenadas del "field of view" y las retorna en un array.
  */
function cuadro() {
  var extent = map.getView().calculateExtent(map.getSize());
  var bottomLeft = ol.proj.transform(ol.extent.getBottomLeft(extent), 'EPSG:3857', 'EPSG:4326');
  var topRight = ol.proj.transform(ol.extent.getTopRight(extent), 'EPSG:3857', 'EPSG:4326');
  var arr = {
    'x1': bottomLeft[0],
    'x2': topRight[0],
    'y2': topRight[1],
    'y1': bottomLeft[1]
  };
  return arr;
}

/**
  *Cada vez que es llamada busca el "field of view" y vuelve a buscar el source del vector con los 
  *los datos de el/los barcos para que lo vuelva a plotear.
  */
function changeVector() {
  var cuadrado = cuadro();
  var link = "x1=" + cuadrado['x1'] + '&x2=' + cuadrado['x2'] + '&y2=' + cuadrado['y2'] + '&y1=' + cuadrado['y1'];
  if (campanias != '')
    link += '&campanias=' + campanias;
  if (desde != '')
    link += '&desde=' + desde;
  if (hasta != '')
    link += '&hasta=' + hasta;
  vector.setSource(new ol.source.Vector({
    url: "buscaDatosDB.php?" + link,
    format: new ol.format.KML({ extractStyles: false })
  }));
  vector.setStyle(styleFunction);
};

//Al terminar de moverse vuelve a buscar los puntos de los barcos.
//map.on('moveend', changeVector);
//Es preciso llamarlo una vez por que no reconoce el Style de entrada (problema de openlayer?)
changeVector();

/**
  *Funcion que al hacer click en el closer se cierra en degrade.
  */
closer.onclick = function () {
  //  overlay.setPosition(undefined);
  $("#popup").fadeOut();
  //  closer.blur();
  return false;
}

/**
  *Funcion que al seleccionar "that" busca los atributos del "that" y los escribe dentro del popup.
  */
function hacerCuandoSeleccione(that) {
  if (that.selected.length >= 1) {
    var geometria = that.selected[0].getGeometry();
    var posicion = geometria.getFirstCoordinate();
    var propiedades = that.selected[0].getProperties()
    var aux = "";
    $("#popup").fadeIn();
    overlay.setPosition(posicion);
    content.innerHTML = "";
    var claves = Object.keys(propiedades);
    claves = claves.filter(item => item != "geometry");
    claves = claves.filter(item => item != "id");
    claves = claves.filter(item => item != "campaniaid");
    claves = claves.filter(item => item != "type");
    claves = claves.filter(item => item != "styleUrl");
    if (propiedades.tipo == "batimetria") {
      aux += '<form method="post" enctype="multipart/form-data">';
      aux += '  <input class="d-none" value="' + propiedades.nombre + '" id="batim" name="batim">';
      aux += '  </input>';
      aux += '  <button type="submit" class="btn btn-success">';
      aux += '  Descargar';
      aux += '  </button>';
      aux += '</form>';
    }
    claves = claves.filter(item => item != "tipo");
    claves = claves.filter(item => item != "nombre");
    claves.forEach((clave) => {
      if (propiedades[clave] != "") {
        content.innerHTML += clave + ": " + propiedades[clave] + "<br>";
      }
    });
    content.innerHTML += aux;
  }
}

//Al seleccionar un elemento este debe desplegar el popup
var select = new ol.interaction.Select({ condition: ol.events.condition.click });
map.addInteraction(select);
select.on('select', hacerCuandoSeleccione, this);

//genera una serie de poligonos acordes a las batimetrias guardadas en la base de datos
//ojo que con toda la ruta del path se puede llegar a editar y descargar todos los datos del servidor
function poligono(elementos) {
  elementos.forEach((elem) => {
    var poligono = new ol.geom.Polygon([[
      ol.proj.transform([elem['W'], elem['N']], 'EPSG:4326', 'EPSG:3857'),
      ol.proj.transform([elem['E'], elem['N']], 'EPSG:4326', 'EPSG:3857'),
      ol.proj.transform([elem['E'], elem['S']], 'EPSG:4326', 'EPSG:3857'),
      ol.proj.transform([elem['W'], elem['S']], 'EPSG:4326', 'EPSG:3857'),
      ol.proj.transform([elem['W'], elem['N']], 'EPSG:4326', 'EPSG:3857')
    ]]);
    var poligonoFeature = new ol.Feature(poligono);
    poligonoFeature.setProperties({
      'tipo': 'batimetria',
      'W': elem['W'],
      'E': elem['E'],
      'N': elem['N'],
      'S': elem['S'],
      'nombre': elem['nombre']
    });
    var vectorSourcePoligono = new ol.source.Vector({
      projection: 'EPSG:3857'
    });
    vectorSourcePoligono.addFeature(poligonoFeature);
    var vectorLayerPoligono = new ol.layer.Vector({
      source: vectorSourcePoligono,
      style: [
        new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: 'black',
            width: 1
          }),
          fill: new ol.style.Fill({
            color: 'rgba(0, 0, 255, 0.5)'
          })
        })
      ]
    });
    map.addLayer(vectorLayerPoligono);
  })
}

$(document).ready(function () {
  var i = 0;
  $("#agregar_fecha").on('click', function () {
    i++;
    var aux = i;
    var date = new Date($("#desde").val());
    var desde = " " + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
    date = new Date($("#hasta").val());
    var hasta = " " + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
    $("#filtros_a_aplicar_body").append('<tr id="row_' + i + '"><td><input type="hidden" name="desde[]" value="' + $("#desde").val() + '">Desde: ' + desde + '</td><td><input type="hidden" name="hasta[]" value="' + $("#hasta").val() + '">Hasta: ' + hasta + '</td><td id="button_' + aux + '" class="btn btn-danger">Eliminar</td></tr>');
    $("#filtros_a_aplicar_body").removeClass("d-none");
    $("#filtros_a_aplicar").removeClass("d-none");
    $("#aplicar").removeClass("d-none");
    $("#button_" + aux).on('click', function () {
      $("#row_" + aux).remove();
      if ($("#filtros_a_aplicar_body").children().length == 0) {
        $("#filtros_a_aplicar").addClass("d-none");
        $("#aplicar").addClass("d-none");
      }
    });
  });
  $("#campania_invalida").on('click', function () {
    $("#campania_invalida").fadeOut();
  })
  $("#agregar_camp").on('click', function () {
    if ($("#campania").val() != -1) {
      $("#campania_invalida").fadeOut();
      i++;
      var aux = i;
      $("#filtros_a_aplicar_body").prepend('<tr id="row_' + i + '"><td><input type="hidden" name="campania[]" value="' + $("#campania option:selected").val() + '">' + $("#barco option:selected").text() + '</td><td>' + $("#campania option:selected").text() + '</td><td id="button_' + aux + '" class="btn btn-danger">Eliminar</td></tr>');
      $("#filtros_a_aplicar_head").removeClass("d-none");
      $("#filtros_a_aplicar_body").removeClass("d-none");
      $("#filtros_a_aplicar").removeClass("d-none");
      $("#aplicar").removeClass("d-none");
      $("#button_" + aux).on('click', function () {
        $("#row_" + aux).remove();
        if ($("#filtros_a_aplicar_body").children().length == 0) {
          $("#filtros_a_aplicar").addClass("d-none");
          $("#aplicar").addClass("d-none");
        }
      });
    }
    else {
      $("#campania_invalida").fadeIn();
    }
  });
  $("#aplicar").on('click', changeVector);
  $('#barco').on('change', function () {
    var barco = $(this).val();
    if (barco) {
      $.ajax({
        type: 'POST',
        url: './ajaxData.php',
        data: {
          barco: barco
        },
        success: function (html) {
          $('#campania').html(html);
        }
      });
    }
  });
  $.ajax({
    type: "POST",
    url: 'mapa-buscar-batimetricos.php',
    dataType: 'json',

    success: (obj, textstatus) => {
      poligono(obj);
    }
  });
});

