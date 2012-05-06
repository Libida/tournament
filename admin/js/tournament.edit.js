function getCurrentURL() {
    var tournamentId = $("#tournId").val();
    return window.location.pathname + "?action=edittournament" + "&tourn=" + tournamentId;
}

function submitAddPlayer() {
    var newUserId = $("#listOfUsers").val();
    window.location.replace(getCurrentURL() + "&addplayer=" + newUserId);
}

function submitGenerateTours() {
    var winnersCount = $("#winnersCount").val();
    var toursType = $("#toursType").val();
    window.location.replace(getCurrentURL() + "&generatetours=" + winnersCount + "&type=" + toursType);

}

function submitCloseTour() {
    var currentTourIndex = $("#tourIndex").val();
    window.location.replace(getCurrentURL() + "&closetour=" + currentTourIndex);
}

function setSubmitToStartAvailabilityForSwissSystem() {
    var participantsCount = $("tr").length - 1;
    if (participantsCount % 2 == 1) {
        $("#generateTours").attr('disabled', 'disabled');
    } else {
        $("#generateTours").removeAttr('disabled', 'disabled');
    }
}
$(document).ready(function () {
    $("#listOfUsers").live('change', function () {
        submitAddPlayer()
    });

    $("#generateTours").live('click', function () {
        submitGenerateTours();
    });

    $("#closeTour").live('click', function () {
        submitCloseTour();
    });
    $("#toursType").live('change', function () {
        if ($("#toursType").val() == 0) {
            setSubmitToStartAvailabilityForSwissSystem();
        }
        if ($("#toursType").val() == 1) {
            $("#generateTours").removeAttr('disabled', 'disabled');
        }
    });
    if ($("#toursType").val() == 0) {
        setSubmitToStartAvailabilityForSwissSystem();
    }
});