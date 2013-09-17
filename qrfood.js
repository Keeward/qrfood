function qrSubmit() {
	window.location='/'+getQRString($('#meal_name').val(), $('#foursquare_id').val(), $('#weight').val(), $('#calories').val(), $('#saturated_fat').val(), $('#unsaturated_fat').val(), $('#sodium').val(), $('#carbohydrates').val(), $('#fiber').val(), $('#sugar').val(), $('#protein').val(),  $('#cholesterol').val());
	return(false);
}

function setQRValues(meal_name, foursquare_id, weight, calories, saturated_fat, unsaturated_fat, sodium, carbohydrates, fiber, sugar, protein, cholesterol){
	$('#meal_name').val(meal_name);
	$('#foursquare_id').val(foursquare_id);
	$('#weight').val(weight);
	$('#calories').val(calories);
	$('#saturated_fat').val(saturated_fat);
	$('#unsaturated_fat').val(unsaturated_fat);
	$('#sodium').val(sodium);
	$('#carbohydrates').val(carbohydrates);
	$('#fiber').val(fiber);
	$('#sugar').val(sugar);
	$('#protein').val(protein);
	$('#cholesterol').val(cholesterol);
}

function getQRString(meal_name, foursquare_id, weight, calories, saturated_fat, unsaturated_fat, sodium, carbohydrates, fiber, sugar, protein, cholesterol){
	tmp = Base64.encode(String.fromCharCode(weight>0&&weight<256?weight:0, calories>0&&calories<256?calories:0, saturated_fat>0&&saturated_fat<256?saturated_fat:0, unsaturated_fat>0&&unsaturated_fat<256?unsaturated_fat:0, sodium>0&&sodium<256?sodium:0, carbohydrates>0&&carbohydrates<256?carbohydrates:0, fiber>0&&fiber<256?fiber:0, sugar>0&&sugar<256?sugar:0, protein>0&&protein<256?protein:0, cholesterol>0&&cholesterol<256?cholesterol:0) + encode_fs(foursquare_id) + Base64._utf8_encode(meal_name));
	return(tmp);
}


function encode_fs(input){
	tmp=''
	if(input.length!=24){
		input='4ac759c9f964a520eab620e3';
	}
	for(i = 0; i<24 ; i+=2){
		tmp+=String.fromCharCode(parseInt(input.substring(i,i+2),16));
	}

	return(tmp)
}


/**
*
*  Base64 encode / decode
*  http://www.webtoolkit.info/
*
**/
var Base64 = {

// private property
_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

// public method for encoding
encode : function (input) {
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;

    //input = Base64._utf8_encode(input);

    while (i < input.length) {

        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);

        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;

        if (isNaN(chr2)) {
            enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
            enc4 = 64;
        }

        output = output +
        this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
        this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

    }

    return output;
},

// public method for decoding
decode : function (input) {
    var output = "";
    var chr1, chr2, chr3;
    var enc1, enc2, enc3, enc4;
    var i = 0;

    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    while (i < input.length) {

        enc1 = this._keyStr.indexOf(input.charAt(i++));
        enc2 = this._keyStr.indexOf(input.charAt(i++));
        enc3 = this._keyStr.indexOf(input.charAt(i++));
        enc4 = this._keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
            output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }

    }

    output = Base64._utf8_decode(output);

    return output;

},

// private method for UTF-8 encoding
_utf8_encode : function (string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";

    for (var n = 0; n < string.length; n++) {

        var c = string.charCodeAt(n);

        if (c < 128) {
            utftext += String.fromCharCode(c);
        }
        else if((c > 127) && (c < 2048)) {
            utftext += String.fromCharCode((c >> 6) | 192);
            utftext += String.fromCharCode((c & 63) | 128);
        }
        else {
            utftext += String.fromCharCode((c >> 12) | 224);
            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
            utftext += String.fromCharCode((c & 63) | 128);
        }

    }

    return utftext;
},

// private method for UTF-8 decoding
_utf8_decode : function (utftext) {
    var string = "";
    var i = 0;
    var c = c1 = c2 = 0;

    while ( i < utftext.length ) {

        c = utftext.charCodeAt(i);

        if (c < 128) {
            string += String.fromCharCode(c);
            i++;
        }
        else if((c > 191) && (c < 224)) {
            c2 = utftext.charCodeAt(i+1);
            string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
            i += 2;
        }
        else {
            c2 = utftext.charCodeAt(i+1);
            c3 = utftext.charCodeAt(i+2);
            string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }

    }

    return string;
}

}
