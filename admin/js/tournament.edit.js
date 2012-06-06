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

function submitAddTour() {
    var currentTourIndex = $("#tourIndex").val();
    window.location.replace(getCurrentURL() + "&addtour=1");
}

function setAvailabilityForSwissSystem() {
    var participantsCount = $("#players tr").length - 1;
    if (participantsCount % 2 == 1) {
        $("#generateTours").attr('disabled', 'disabled');
    } else {
        $("#generateTours").removeAttr('disabled', 'disabled');
    }
}

function submitAddGame(tourId) {
    var firstParticipantId = $("#firstParticipant").val();
    var secondParticipantId = $("#secondParticipant").val();
    if (!firstParticipantId || !secondParticipantId || firstParticipantId == secondParticipantId) {
        return;
    }
    window.location.replace(getCurrentURL() + "&addgame=" + tourId + "-" + firstParticipantId + "-" + secondParticipantId);
}

$(document).ready(function () {
    $("#listOfUsers").on('change', function () {
        submitAddPlayer()
    });

    $("#generateTours").on('click', function () {
        submitGenerateTours();
    });

    $("#closeTour").on('click', function () {
        submitCloseTour();
    });

    $("#addTour").on('click', function () {
        submitAddTour();
    });

    $("#toursType").on('change', function () {
        if ($("#toursType").val() == 0) {
            setAvailabilityForSwissSystem();
        }
        if ($("#toursType").val() == 1) {
            $("#generateTours").removeAttr('disabled', 'disabled');
        }
    });

    if ($("#toursType").val() == 0) {
        setAvailabilityForSwissSystem();
    }

    $(".addGameLink").on('click', function () {
        $(this).addClass("selected").parent().append($("#addGamePopup"));
        $(".pop").slideFadeToggle(function () {
            $("#remark").focus();
        });
        return false;
    });

    $(".closeAddGame").on('click', function () {
        $(".pop").slideFadeToggle(function () {
            $(".addGameLink").removeClass("selected");
        });
        return false;
    });

    $("#addGame").on('click', function () {
        var tourId = $(this).parents('.addMatchDiv').siblings('.tourId').val();
        submitAddGame(tourId);
        return false;
    })
});

$.fn.slideFadeToggle = function (easing, callback) {
    return this.animate({ opacity:'toggle', height:'toggle' }, "fast", easing, callback);
};
