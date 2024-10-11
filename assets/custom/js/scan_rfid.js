$(document).ready(function(){

    $('#rfidcard').focus();
          $('body').mousemove(function(){
         var fridcard = $('#rfidcard').focus();
         });
         $('#rfidcard').on('change', function(){
             if($(this).val().length >= 10){
               var frid_number = $('#rfidcard').val();
               console.log(frid_number);

                    var dataString = 'frid_number='+frid_number;
                     $.ajax({
                      url: 'config/init/add_attendance',
                        type: "POST",
                        data:dataString,
                        async: false,
                        cache: false,
                      success: function(response) {
                        $("#mgs-add").html(response);
                        $('#mgs-add').animate({ scrollTop: 0 }, 'slow');
                        },
                        error: function(response) {
                          console.log("Failed");
                        }
                    });

              $(this).val("");
             }
          });

      });