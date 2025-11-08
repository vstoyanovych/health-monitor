function Confirm(title, msg, $true, $false, $link) { /*change*/
        var $content =  "<div class='dialog-ovelay'>" +
                        "<div class='dialog'><header>" +
                         " <h3> " + title + " </h3> " +
                         "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"12\" viewBox=\"0 0 12 12\" fill=\"none\">\n" +
            "<path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M0.548693 0.548693C0.780283 0.317103 1.15577 0.317103 1.38736 0.548693L6 5.16134L10.6126 0.548693C10.8442 0.317103 11.2197 0.317102 11.4513 0.548693C11.6829 0.780283 11.6829 1.15577 11.4513 1.38736L6.83866 6L11.4513 10.6126C11.6829 10.8442 11.6829 11.2197 11.4513 11.4513C11.2197 11.6829 10.8442 11.6829 10.6126 11.4513L6 6.83866L1.38736 11.4513C1.15577 11.6829 0.780283 11.6829 0.548693 11.4513C0.317102 11.2197 0.317103 10.8442 0.548693 10.6126L5.16134 6L0.548693 1.38736C0.317103 1.15577 0.317102 0.780284 0.548693 0.548693Z\" fill=\"#323338\"/>\n" +
            "</svg>" +
                     "</header>" +
                     "<div class='dialog-msg'>" +
                         " <p> " + msg + " </p> " +
                     "</div>" +
                     "<footer>" +
                         "<div class='controls'>" +
                             " <button class='button button-default cancelAction'><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"19\" height=\"18\" viewBox=\"0 0 19 18\" fill=\"none\">\n" +
            "<path d=\"M14 4.5L5 13.5\" stroke=\"#4B5563\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
            "<path d=\"M5 4.5L14 13.5\" stroke=\"#4B5563\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
            "</svg><span>" + $false + "</span></button> " +
                            " <button class='button button-danger doAction'><span>" + $true + "</span><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"19\" height=\"18\" viewBox=\"0 0 19 18\" fill=\"none\">\n" +
            "<path d=\"M7.25 4.5L11.75 9L7.25 13.5\" stroke=\"white\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
            "</svg></button> " +
                         "</div>" +
                     "</footer>" +
                  "</div>" +
                "</div>";
         $('body').prepend($content);
      $('.doAction').click(function () {
          window.location.assign($link);
        $(this).parents('.dialog-ovelay').fadeOut(500, function () {
          $(this).remove();
        });
      });
$('.cancelAction, header svg').click(function () {
        $(this).parents('.dialog-ovelay').fadeOut(500, function () {
          $(this).remove();
        });
      });
      
   }