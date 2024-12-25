<h1>Nama: Citra Putrianti - 11210930000110</h1>

<div class="content">
    <div id="map" style="width: 100%; height: 530px; color:black;"></div>
</div>

<script>
    var prov = new L.LayerGroup();
    var faskes = new L.LayerGroup();
    var sungai = new L.LayerGroup();
    var provin = new L.LayerGroup();
    var apart = new L.LayerGroup();
    var kot = new L.LayerGroup();
    var kec = new L.LayerGroup();
    var kel = new L.LayerGroup();
    

    var map = L.map('map', {
        center: [-1.7912604466772375, 116.42311966554416],
        zoom: 5,
        zoomControl: false,
        layers: []
    });
    
	var GoogleSatelliteHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 22,
        attribution: 'Latihan Web GIS'
    }).addTo(map);

	var Esri_NatGeoWorldMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
	maxZoom: 16
	});

	var GoogleMaps = new L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { opacity: 1.0, attribution: 'Latihan Web GIS' 
	});
	
	var GoogleRoads = new L.TileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}',{ opacity: 1.0, attribution: 'Latihan Web GIS' 
	});

	var baseLayers = {
        'Google Satellite Hybrid': GoogleSatelliteHybrid, 
		'Esri_NatGeoWorldMap':Esri_NatGeoWorldMap,
		'GoogleMaps': GoogleMaps,
		'GoogleRoads': GoogleRoads
    };

    var groupedOverlays = {
        "Peta Dasar":{
            'Provinsi' :provin, 
            'Apartment' :apart,
            'Kota' :kot,
            'Kecamatan' :kec,
            'Kelurahan' :kel
        },
        
    };

    L.control.groupedLayers(baseLayers, groupedOverlays).addTo(map);

    var osmUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
    var osmAttrib = 'Map data &copy; OpenStreetMap contributors';
    var osm2 = new L.TileLayer(osmUrl, {
        minZoom: 0,
        maxZoom: 13,
        attribution: osmAttrib
    });
    var rect1 = {
        color: "#ff1100",
        weight: 3
    };
    var rect2 = {
        color: "#0000AA",
        weight: 1,
        opacity: 0,
        fillOpacity: 0
    };
    var miniMap = new L.Control.MiniMap(osm2, {
        toggleDisplay: true,
        position: "bottomright",
        aimingRectOptions: rect1,
        shadowRectOptions: rect2
    }).addTo(map);
    L.Control.geocoder({
        position: "topleft",
        collapsed: true
    }).addTo(map);

    /* GPS enabled geolocation control set to follow the user's location */
    var locateControl = L.control.locate({
        position: "topleft",
        drawCircle: true,
        follow: true,
        setView: true,
        keepCurrentZoomLevel: true,
        markerStyle: {
            weight: 1,
            opacity: 0.8,
            fillOpacity: 0.8
        },
        circleStyle: {
            weight: 1,
            clickable: false
        },
        icon: "fa fa-location-arrow",
        metric: false,
        strings: {
            title: "My location",
            popup: "You are within {distance} {unit} from this point",
            outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
        },
        locateOptions: {
            maxZoom: 18,
            watch: true,
            enableHighAccuracy: true,
            maximumAge: 10000,
            timeout: 10000
        }
    }).addTo(map);

    var zoom_bar = new L.Control.ZoomBar({
        position: 'topleft'
    }).addTo(map);

    L.control.coordinates({
        position: "bottomleft",
        decimals: 2,
        decimalSeperator: ",",
        labelTemplateLat: "Latitude: {y}",
        labelTemplateLng: "Longitude: {x}"
    }).addTo(map);
    /* scala */
    L.control.scale({
        metric: true,
        position: "bottomleft"
    }).addTo(map);

    var north = L.control({
        position: "bottomleft"
    });
    north.onAdd = function(map) {
        var div = L.DomUtil.create("div", "info legend");
        div.innerHTML = '<img src="<?= base_url() ?>assets/arah-mata-angin.png"style=width:200px;>';
        return div;
    }
    north.addTo(map);

    $.getJSON("<?=base_url()?>assets/provinsi.geojson",function(data){
        var ratIcon = L.icon({
            iconUrl: '<?=base_url()?>assets/Marker-1.png',
            iconSize: [12,10]
        });
        L.geoJson(data,{
            pointToLayer: function(feature,latlng){
                var marker = L.marker(latlng,{icon: ratIcon});
                marker.bindPopup(feature.properties.CITY_NAME);
                return marker;
            }
        }).addTo(prov);
    });

    $.getJSON("<?=base_url()?>assets/rsu.geojson",function(data){
        var ratIcon = L.icon({
            iconUrl: '<?=base_url()?>assets/Marker-3.png',
            iconSize: [12,10]
        });
        L.geoJson(data,{
            pointToLayer: function(feature,latlng){
                var marker = L.marker(latlng,{icon: ratIcon});
                marker.bindPopup(feature.properties.NAMOBJ);
                return marker;
            }
        }).addTo(faskes);
    });

    $.getJSON("<?=base_url()?>assets/poliklinik.geojson",function(data){
        var ratIcon = L.icon({
            iconUrl: '<?=base_url()?>assets/Marker-4.png',
            iconSize: [12,10]
        });
        L.geoJson(data,{
            pointToLayer: function(feature,latlng){
                var marker = L.marker(latlng,{icon: ratIcon});
                marker.bindPopup(feature.properties.NAMOBJ);
                return marker;
            }
        }).addTo(faskes);
    });

    $.getJSON("<?=base_url()?>assets/puskesmas.geojson",function(data){
        var ratIcon = L.icon({
            iconUrl: '<?=base_url()?>assets/Marker-5.png',
            iconSize: [12,10]
        });
    L.geoJson(data,{
            pointToLayer: function(feature,latlng){
                var marker = L.marker(latlng,{icon: ratIcon});
                marker.bindPopup(feature.properties.NAMOBJ);
                return marker;
            }
        }).addTo(faskes);
    });

    $.getJSON("<?=base_url()?>/assets/sungai.geojson",function(kode){
        L.geoJson( kode, {
        style: function(feature){
            var color,
        kode = feature.properties.kode;
        if ( kode < 2 ) color = "#f2051d";
        else if ( kode > 0 ) color = "#f2051d";
        else color = "#f2051d"; // no data
            return { color: "#999", weight: 5, color: color, fillOpacity: .8 };
        },
        onEachFeature: function( feature, layer ){
                layer.bindPopup
                ()
        } }).addTo(sungai);
    });

    $.getJSON("<?=base_url()?>/assets/Provinsi_Polygon.geojson",function(kode){
        L.geoJson( kode, {
        style: function(feature){
        var fillColor,
            kode = feature.properties.kode;
        if ( kode > 21 ) fillColor = "#006837";
        else if (kode>20) fillColor="#fec44f"
        else if (kode>19) fillColor="#c2e699"
        else if (kode>18) fillColor="#fee0d2"
        else if (kode>17) fillColor="#756bb1"
        else if (kode>16) fillColor="#8c510a"
        else if (kode>15) fillColor="#01665e"
        else if (kode>14) fillColor="#e41a1c"
        else if (kode>13) fillColor="#636363"
        else if (kode>12) fillColor= "#762a83"
        else if (kode>11) fillColor="#1b7837"
        else if (kode>10) fillColor="#d53e4f"
        else if (kode>9) fillColor="#67001f"
        else if (kode>8) fillColor="#c994c7"
        else if (kode>7) fillColor="#fdbb84"
        else if (kode>6) fillColor="#dd1c77"
        else if (kode>5) fillColor="#3182bd"
        else if ( kode > 4 ) fillColor ="#f03b20"
        else if ( kode > 3 ) fillColor = "#31a354";
        else if ( kode > 2 ) fillColor = "#78c679";
        else if ( kode > 1 ) fillColor = "#c2e699";
        else if ( kode > 0 ) fillColor = "#ffffcc";
        else fillColor = "#f7f7f7"; // no data
        return { color: "#999", weight: 1, fillColor: fillColor, fillOpacity: .6 };
    },
    onEachFeature: function( feature, layer ){
        layer.bindPopup(feature.properties.PROV)
        }
    }).addTo(provin);
    });

    $.getJSON("<?= base_url() ?>assets/apartment.geojson", function (data) {
        var ratIcon = L.icon({
            iconUrl: '<?= base_url() ?>assets/Marker-8.png',
            iconSize: [65, 75]
        });

        L.geoJson(data, {
            pointToLayer: function (feature, latlng) {
                var marker = L.marker(latlng, { icon: ratIcon });

                // Periksa apakah properti ada dan tidak kosong
                if (feature.properties) {
                    let popupContent = `
                    <div style="
                        font-family: Arial, sans-serif; 
                        font-size: 14px; 
                        color: #333; 
                        line-height: 1.6; 
                        max-width: 300px; 
                        padding: 15px; 
                        border-radius: 8px; 
                        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); 
                        background-color: #fff;">
                `;

                    // Menambahkan Nama Apartment
                    if (feature.properties.nama_tempat) {
                        popupContent += `
                        <h3 style="
                            font-size: 18px; 
                            margin: 0; 
                            margin-bottom: 10px; 
                            color: #007BFF; 
                            display: flex; 
                            align-items: center;">
                            <i class="fas fa-building" style="margin-right: 8px;"></i>
                            ${feature.properties.nama_tempat}
                        </h3>
                        `;
                    }

                    // Menambahkan Alamat Apartment (Nama Jalan)
                    if (feature.properties.nama_jalan) {
                        popupContent += `
                        <p style="
                            margin: 0; 
                            margin-bottom: 8px;">
                            <strong>Jalan:</strong> ${feature.properties.nama_jalan}
                        </p>
                    `;
                    }

                    // Menambahkan Alamat Apartment (Nama Kelurahan)
                    if (feature.properties.nama_kelurahan) {
                        popupContent += `
                        <p style="
                            margin: 0; 
                            margin-bottom: 8px;">
                            <strong>Kelurahan:</strong> ${feature.properties.nama_kelurahan}
                        </p>
                    `;
                    }

                    // Menambahkan Alamat Apartment (Nama Kecamatan)
                    if (feature.properties.nama_kecamatan) {
                        popupContent += `
                        <p style="
                            margin: 0; 
                            margin-bottom: 8px;">
                            <strong>Kecamatan:</strong> ${feature.properties.nama_kecamatan}
                        </p>
                    `;
                    }

                    // Menambahkan Jumlah Tower
                    if (feature.properties.jumlah_tower) {
                        popupContent += `
                        <p style="
                            margin: 0; 
                            margin-bottom: 8px;">
                            <strong>Jumlah Tower:</strong> ${feature.properties.jumlah_tower}
                        </p>
                    `;
                    }

                    // Menambahkan Jumlah Lantai
                    if (feature.properties.jumlah_lantai) {
                        popupContent += `
                        <p style="
                            margin: 0; 
                            margin-bottom: 8px;">
                            <strong>Jumlah Lantai:</strong> ${feature.properties.jumlah_lantai}
                        </p>
                    `;
                    }

                    // Menambahkan Jumlah Unit
                    if (feature.properties.jumlah_unit) {
                        popupContent += `
                        <p style="
                            margin: 0; 
                            margin-bottom: 8px;">
                            <strong>Jumlah Unit:</strong> ${feature.properties.jumlah_unit}
                        </p>
                    `;
                    }

                    // Menambahkan Jumlah Karyawan
                    if (feature.properties.jumlah_karyawan) {
                        popupContent += `
                        <p style="
                            margin: 0; 
                            margin-bottom: 8px;">
                            <strong>Jumlah Karyawan:</strong> ${feature.properties.jumlah_karyawan}
                        </p>
                    `;
                    }

                    
                    // Menambahkan Foto Apartment
                    if (feature.properties.Dokumentasi) {
                        let imagePath = "<?= base_url() ?>assets/dokumentasi_apartment/" + feature.properties.Dokumentasi;
                        popupContent += `
                        <div style="margin-top: 15px; text-align: center;">
                            <img src="${imagePath}" alt="Foto Apartment" 
                                style="
                                    width: 50%; 
                                    max-width: 250px; 
                                    height: auto; 
                                    border-radius: 5px; 
                                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                        </div>
                    `;
                    } else {
                        popupContent += `
                        <p style="
                            margin-top: 15px; 
                            text-align: center; 
                            font-style: italic; 
                            color: #888;">
                            Foto Apartment tidak tersedia.
                        </p>
                    `;
                    }

                    popupContent += "</div>"; // Menutup div

                    marker.bindPopup(popupContent);
                } else {
                    marker.bindPopup("<div style='font-family: Arial, sans-serif; font-size: 14px; color: #444;'>Data Apartment tidak tersedia.</div>");
                }
                return marker;
            }
        }).addTo(apart);
    });

    $.getJSON("<?= base_url() ?>/assets/layerkota.geojson", function (kode) {
        L.geoJson(kode, {
            style: function (feature) {
                var fillColor,
                    kode = feature.properties.kode;
                if (kode = 1) fillColor = "pink";
                return { color: "fee0d2", weight: 1, fillColor: fillColor, fillOpacity: .6 };
            },
            onEachFeature: function (feature, layer) {
                layer.bindPopup(feature.properties.kot)
            }
        }).addTo(kot);
    });

    $.getJSON("<?= base_url() ?>/assets/layerkecamatan.geojson", function (kode) {
        L.geoJson(kode, {
            style: function (feature) {
                var fillColor,
                    kode = feature.properties.kode;
                if (kode > 7) fillColor = "#006837";
                else if (kode > 6) fillColor = "#fec44f"
                else if (kode > 5) fillColor = "#c2e699"
                else if (kode > 4) fillColor = "#fee0d2"
                else if (kode > 3) fillColor = "#756bb1"
                else if (kode > 2) fillColor = "#8c510a"
                else if (kode > 1) fillColor = "#01665e"
                else if (kode > 0) fillColor = "#01665e"
                return { color: "#999", weight: 1, fillColor: fillColor, fillOpacity: .6 };
            },
            onEachFeature: function (feature, layer) {
                layer.bindPopup(feature.properties.kec)
            }
        }).addTo(kec);
    });

    $.getJSON("<?= base_url() ?>/assets/layerkelurahan.geojson", function (kode) {
        L.geoJson(kode, {
            style: function (feature) {
                var kodeValue = feature.properties.kode; // Ambil nilai kode
                var fillColor;

                // Periksa nilai kode dan tetapkan warna acak
                if (kodeValue >= 1 && kodeValue <= 40) {
                    fillColor = getRandomColor(); // Warna acak untuk kode 1–34
                } else {
                    fillColor = "#cccccc"; // Warna default jika kode di luar rentang
                }

                return {
                    fillColor: fillColor,
                    fillOpacity: 0.7, // Opasitas warna
                    weight: 1,        // Ketebalan garis
                    color: '#000'     // Warna garis border
                };
            }
        }).addTo(kel);
    });

    // Fungsi untuk menghasilkan warna acak
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>