(function ($, Drupal) {

  Drupal.behaviors.detectFileExtension = {
    attach: function (context, settings) {

      $('.js-file-extension .file a').each(function(i, obj) {

        var pathToTheme = "/" + Drupal.settings.pathToTheme;

        var pdfSrc = pathToTheme + "/images/icons/application-pdf.png";
        var docSrc = pathToTheme + "/images/icons/x-office-document.png";
        var fileSrc = pathToTheme + "/images/icons/generic.png";

        var file = obj.textContent;
        var extension = file.substr( (file.lastIndexOf('.') +1) );

        switch(extension) {
          case 'pdf':
            $(obj).text("Download PDF");
            $(obj).prepend( "<img class='file__icon' src='" + pdfSrc + "' />" );
            break;
          case 'doc':
          case 'docx':
            $(obj).text("Download DOC");
            $(obj).prepend( "<img class='file__icon' src='" + docSrc + "' />" );
            break;
          default:
            $(obj).text("Download File");
            $(obj).prepend( "<img class='file__icon' src='" + fileSrc + "' />" );
            break;
        }

      });

    }
  };

})(jQuery, Drupal);


