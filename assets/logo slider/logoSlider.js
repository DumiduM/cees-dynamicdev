$(window).on('load', function() { 

    var slider_logo = document.getElementById("slider-logo");
    var slider_logo_track = document.getElementById("slider-logo-track");

    // var slider_logo_track_clone  = slider_logo_track.cloneNode(true);
    // var slider_logo_track_clone2  = slider_logo_track.cloneNode(true);

    pos1 = 0;
    mov_val1 = window.innerWidth;
    
    // slider_logo.append(slider_logo_track_clone);

    var s_i = setInterval(slideLogos,10);
      function slideLogos(){

          if (pos1 >= mov_val1){ 
              pos1=0;
            }
          pos1=pos1+0.6;
          slider_logo_track.style.marginLeft = -pos1 + "px";

      }


});
    