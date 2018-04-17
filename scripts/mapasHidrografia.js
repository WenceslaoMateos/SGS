/*---------------MAPAS DE HIDROGRAFIA NAVAL-----------------------------------------------------------------*/        
var hidroArg = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/Arg/{z}/{x}/{-y}.png',
    }),
  });

  var hidroAnt = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/Ant/{z}/{x}/{-y}.png',
    }),
  });

  var hidroUru = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/Ur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBsAs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/BsAs/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaChu = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/StaChu/{z}/{x}/{-y}.png',
    }),
  });

  var hidroSta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/Sta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroCaleta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/Caleta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaSur = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/StaSur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroTDF = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/TDF/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBahiaUs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/BahiaUs/{z}/{x}/{-y}.png',
    }),
  });

  var hidroNamuncura = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './Mapas/Namuncura/{z}/{x}/{-y}.png',
    }),
  });      
/*---------------FIN MAPAS DE HIDROGRAFIA NAVAL-------------------------------------------------------------*/        