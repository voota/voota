<script type="text/javascript">
var bkrHost = (("https:" == document.location.protocol) ? "https://static-ssl." : "http://static.");
document.write(unescape("%3Cscript src='"
+ bkrHost + "blueknow.com/bk-r.js' " + "type='text/javascript'%3E%3C/script%3E"));
</script>

<!-- Blueknow Recommender widget (filled dynamically) -->
<div id="blueknow-widget" style="clear: both;"></div>


<!-- Blueknow Recommender product template (CHANGE ACCORDING TO YOUR NEEDS) -->
<ul>
<li>
  <div id="blueknow-template" class="bk-header">
  <div class="bk-row">
   <div class="bk-img">
    <a href="#url"><img src="#image" alt="#name" title="#name" hspace="0" vspace="0" border="0" /></a>
   </div>
   <div class="bk-name">
    <a href="#url">#name</a>
   </div>
  </div>
  </div>
</li>
</ul>


<!-- Blueknow Recommender widget footer including Powered by Blueknow -->
<div id="blueknow-footer">
  <!-- Powered by Blueknow -->
  <div>
    <div>
   <a href="http://www.blueknow.com" rel="nofollow" style="font-size: 12px; color: #666666; text-decoration:none;">
        <img id="bk-logo" alt="Powered by Blueknow" align="left" width="18" style="border:none; margin-right: 5px;">
             <span style="line-height:17px;">Powered by Blueknow</span>
       </a>
    </div>
  </div>
  <script type="text/javascript">document.getElementById("bk-logo").src = bkrHost + "blueknow.com/logo.png";</script>
</div>

<!-- Blueknow Recommender call -->
<script type="text/javascript">
/* Blueknow Recommender success callback function for rendering recommended items */
function renderItems(items) {
    if (items.length > 0) {
      //there are items to show
      var widget = "";
      //add header
      var header = document.getElementById("blueknow-header");
      widget += header ? header.innerHTML : "";
      //items iteration
      for (var i=0; i < items.length; i++) {
        var item = items[i];
        //get product template and replace item properties
        var template = document.getElementById("blueknow-template").innerHTML;
        try{
        	console.log('recomdation: ', item);
        }
        catch(e){
        } 
        template = template.replace(/#name/g, item.name);
        template = template.replace(/#url/g, item.url);
        template = template.replace(/#image/g, item.image);
        widget += template; //add item to the widget
      }
     //add widget to the page
     document.getElementById("blueknow-widget").innerHTML = widget;
  }//when no items found, widget is not shown
}
/** Blueknow Recommender error callback function */
function processError(message) {
}
/* Create a new Blueknow Recommender instance using your assigned BK number */
var rec = new Blueknow.Recommender("<?php echo sfConfig::get("sf_bknumber_". $sf_user->getCulture()) ?>");
/* Perform Blueknow Recommender call. */
rec.item2item("<?php echo __('Ficha de político')?>", "<?php echo $id?>", { recommendations: 4 });
</script>