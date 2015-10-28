var isGlobalDate = function (value, format) {
        return !/Invalid|NaN/.test(dateParseValidate(value, format).toString());
};

var isAlphaNumeric = function (valToCheck) {
    return /^[a-z0-9 \-,\.;'#/:]+$/i.test(valToCheck);
};

var isAlphaNumericSecurityQuestion = function (valToCheck) {
    return /^[a-z0-9 \?\']+$/i.test(valToCheck);
};


var isLengthOfValueLessThanOrEqualTo = function (val, size) {
    if (val.length <= size) {
        return true;
    }
    return false;
};

var isLengthOfValueBetween = function (val, min, max) {
    if (val.length >= min && val.length <= max) {
        return true;
    }
    return false;
};

var isBlank = function (valToCheck) {
    return (trim(valToCheck).length < 1);
};

var isNotBlank = function (valToCheck) {
    return !isBlank(valToCheck);
};

// Validation functions for numerical data.
function isDigits(str) {
    for (i = 0; i < str.length; i++) {
        mychar = str.charAt(i);
        if (mychar < "0" || mychar > "9")
            return false;
    }
    return true;
}

function isNumber(str) {
    numdecs = 0;
    for (i = 0; i < str.length; i++) {
        mychar = str.charAt(i);
        if ((mychar >= "0" && mychar <= "9") || mychar
            == ".") {
            if (mychar == ".")
                numdecs++;
        }
        else
            return false;
    }
    if (numdecs > 1)
        return false;
    return true;
}

function isFirstName(str) {
    return str.match(/^[a-zA-Z][A-zA-Z0-9.'][a-zA-Z0-9,'\-. ;_]*$/)
}

function isLastName(str) {
    return str.match(/^[a-zA-Z][A-zA-Z0-9.'][a-zA-Z0-9,'\-. ;_]*$/);
}

function trim(str) {
    var str = str.replace(/^\s\s*/, ''), ws = /\s/, i = str.length;
    while (ws.test(str.charAt(--i)));
    return str.slice(0, i + 1);
}

function ofwPostalCode(postal_code, country) {
    var countryCode = country.val();
    var regex =  POSTAL_CODE_REGEX[countryCode];
    return postal_code.match(regex);
}

var POSTAL_CODE_REGEX = {
    'US': /^\d{5}(?:[-\s]\d{4})?$/,
    'GB': /^(GIR|[A-Z]\d[A-Z\d]??|[A-Z]{2}\d[A-Z\d]??)[ ]??(\d[A-Z]{2})$/,
    'CA': /^[a-zA-Z0-9]{3}\s*[a-zA-Z0-9]{3}$/,
    'FR': /^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$/,
    'DE': /\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b/,
    'IT': /^(V-|I-)?[0-9]{5}$/,
    'ES': /^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/,
    'MX': /^\d{5}$/
};

//    "DE"=>"\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b",
//    "CA"=>"^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$",
//    "FR"=>"^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$",
//    "IT"=>"^(V-|I-)?[0-9]{5}$",
//    "AU"=>"^(0[289][0-9]{2})|([1345689][0-9]{3})|(2[0-8][0-9]{2})|(290[0-9])|(291[0-4])|(7[0-4][0-9]{2})|(7[8-9][0-9]{2})$",
//    "NL"=>"^[1-9][0-9]{3}\s?([a-zA-Z]{2})?$",
//    "ES"=>"^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$",
//    "DK"=>"^([D-d][K-k])?( |-)?[1-9]{1}[0-9]{3}$",
//    "SE"=>"^(s-|S-){0,1}[0-9]{3}\s?[0-9]{2}$",
//    "BE"=>"^[1-9]{1}[0-9]{3}$",
//    "IN"=>"^\d{6}$"

function dateParseValidate(dtstring, format){

    var parts = dtstring.split('/');
    var month;
    var day;
    var year;

    if (format.indexOf("dd") == 0) {

        // uk dd/mm/yyyy
        day = parts[0];
        month = parts[1] - 1;
        year = parts[2];


    } else {

        // just assume mm/dd/yyyy
        day = parts[1];
        month = parts[0] - 1;
        year = parts[2];
    }

    return new Date(year, month, day)
}
