#!/usr/bin/env ruby

files = [ "www/web/sfReviewPlugin/js/sf_review.js",
          "www/web/sfReviewPlugin/js/jquery.hint.js",
          "www/web/js/jquery.qtip-1.0.min.js",
          "www/web/js/bluff/js-class.js",
          "www/web/js/bluff/excanvas.js",
          "www/web/js/bluff/bluff.js",
          "www/web/js/bluff/custom.js",
          "www/web/js/voota.js",
          "www/web/js/ajaxupload.js" ]

result = files.map{|f| File.read(f)}.join("\n")

File.open("www/web/js/all.js", "w") do |file|
  file.write(result)
end