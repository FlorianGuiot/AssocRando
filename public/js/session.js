function ShowPlaces(){

    $("#idSession").on("change", function(event){
        var placesRestantes = $(this).find(":selected").data('placesr');
        var placesTotaltes = $(this).find(":selected").data('placest');
        $('#places').html(placesRestantes + " / " + placesTotaltes);

    });
    
}