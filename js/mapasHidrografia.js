/*---------------MAPAS DE HIDROGRAFIA NAVAL-----------------------------------------------------------------*/        
var hidroArg = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/arg/{z}/{x}/{-y}.png',
    }),
  });

  var hidroAnt = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/ant/{z}/{x}/{-y}.png',
    }),
  });

  var hidroUru = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/ur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBsAs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/bsas/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaChu = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/stachu/{z}/{x}/{-y}.png',
    }),
  });

  var hidroSta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/sta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroCaleta = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/caleta/{z}/{x}/{-y}.png',
    }),
  });

  var hidroStaSur = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/stasur/{z}/{x}/{-y}.png',
    }),
  });

  var hidroTDF = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/tdf/{z}/{x}/{-y}.png',
    }),
  });

  var hidroBahiaUs = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/bahiaus/{z}/{x}/{-y}.png',
    }),
  });

  var hidroNamuncura = new ol.layer.Tile({
    source: new ol.source.XYZ({
      url: './mapas/namuncura/{z}/{x}/{-y}.png',
    }),
  });      
/*---------------FIN MAPAS DE HIDROGRAFIA NAVAL-------------------------------------------------------------*/        