/*---------------MAPAS DE HIDROGRAFIA NAVAL-----------------------------------------------------------------*/        
var hidroArg = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/Arg/{z}/{x}/{-y}.png',
    }),
  });

  var hidroAnt = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/Ant/{z}/{x}/{-y}.png',
    }),
  });

  var hidroUru = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/Ur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBsAs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/BsAs/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaChu = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/StaChu/{z}/{x}/{-y}.png',
    }),
  });

  var hidroSta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/Sta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroCaleta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/Caleta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaSur = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/StaSur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroTDF = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/TDF/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBahiaUs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/BahiaUs/{z}/{x}/{-y}.png',
    }),
  });

  var hidroNamuncura = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/CursoPHP/TrabajoFInal/TrabajoFinalPHP/Mapas/Namuncura/{z}/{x}/{-y}.png',
    }),
  });      
/*---------------FIN MAPAS DE HIDROGRAFIA NAVAL-------------------------------------------------------------*/        