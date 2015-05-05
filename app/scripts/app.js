(function ()
{
    'use strict';

    //example exercise

    window.app = {

        getDescendingNumbers: function (start, stop)
        {
            if (typeof start !== 'number' || typeof stop !== 'number' || start < stop) {
                return false;
            }
            var descendingNumbers = start;
            for (var i = start - 1; i >= stop; i--) {
                descendingNumbers = descendingNumbers + ' ' + i;
            }
            return descendingNumbers;
        }
    };

})();








