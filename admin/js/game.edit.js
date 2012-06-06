$(document).ready(function() {
    $("#saveButton").live('click', function() {
        var gameId = $("#gameId").val();
        var firstScore = $(".first").val();
        var secondScore = $(".second").val();
        var tournamentId = $("#tournamentId").val();
        window.location.replace(window.location.pathname + "?action=edittournament&game=" +
            gameId + "&first=" + firstScore + "&second=" + secondScore + "&tourn=" + tournamentId);
        return false;
    });

    $('.first').on('change', function() {
        $('.second').val(2 - $('.first').val());
    });

    $('.second').on('change', function() {
        $('.first').val(2 - $('.second').val());
    });
});