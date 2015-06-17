function fillVak() {

    var url;
    url = "getVak.php?perceelID=" + $( "#perceel" ).val();
    console.log($( "#perceel" ).val());
    $.ajax({url: url , success: function(result){
        $("#vak").html(result);
    }});
}

$('.date').datepicker({
    format: "dd-mm-yyyy",
    todayBtn: "linked",
    language: "nl"
});

function fillVakVerzaaid() {

    var url;
    url = "getVakVerzaaid.php?perceelID=" + $( "#perceel" ).val();
    console.log($( "#perceel" ).val());
    $.ajax({url: url , success: function(result){
        $("#vak").html(result);
    }});
}

$('.date').datepicker({
});

function fillBoot() {

    var url;
    url = "getBoot.php?bedrijfID=" + $( "#bedrijf" ).val();
    console.log($( "#boot" ).val());
    $.ajax({url: url , success: function(result){
        $("#boot").html(result);
    }});
}