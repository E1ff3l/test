 /*
  * Truncate Text
  * v.1.0
  *
  * Guillaume Schaeffer - www.guillaume-schaeffer.fr
  *
  * Adapté de : http://stackoverflow.com/questions/1671621/how-to-get-first-2-lines-or-200-characters-from-p-using-jquery
  */


 $.fn.truncate = function(options) {

        var defaults = {
            length: 300,
            minTrail: 20,
            moreText: "more",
            lessText: "less",
            ellipsisText: "..."
        };

        var options = $.extend(defaults, options);

        return this.each(function() {
            obj = $(this);
            var body = obj.html();
            if (body.length > options.length + options.minTrail) {
                var splitLocation = body.indexOf(' ', options.length);
                if (splitLocation != -1) {
                    // truncate tip
                    var splitLocation = body.indexOf(' ', options.length);
                    var str1 = body.substring(0, splitLocation);
                    var str2 = body.substring(splitLocation, body.length - 1);
                    obj.html(str1 + '<span class="truncate_ellipsis">' + options.ellipsisText +
                        '</span>' + '<span  class="truncate_more">' + str2 + '</span>');
                    obj.find('.truncate_more').css("display", "none");

                    // insert more link
                    obj.append(
                        '<p>' +
                        '<a href="#" class="suite-action">' + options.moreText + '</a>' +
                        '</p>'
                    );
                    var moreLink = $('.suite-action', obj);
                    var moreContent = $('.truncate_more', obj);
                    var ellipsis = $('.truncate_ellipsis', obj);
                    moreLink.click(function() {
                        if (moreLink.text() == options.moreText) {
                            moreContent.toggle('fast');
                            moreLink.text(options.lessText);
                            ellipsis.css("display", "none");
                        } else {
                            moreContent.toggle('fast');
                            moreLink.text(options.moreText);
                            ellipsis.css("display", "inline");
                        }
                        return false;
                    });
                }
            }
        });
    };