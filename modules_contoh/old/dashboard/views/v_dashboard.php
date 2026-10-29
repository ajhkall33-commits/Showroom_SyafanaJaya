<style type="text/css">
	iframe{
		width: 100%; 
		min-height: 80vh;
		border:  0;
	}
</style>
<?php if (isset($dashboard_url) && $dashboard_url): ?>
	<iframe 
		src="<?=$dashboard_url?>"
		allowfullscreen="true"
	></iframe>
<?php else: ?>
	<h2 class="text-danger text-center">Invalid URL (API)</h2>
<?php endif ?>
<!-- <script src="https://pronia.plnindonesiapower.co.id:3060/javascripts/api/tableau-2.min.js"></script>
<script src="https://pronia.plnindonesiapower.co.id/pronia/plugins/jquery-toast-plugin-master/src/jquery.toast.js"></script>
<script src="https://pronia.plnindonesiapower.co.id/pronia/plugins/tableau/js/embedding.js"></script>
<script type="text/javascript" src="https://pronia.plnindonesiapower.co.id/pronia/plugins/tableau/js/tabscale.js"></script>
<script src="https://pronia.plnindonesiapower.co.id/pronia/dist/js/moment.js"></script>
<script type="text/javascript">
function alert_dialog(type,tittle,message) {
    var bg_color={'info': '#ff6849', 'warning': '#ff6849', 'success': '#ff6849','error':'#ff6849'};
    $.toast({
        heading:tittle,
        text: message,
        position: 'top-right',
        loaderBg: bg_color[type],
        icon: type,
        hideAfter: 3500,
        stack: 6
    });
};


const MOBILEPIXELWIDTH = 900;
var viz;
var renderVizFor;
var pixelWidth;			
var oldPixelWidth;
            
function renderViz(deviceType) {
    var width;
    var height; 
    
    switch (deviceType) {
        case "phone":
            //width = pixelWidth-15;		//-scroll bar to perfectly fit viz into screen
            height = 2000;												
            //document.getElementsByClassName("inner")[0].style.margin = "0px";	//getting rid of margin
            
            var currentMargin = document.getElementsByClassName("inner")[0].offsetLeft;
            console.log("currentMargin: "+currentMargin);
            width = $('.inner').width();	//x2 because of offset/margin is set to AUTO (left and right)
            break;
        case "desktop": {			
            height = 1000;
            //document.getElementsByClassName("inner")[0].style.margin = "0 auto";
            
            var currentMargin = (document.getElementsByClassName("inner")[0].offsetLeft)+140;
            console.log("currentMargin: "+currentMargin);
            width = $('.inner').width();	//x2 because of offset/margin is set to AUTO (left and right)	
            break;
        }					
    }			
    document.getElementById("tableauViz").style.width = width+"px";
    document.getElementById("tableauViz").style.height = (height)+"px";
    document.getElementById("publicFooter").style.height =(height)+"px";
    $('#tableauViz').width($('.inner').width());
    

    $.ajax({
        type: "GET",
        dataType: "json",
        cache: false,
        url:'https://pronia.plnindonesiapower.co.id:3000/api/tableau',
        data:{id:null},
        success: function (respond) {
            console.log('lebar '+width);
            try
            {
                var containerDiv = document.getElementById("tableauViz"),
                url = "https://pronia.plnindonesiapower.co.id:3060/trusted/"+respond+"/views/OveralEquivalentEffectiveness/OEEUnit";
                var options = {
                    device: deviceType,                    
                    width: $('.inner').width(),
                    height: height,
                    hideTabs: false,
                    hideToolbar: false,
                    onFirstInteractive: function () {
                        workbook = viz.getWorkbook();
                        activeSheet = workbook.getActiveSheet();
                    }
                };
                viz = new tableau.Viz(tableauViz, url, options);
                renderVizFor = deviceType;
            }
            catch(e)
            {
            }
                        

                    },
        error: function(jqXHR, exception) {
                alert_dialog('xhr_error','Alert',jqXHR);
            }
    });
    
} 
    
    

function initDeviceSpecificViz() {
    pixelWidth = window.innerWidth;
    //console.log("pixelWidth: "+pixelWidth);
    
    if (!viz) {	//if nothing got rendered, yet
    
        if (pixelWidth <= MOBILEPIXELWIDTH) {
            renderVizFor = "phone";	
            renderViz("phone");
        } else {
            renderViz("desktop");
        }
        
    } else { //if a viz already exists					
    
        if (pixelWidth <= MOBILEPIXELWIDTH) { //&& renderVizFor == "desktop") {  
            viz.dispose();// If a viz object exists, delete it.						 
            renderVizFor = "phone";						
            //console.log("renderVizFor: "+renderVizFor);
            
            renderViz("phone");
                
        } else if (pixelWidth > MOBILEPIXELWIDTH) { //&& renderVizFor == "phone") {
            viz.dispose();// If a viz object exists, delete it.	
            renderViz("desktop");
        }
    }
    oldPixelWidth = pixelWidth
}


// var resizeId;
// window.addEventListener('resize', function() {	
//     pixelWidth = window.innerWidth;				
//     // if (pixelWidth <= MOBILEPIXELWIDTH) {
//     // 	document.getElementById("myDebugger").style.color = "#d54857";
//     // } else {
//     // 	document.getElementById("myDebugger").style.color = "white";
//     // }
    
//     clearTimeout(resizeId);
//     resizeId = setTimeout(doneResizing, 500);
    
//     //console.log("pixelWidth: "+pixelWidth);
// });

function doneResizing(){			
console.log("pixelWidth: "+pixelWidth);
console.log("oldPixelWidth: "+oldPixelWidth);
console.log("Math.abs(pixelWidth - oldPixelWidth): "+Math.abs(pixelWidth - oldPixelWidth));
    if (Math.abs(pixelWidth - oldPixelWidth) > 10) { 
        initDeviceSpecificViz();
        // document.getElementById("myDebugger").style.color = "white";
        console.log("Done Resizing with final pixelWidth: "+pixelWidth);
            
    } 
    oldPixelWidth = pixelWidth; 
}

var rtime;
var timeout = false;
var delta = 200;
$(window).resize(function() {
    rtime = new Date();
    if (timeout === false) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
});

let initial_pixel=$( window ).width();
function resizeend() {
    if (new Date() - rtime < delta) {
        setTimeout(resizeend, delta);
    } else {        
        console.log('Done resizing');
        let now_pixel=$( window ).width();
        timeout = false;
        if(initial_pixel!=now_pixel){
            console.log('pixel before/resize pixel (' +$( window ).width()+'/'+initial_pixel+')');
             initDeviceSpecificViz();
             doneResizing();
             initial_pixel=now_pixel;
        }
       
        
    }               
}

$(document).ready(function(){
    initDeviceSpecificViz();
});
</script> -->