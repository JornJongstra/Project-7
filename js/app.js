$(document).ready(function () {
    $('#datatableCustomerSignup').DataTable();
});

    function createOption(value, text) {
        var option = document.createElement('option');
        option.text = text;
        option.value = value;
        return option;
    }

    var hourSelect = document.getElementById('hours');
    for (var i = 17; i <= 21; i++) {
        hourSelect.add(createOption(i, i));
    }

    var minutesSelect = document.getElementById('minutes');
    for (var i = 0; i < 60; i += 15) {
        minutesSelect.add(createOption(i, i));
    }