//Add comma to numberic text
    function addComma(number) {
        return (number + '').replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
    /*numberic text with comma*/
    $(".comma").each(function () {
        $(this).text($(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
    });
    /*validate numberic*/

    $(document).on("keypress", ".numeric", function (e) {

        var a = [46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57];
        var k = e.which;

        var val = $(this).val();
        var dot = val.indexOf('.');
        var len = val.length;

        if (len >= 16)
            e.preventDefault();

        if (!(a.indexOf(k) >= 0) || (dot > -1 && (k == 46 || len - dot > 2)) ) {
            if (k == 13) {
                $(this).blur();
                e.preventDefault();
                return false;
            }
            else {
                e.preventDefault();
                return false;
            }
        }

    });


    $(document).on('keyup', '.numeric', function (e) {


        var k = e.which;
        if (k >= 37 && k <= 40)
            return;

        var x = $(this).val();
        $(this).val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));


    });

    $(document).on("focusout", ".numeric", function (e) {
        var val = $(this).val().replace(/,/g, "");

        var find = "^0*";

        var re = new RegExp(find, 'g');

        val = val.replace(re, '');

        val = val.replace(/\B(?=(\d{3})+(?!\d))/g, ",")

        var find2 = "^\\.(.)*0$";
        var re2 = new RegExp(find2, 'g');

        val = val.replace(re2, '0');


        var find3 = "^\\.";
        var re3 = new RegExp(find3, 'g');

        val = val.replace(re3, '0.');


        var find4 = "^\\,";
        var re4 = new RegExp(find4, 'g');

        val = val.replace(re4, '');

        if (val == '' || val === undefined)
            val = 0;

        $(this).val(val);

    });
    //Remove comma from text
    function removeComma(text) {
        return text.replace(/,/g, "");
    }
    function removeComma(number) {
        return (number + '').replace(/,/g, "");
    }