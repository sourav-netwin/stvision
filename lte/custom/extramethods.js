$(document).ready(function(){
    $.fn.validDate = function() {
        var value = $(this[0]).val(); // It's your element
        var check = false,
        re = /^\d{1,2}\/\d{1,2}\/\d{4}$/,
        adata, gg, mm, aaaa, xdata;
        if ( re.test( value ) ) {
            adata = value.split( "/" );
            gg = parseInt( adata[ 0 ], 10 );
            mm = parseInt( adata[ 1 ], 10 );
            aaaa = parseInt( adata[ 2 ], 10 );
            xdata = new Date( Date.UTC( aaaa, mm - 1, gg, 12, 0, 0, 0 ) );
            if ( ( xdata.getUTCFullYear() === aaaa ) && ( xdata.getUTCMonth() === mm - 1 ) && ( xdata.getUTCDate() === gg ) ) {
                check = true;
            } else {
                check = false;
            }
        } else {
            check = false;
        }
        return check;
        //return this; // This is needed so others can keep chaining off of this
    };
});