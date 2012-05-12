var selectedCriteria = "";
var selectedCriteriaToDisplay = "";

function hideSelectedCriteria() {
    $("#selectedCriteriaDiv").css('display', 'none');
}

function showSelectedCriteria() {
    $("#selectedCriteriaDiv").css('display', 'block');
    $("#selectedCriteriaText").html(selectedCriteriaToDisplay);
}

function addSelectedCriteria(value) {
    if (selectedCriteria) {
        selectedCriteria += ',' + value;
    } else {
        selectedCriteria = value;
    }
    recreateSelectedCriteriaToDisplay();
}

function removeCriteria(value) {
    if (selectedCriteria == value) {
        selectedCriteria = '';
    }
    selectedCriteria = selectedCriteria.replace(value + ',', '');
    selectedCriteria = selectedCriteria.replace(',' + value, '');
    recreateSelectedCriteriaToDisplay();
}

function recreateSelectedCriteriaToDisplay() {
    selectedCriteriaToDisplay = '';
    var values = selectedCriteria.split(',');
    for (var i = 0; i < values.length; i++) {
        var valueToDisplay = i + 1 + ') ' + getCriteriaValue(values[i]);
        selectedCriteriaToDisplay += valueToDisplay + ' ';
    }
}

function getCriteriaValue(value) {
    var result = '';
    $('.criteria').each(function () {
        if ($(this).val() == value) {
            result = $(this).siblings('label').html().trim();
        }
    });
    return result;
}

$(document).ready(function () {
    selectedCriteria = $("#selectedCriteria").val();
    var values = selectedCriteria.split(',');
    for (var i = 0; i < values.length; i++) {
        $('.criteria').each(function () {
            if ($(this).val() == values[i]) {
                $(this).prop('checked', 'checked');
            }
        });
    }
    recreateSelectedCriteriaToDisplay();

    if (selectedCriteria) {
        showSelectedCriteria();
    } else {
        hideSelectedCriteria();
    }

    $(".criteria").on('click', function () {
        var checked = $(this).attr('checked');
        var value = $(this).val();
        if (checked) {
            addSelectedCriteria(value);
        } else {
            removeCriteria(value);
        }
        if (selectedCriteria) {
            showSelectedCriteria();
        } else {
            hideSelectedCriteria();
        }
        $("#selectedCriteria").val(selectedCriteria);
    });
});