function unionCoordInput() //display union coordinate input form
{
    try {
        unionToSeparatedCoords();

        var x = document.getElementsByClassName("separatedCoordInput");
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById("unionCoordInput").style.display = "table-cell";
        document.getElementById("uciButton").style.display = "none";
        document.getElementById("sciButton").style.display = "table-cell";

        return true;
    }
    catch(err) {
        alert(err);
        return false;
    }
}

function separatedCoordInput() //display seperated coordinate input form
{
    try {
        separatedToUnionCoords();

        var x = document.getElementsByClassName("separatedCoordInput");
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "table-row";
        }
        document.getElementById("unionCoordInput").style.display = "none";
        document.getElementById("sciButton").style.display = "none";
        document.getElementById("uciButton").style.display = "table-cell";

        return true;
    }
    catch(err) {
        alert(err);
        return false;
    }
}

function getSearchCoordinates(buttonname) //get lat- and lon-coordinates and submit distance search
{
    alert("hallo");
    if(document.getElementById("unionCoordInput").style.display == "none") {
        getSeparatedCoords();
    } else {
        separatedToUnionCoords();
    }
    submitbutton(buttonname)
}

function  coordsToFixed(coords) { //short coords to six decimals

    return coords.toFixed(6);

}

function getSeparatedCoords () //get coordinates from seperated coordinate input fields
{
    var lat_hem = document.getElementsByName("lat_hem")[0].value;
    var lon_hem = document.getElementsByName("lon_hem")[0].value;

    var rexDegLat = "d{1,2}";
    var rexDegLon = "d{1,3}";
    var rexMin = "d{1,2}\.d{1,3}";
    var pRexDegLat = document.getElementsByName("lat_deg")[0].value.match(new RegExp(rexDegLat));
    var pRexDegLon = document.getElementsByName("lon_deg")[0].value.match(new RegExp(rexDegLon));
    var pRexMinLat = document.getElementsByName("lat_min")[0].value.match(new RegExp(rexMin));
    var pRexMinLon = document.getElementsByName("lon_min")[0].value.match(new RegExp(rexMin));

    if(pRexDegLat == null || pRexDegLon == null || pRexMinLat == null || pRexMinLon == null) {
        throw "Invalid coordinate0";
    } else {
        var lat_deg = document.getElementsByName("lat_deg")[0].value;
        var lon_deg = document.getElementsByName("lon_deg")[0].value;
        var lon_min = document.getElementsByName("lon_min")[0].value;
        var lat_min = document.getElementsByName("lat_min")[0].value;
    }

    if (isNumeric(lon_deg) && isNumeric(lon_min)) {
        if ((lon_deg >= 0) && (lon_deg < 180) && (lon_min >= 0) && (lon_min < 60)) {
            var lon = lon_deg + lon_min / 60;
            if (lon_hem == 'W') {
                lon = - lon;
            }
            document.getElementsByName("lon")[0].value = "" + coordsToFixed(lon);
        } else {
            throw "Invalid1 coordinate";
        }
    } else {
        throw "Invalid2. coordinate";
    }

    if (isNumeric(lat_deg) && isNumeric(lat_min)) {
        if ((lat_deg >= 0) && (lat_deg < 90) && (lat_min >= 0) && (lat_min < 60)) {
            var lat = lat_deg + lat_min / 60;
            if (lat_hem == 'S') {
                lat = - lat;
            }

            document.getElementsByName("lat")[0].value = "" + coordsToFixed(lat);

        } else {
            throw "Invalid3 coordinate";
        }
    } else {
        throw "Invalid4 coordinate";
    }
}

function unionToSeparatedCoords() //add coordinates from seperated field to union field
{
    var lat_hem = "";
    var lon_hem = "";

    var rexDegLat = "d{1,2}";
    var rexDegLon = "d{1,3}";
    var rexMin = "d{1,2}\.d{1,3}";
    var pRexDegLat = document.getElementsByName("lat_deg")[0].value.match(new RegExp(rexDegLat));
    var pRexDegLon = document.getElementsByName("lon_deg")[0].value.match(new RegExp(rexDegLon));
    var pRexMinLat = document.getElementsByName("lat_min")[0].value.match(new RegExp(rexMin));
    var pRexMinLon = document.getElementsByName("lon_min")[0].value.match(new RegExp(rexMin));

    if(pRexDegLat == null || pRexDegLon == null || pRexMinLat == null || pRexMinLon == null) {
        throw "Invalid coordinate0";
    } else {
        var lat_deg = document.getElementsByName("lat_deg")[0].value;
        var lon_deg = document.getElementsByName("lon_deg")[0].value;
        var lon_min = document.getElementsByName("lon_min")[0].value;
        var lat_min = document.getElementsByName("lat_min")[0].value;
    }

    if (document.getElementsByName("lat_hem")[0].value == "N") {
        lat_hem = "N";
    } else {
        lat_hem = "S";
    }
    if (document.getElementsByName("lon_hem")[0].value == "E") {
        lon_hem = "E";
    } else {
        lon_hem = "W";
    }

    if (isNumeric(lat_deg) && isNumeric(lat_min) && isNumeric(lon_deg) && isNumeric(lon_min)) {
        if ((lat_deg >= 0) && (lat_deg < 90) && (lat_min >= 0) && (lat_min < 60) && (lon_deg >= 0) && (lon_deg < 180) && (lon_min >= 0) && (lon_min < 60)) {
            document.getElementsByName("union_field")[0].value = "" + lat_hem + "" + lat_deg + "°" + checkLength(lat_min,6) + " " + lon_hem + "" + lon_deg + "°" + checkLength(lon_min,6);
        } else {
            throw "Invalid coordinate5";
        }
    } else {
        throw "Invalid coordinate6";
    }
}
function separatedToUnionCoords() //add coordinates from union field to seperated field
{
    var textToCoordinates = coordCal();

    textToCoordinates.calCoords(document.getElementsByName("union_field")[0].value.toUpperCase());
    lat = textToCoordinates.getLat();
    lon = textToCoordinates.getLon();

    if(lat!=null && lon!=null) {

        if (lat < 0) {
            latNS_show = 1;
        } else {
            latNS_show = 0;
        }
        if (lon < 0) {
            lonEW_show = 1;
        } else {
            lonEW_show = 0;
        }

        // [N|S]
        document.getElementsByName("lat_hem")[0].selectedIndex = latNS_show;
        var nLat = parseFloat(lat);
        if(nLat < 0) {
            nLat = -nLat;
        }
        document.getElementsByName("lat_deg")[0].value = Math.floor(nLat);
        var lat_h = (nLat - Math.floor(nLat)) * 60;
        document.getElementsByName("lat_min")[0].value = checkLength(lat_h.toFixed(3),6);

        // [E|W]
        document.getElementsByName("lon_hem")[0].selectedIndex = lonEW_show;
        var nLon = parseFloat(lon);
        if(nLon < 0) {
            nLon = -nLon;
        }
        document.getElementsByName("lon_deg")[0].value = Math.floor(nLon);
        var lon_h = (nLon - Math.floor(nLon)) * 60;
        document.getElementsByName("lon_min")[0].value = checkLength(lon_h.toFixed(3),6);

        document.getElementsByName("lon")[0].value = lon;
        document.getElementsByName("lat")[0].value = lat;
    }
}

function checkLength(cnumber,numberlength) //check length of string and add a zero if needed
{
    cnumber = "" + cnumber;
    for(var i=cnumber.length;i<numberlength; i++){
        cnumber = "0" + cnumber;
    }
    return cnumber;
}

function  checkNumHei(maxheight, number) {
    if (number > maxheight) {
        throw "Invalid coordinate7";
    }
    return number;
}

function isNumeric(n) {
    return !isNaN(n) && isFinite(n);
}

var coordCal = function() {
    return {
        getLat: function () {
            return lat;
        },
        getLon: function () {
            return lon;
        },
        calCoords: function (searchupper) {
            // 1. (N|S|-)[ ]degrees[,][ ](E|W|-)[ ]degrees (d.ddddd°)
            var deg = "\\s*(\\d{1,3}|\\d{1,3}\\.\\d{1,})\\s?°?\\s*"
            var rex = "^\\s*([NS]?|-?)" + deg + "[,]?\\s*([WE]?|-?)" + deg + "\\s*$";
            var result = searchupper.match(new RegExp(rex));
            if (result) {
                lat = checkNumHei(90, parseFloat(result[2]));
                if (result[1] == 'S' || result[1] == '-') {
                    lat = -lat;
                }
                lon = checkNumHei(180, parseFloat(result[4]));
                if (result[3] == 'W' || result[3] == '-') {
                    lon = -lon;
                }
            } else {
                // 2. (N|S)[ ]degrees[°][ ]nn[.nnn]['][ ](E|W)[ ]degrees[°][ ]nnn[.nnn]['] (d° mm.mmm)
                deg = "\\s*(\\d{1,3})\\s?°?\\s*";
                var min = "(\\d{1,2}(\\.\\d{1,})?)\\s?['´`]?";
                var rex_dm = "^\\s*([NS])" + deg + min + "\\s*([WE])" + deg + min + "\\s*$";
                var result = searchupper.match(new RegExp(rex_dm));

                if (result) {
                    checkNumHei(60, result[3]);
                    checkNumHei(60, result[7]);
                    lat = checkNumHei(90, parseInt(result[2])) + parseFloat(result[3] + result[4]) / 60;
                    if (result[1] == 'S') {
                        lat = -lat;
                    }
                    lon = checkNumHei(180, parseInt(result[6])) + parseFloat(result[7] + result[8]) / 60;
                    if (result[5] == 'W') {
                        lon = -lon;
                    }
                } else {
                    // 3. (N|S)[ ]degrees[°][ ]nn[ ]['| ]nn['][ ](E|W)[ ]degrees[°][ ]nn[ ]['| ]nn[''] (dd° mm' ss'')
                    var minsec = "(\\d{1,2})\\s?['´` ]\\s*(\\d{1,2})\\s?['´`]?['´`]?";
                    var rex_dms = "^\\s*([NS])" + deg + minsec + "\\s*([WE])" + deg + minsec + "\\s*$";
                    var result = searchupper.match(new RegExp(rex_dms));

                    if (result) {
                        lat = checkNumHei(90, parseInt(result[2])) + checkNumHei(60, parseInt(result[3])) / 60 + checkNumHei(60, parseInt(result[4])) / 3600;
                        if (result[1] == 'S') {
                            lat = -lat;
                        }
                        lon = checkNumHei(180, parseInt(result[6])) + checkNumHei(60, parseInt(result[7])) / 60 + checkNumHei(60, parseInt(result[8])) / 3600;
                        if (result[5] == 'W') {
                            lon = -lon;
                        }
                    } else {
                        throw "Invalid coordinate8";
                    }
                }
            }
        }
    }
};

