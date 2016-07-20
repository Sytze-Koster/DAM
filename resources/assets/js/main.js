$(document).on('ready turbolinks:render', function() {

    $('button').on('click', function() {
        NProgress.start();
    });

    // Auto-size textarea
    $('textarea').each(function() {
        $(this).on('keydown', autosize);
    })

    function autosize(){
      var el = this;
      setTimeout(function(){
        el.style.cssText = 'height:auto; padding:0';
        // for box-sizing other than "content-box" use:
        // el.style.cssText = '-moz-box-sizing:content-box';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
      },0);
    }

    // Tab through dates
    $('.date').on('keydown focus', function(e) {
        var keyCode = e.keyCode || e.which;
        var shiftKey = e.shiftKey;
        var elm = $(this);

        if(e.which == 0) {
            selectDay(elm, e);
        }

        else if (keyCode == 9) {

            if(selected == 'day' && !shiftKey) {
                selectMonth(elm, e)
            } else if(selected == 'day' && shiftKey) {
                selected = '';
            }

            else if(selected == 'month' && !shiftKey) {
                selectYear(elm, e);
            } else if(selected == 'month' && shiftKey) {
                selectDay(elm, e);
            }

            else if(selected == 'year' && !shiftKey) {
                selected = '';
            } else if(selected == 'year' && shiftKey) {
                selectMonth(elm, e);
            }

        }

        function selectDay(elm, e) {
            $(elm)[0].setSelectionRange(0,2);
            selected = 'day';
            e.preventDefault();
        }

        function selectMonth(elm, e) {
            $(elm)[0].setSelectionRange(3,5);
            selected = 'month';
            e.preventDefault();
        }

        function selectYear(elm, e) {
            $(elm)[0].setSelectionRange(6,10);
            selected = 'year';
            e.preventDefault();
        }

    });

    // Set end-date the same as start-date
    $('.start-date').on('focusout', function() {
        $('.end-date').val($(this).val());
    })

    // Tab through times
    $('.time').on('keydown focus', function(e) {
        var keyCode = e.keyCode || e.which;
        var shiftKey = e.shiftKey;
        var elm = $(this);

        if(keyCode == 0) {
            selectHour(elm, e);
        }

        else if (keyCode == 9) {

            if(selected == 'hour' && !shiftKey) {
                selectMinutes(elm, e);
            } else if(selected == 'hour' && shiftKey) {
                selected = ''
            }

            else if(selected == 'minutes' && !shiftKey) {
                selected = '';
            } else if(selected == 'minutes' && shiftKey) {
                selectHour(elm, e);
            }

        }

        function selectHour(elm, e) {
            $(elm)[0].setSelectionRange(0,2);
            selected = 'hour';
            e.preventDefault();
        }

        function selectMinutes(elm, e) {
            $(elm)[0].setSelectionRange(3,5);
            selected = 'minutes';
            e.preventDefault();
        }
    });

    // Leading zero's function
    function pad(n) {
        return (n < 10) ? ("0" + n) : n;
    }

    // Timer(s) dashboard
    $('p.timer').each(function() {
        var datetime = new Date($(this).data('start'));
        var elm = $(this);

        function countdown() {
            var now = new Date();

            seconds = Math.floor((now - (datetime))/1000);
            minutes = Math.floor(seconds/60);
            hours = Math.floor(minutes/60);

            hours = hours;
            minutes = minutes-(hours*60);
            seconds = seconds-(hours*60*60)-(minutes*60);

            $(elm).html(pad(hours)+':'+pad(minutes)+':'+pad(seconds));
        }

        setInterval(countdown, 1000);
    });

    // Stop timer
    $('.stop-timer').on('click', function() {
        var form = $('form#timesheet-'+$(this).data('timesheetId'));
        var date = new Date();
        date.setSeconds(0);
        while(date.getMinutes() % 5) {
            date.setMinutes(date.getMinutes() + 1);
        }
        $(form).find('#end_time').val(pad(date.getHours())+':'+pad(date.getMinutes()));

        setTimeout(function() {
            $(form).find('#description').focus();
        },100)

    });

    $('.flip').on('click', function() {
        $(this).closest('.card').addClass('-flipped');
        return false;
    });


});

function number_format(number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
    var n = !isFinite(+number) ? 0 : +number
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
    var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
    var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
    var s = ''

    var toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec)
      return '' + (Math.round(n * k) / k)
        .toFixed(prec)
    }

    // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || ''
      s[1] += new Array(prec - s[1].length + 1).join('0')
    }

    return s.join(dec)
}
