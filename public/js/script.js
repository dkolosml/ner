/* ner app */
var getButton = $('.get-button');
var dateInput = $('#date');
var date = dateInput.val();
var maxDate = dateInput.val();
var minDate = '1998-01-01';
var codeInput = $('#code');
var code = codeInput.val();
var rCode = 'rCode';
var outputTableBody = $('.output-table>tbody');

$(document).ready(function () {

    $('.get-button').on('click', function () {
        var button = $(this);
        button.blur();
        date = dateInput.val();
        code = codeInput.val();
        getRate();
    });

    $('#date').on('change keyup paste', function () {
        if (dateInput.val() > maxDate) {
            dateInput.val(maxDate)
        }
        if (dateInput.val() < minDate) {
            dateInput.val(minDate)
        }
        if (dateInput.val() === date && codeInput.val() === code) {
            disableButton();
        } else {
            enableButton();
        }
    });

    $('#code').on('change keyup paste', function () {
        if (codeInput.val() === code && dateInput.val() === date) {
            disableButton();
        } else {
            enableButton();
        }
    });

    getRate();

});

function enableButton() {
    getButton.removeClass('btn-success');
    getButton.addClass('btn-primary');
    getButton.removeAttr('disabled');
}

function disableButton() {
    getButton.removeClass('btn-primary');
    getButton.addClass('btn-success');
    getButton.attr('disabled', 'disabled');
}

function getDate() {
    var now = new Date();
    return now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
}

function getRate() {
    getButton.attr('disabled', 'disabled');
    $('#blink').removeClass('hdn');
    date = dateInput.val();
    code = codeInput.val();
    rCode = $('.code-select option:selected').data('r');
    var url = '/get-rates/?date=' + date + ((code !== '0') ? '&code=' + code + '&r=' + rCode : '');
    $.ajax({
        type: "GET",
        dataType: "JSON",
        timeout: 15000,
        url: url,
        success: function (incomes) {
            if (!incomes['rates'] || incomes['rates'].length < 1) {
                outputTableBody.prepend(
                    '<tr>' +
                    '<td>' + incomes['rCode'] + '</td>' +
                    '<td>' + incomes['code'] + '</td>' +
                    '<td colspan="2" class="text-center">' + 'Нет данных' + '</td>' +
                    '</tr>'
                );
            } else {
                $(incomes['rates']).each(function (index, rate) {
                    outputTableBody.prepend(
                        '<tr>' +
                        '<td>' + rate['r030'] + '</td>' +
                        '<td>' + rate['cc'] + '</td>' +
                        '<td>' + rate['txt'] + '</td>' +
                        '<td>' + rate['rate'] + '</td>' +
                        '</tr>'
                    );
                });
            }
            outputTableBody.prepend('<tr><td colspan="100" class="text-center">' +
                'Курс НБУ валюты ' + '<strong>' +
                $('.code-select option:selected').text() +
                '</strong>' +
                ' на ' + '<strong>' + incomes['date'] + '</strong>' +
                '<small class="ml-15">' +
                ' from ' + '<strong>' + incomes['source'] + '</strong>' +
                ' given ' + '<strong>' + getDate() + '</strong>' +
                '</small>' +
                '</td></tr>');
            $('#blink').addClass('hdn');
            disableButton();
        },
        error: function () {
            outputTableBody.prepend('<tr><td colspan="100">not given</td></tr>');
        }
    });
}
