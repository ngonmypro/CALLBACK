function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isThai(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode > 32 && (charCode < 3585 || charCode > 3660)) {
            return false;
        }
        return true;
    }
    
    function isEnglish(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 97 || charCode > 122) && (charCode < 65 || charCode > 90)) {
            return false;
        }
        return true;
    }
    function isThaiEnglish(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 97 || charCode > 122) && (charCode < 65 || charCode > 90) && (charCode < 3585 || charCode > 3660)) {
            return false;
        }
        return true;
    }
    function isNumberEnglish(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 48 || charCode > 57) && (charCode < 97 || charCode > 122) && (charCode < 65 || charCode > 90)) {
            return false;
        }
        return true;
    }
    function isNumberThai(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 44 || charCode > 57) && (charCode < 3585 || charCode > 3660)) {
            return false;
        }
        return true;
    }
    function isEmail(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 46 || charCode > 65)  && (charCode < 94 || charCode > 122) && (charCode < 65 || charCode > 90)) {
            return false;
        }
        return true;
    }

    function isDecimal(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isThaiData(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode > 32 && (charCode < 34 || charCode > 65) && (charCode < 3585 || charCode > 3660) ) {
            return false;
        }
        return true;
    }

    function isEnglishData(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 34 || charCode > 65) && (charCode < 97 || charCode > 122) && (charCode < 65 || charCode > 90)) {
            return false;
        }
        return true;
    }

    function isThaiEnglishMerchant(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 34 || charCode > 65) && (charCode < 97 || charCode > 122) && (charCode < 65 || charCode > 90) && (charCode < 3585 || charCode > 3660) ) {
            return false;
        }
        return true;
    }

    function isAddress(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 44 || charCode > 57)) {
            return false;
        }
        return true;
    }