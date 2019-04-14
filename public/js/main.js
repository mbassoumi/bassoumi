$(document).ajaxStart(function () {
    // if (!$(".htAutocomplete").length) {
    showBlockUI();

    // }
});

$(document).ajaxStop(function () {
    $.unblockUI();
});

$(document).ready(function () {
    initElements();
});

function initElements() {
    // $(document).on('click', '.daterange', function() {
    //     // $.blockUI();
    //     // showBlockUI();
    //     alert('yahooo');
    //     // $(this).modal('show')
    // });
    // $('input[class=".daterange"]').daterangepicker({
    handleDateRange();
}

function handleDateRange() {
    console.log('ahaaa');
    $(".daterange").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        opens: 'left'
    });

    $(".daterange").on('apply.daterangepicker', function (ev, picker) {
        var value = [];
        value['from_date'] = picker.startDate.format('YYYY-MM-DD');
        value['to_date'] = picker.endDate.format('YYYY-MM-DD');
        // console.log(value);
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        // $(this).val(value);
        console.log($(this).val());
        console.log(getDateRangeValueAsArray($(this).val()));
    });

    $(".daterange").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
}

function getDateRangeValueAsArray(value) {
    var arrVal = value.split(' - ');
    return {
        'from': arrVal[0],
        'to': arrVal[1],
    }
}


function showBlockUI() {
    $.blockUI({
        // message: '<i class="fa fa-spinner fa-5x" aria-hidden="true"></i>\n',
        message: '<i class="fa fa-spinner fa-spin fa-3x"></i>\n',
        // message: '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>\n' +
        //     '<span class="sr-only">Loading...</span>',
        overlayCSS: {
            backgroundColor: '#1B2024',
            opacity: 0.85,
            cursor: 'wait',
            'z-index': 99998
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none',
            color: '#fff',
            'z-index': 99999
        },
        timeout: 3000000, // Since the default timeout is little, so I override it with 30 seconds, if the loader takes less than 30 seconds, onِAjaxStop will call unblockUI.

    });
}


