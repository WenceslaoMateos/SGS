/*---------------MAPAS DE HIDROGRAFIA NAVAL-----------------------------------------------------------------*/        
var hidroArg = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/Arg/{z}/{x}/{-y}.png',
    }),
  });

  var hidroAnt = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/Ant/{z}/{x}/{-y}.png',
    }),
  });

  var hidroUru = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/Ur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBsAs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/BsAs/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaChu = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/StaChu/{z}/{x}/{-y}.png',
    }),
  });

  var hidroSta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/Sta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroCaleta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/Caleta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaSur = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/StaSur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroTDF = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/TDF/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBahiaUs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/BahiaUs/{z}/{x}/{-y}.png',
    }),
  });

  var hidroNamuncura = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: 'http://localhost/Servidor/Barcos/ProtoMap/Mapas/Namuncura/{z}/{x}/{-y}.png',
    }),
  });      
/*---------------FIN MAPAS DE HIDROGRAFIA NAVAL-------------------------------------------------------------*/        