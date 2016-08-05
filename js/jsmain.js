
    function selectserver(servers){
    	document.getElementById("server").value = servers;
    	var aux = servers.toUpperCase();
    	document.getElementById("dropdownMenu1").innerHTML = aux+" "+"<span class='caret'></span>";
    }
    
    function callmaindados(){
            document.getElementById("li2").className = "";
            document.getElementById("li1").className = "";
            document.getElementById("li3").className = "";
            document.getElementById("callrunesdiv").className = "hidden";
            document.getElementById("currentMdiv").className = "hidden";
            document.getElementById("trollpointsdiv").className = "hidden";
            document.getElementById("maindadosdiv").className = "content";
    }
    
        function runepage(runepage,totalrunepages){
            for(var i=0;i<=totalrunepages;i++){
            document.getElementById("runepage"+i).className = "hidden";
            document.getElementById("rp"+i).className = "";
            }
            document.getElementById("runepage"+runepage).className = "content";
            document.getElementById("rp"+runepage).className = "active";
    }
        function callrunes(){
            if(document.getElementById("li2").className != "disabled"){
                document.getElementById("li2").className = "active";
                document.getElementById("li1").className = "";
                document.getElementById("li3").className = "";
                document.getElementById("maindadosdiv").className = "hidden";
                document.getElementById("currentMdiv").className = "hidden";
                document.getElementById("trollpointsdiv").className = "hidden";
                //document.getElementById("span01").innerHTML = "<img src='https://d13yacurqjgara.cloudfront.net/users/82092/screenshots/1073359/spinner.gif'>";
                if( $('#callrunesdiv').is(':empty') ) {
                document.getElementById("callrunesdiv").className = "content";
                document.getElementById("callrunesdiv").innerHTML = " <div class='blobs'> <div class='blob'></div> <div class='blob'></div> </div> <svg><defs><filter id='goo'><feGaussianBlur in='SourceGraphic' result='blur' stdDeviation='10' />	<feColorMatrix in='blur' mode='matrix' values='1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7' result='goo' /><feBlend in2='goo' in='SourceGraphic' result='mix' /></filter></defs></svg> ";
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("callrunesdiv").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","runes.php?id="+id+"&dd="+dd+"&server="+server, true);
                    xmlhttp.send();
                }else{
                document.getElementById("callrunesdiv").className = "content";
                }
            }
        }
    function calltp(){
            if(document.getElementById("li3").className != "disabled"){
                document.getElementById("li3").className = "active";
                document.getElementById("li1").className = "";
                document.getElementById("li2").className = "";
                document.getElementById("maindadosdiv").className = "hidden";
                document.getElementById("currentMdiv").className = "hidden";
                document.getElementById("callrunesdiv").className = "hidden";
                if( $("#trollpointsdiv").is(':empty') ) {
                document.getElementById("trollpointsdiv").className = "content";
                document.getElementById("trollpointsdiv").innerHTML = " <div class='blobs'> <div class='blob'></div> <div class='blob'></div> </div> <svg><defs><filter id='goo'><feGaussianBlur in='SourceGraphic' result='blur' stdDeviation='10' />	<feColorMatrix in='blur' mode='matrix' values='1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7' result='goo' /><feBlend in2='goo' in='SourceGraphic' result='mix' /></filter></defs></svg> ";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("trollpointsdiv").innerHTML = xmlhttp.responseText;
                        countUp();
                    }
                }
                xmlhttp.open("GET","TROLLPOINTS.php?id="+id+"&dd="+dd+"&server="+server, true);
                xmlhttp.send();
    
            }else{
            document.getElementById("trollpointsdiv").className = "content";
    
            }
        }
    }
    function currentM(){
        if(document.getElementById("li1").className != "disabled"){
            document.getElementById("li1").className = "active";
            document.getElementById("li3").className = "";
            document.getElementById("li2").className = "";
            document.getElementById("maindadosdiv").className = "hidden";
            document.getElementById("trollpointsdiv").className = "hidden";
            document.getElementById("callrunesdiv").className = "hidden";
            if( $("#currentMdiv").is(':empty') ) {
                document.getElementById("currentMdiv").className = "content";
                document.getElementById("currentMdiv").innerHTML = " <div class='blobs'> <div class='blob'></div> <div class='blob'></div> </div> <svg><defs><filter id='goo'><feGaussianBlur in='SourceGraphic' result='blur' stdDeviation='10' />	<feColorMatrix in='blur' mode='matrix' values='1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7' result='goo' /><feBlend in2='goo' in='SourceGraphic' result='mix' /></filter></defs></svg> ";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("currentMdiv").innerHTML = xmlhttp.responseText;
                        
                    }
                };
                xmlhttp.open("GET","current_game.php?id="+id+"&dd="+dd+"&server="+server, true);
                xmlhttp.send();
            }else{
                document.getElementById("currentMdiv").className = "content";
            }
        }
    }


//=========================COUNT UP - JQUERY===================================

//$('document').ready(function() {
function countUp(){
    var ceilingLimit = 5000;
    $('.ceilingLimit').text(ceilingLimit)    
    function getRand() {
        return Math.floor(document.getElementById("trollpointsHide").innerHTML) + 1 ;
        //return Math.floor(Math.random() * ceilingLimit) + 1;
    }; 
    var newNum = getRand();
    var oldNum = 0;
    var numcolor = 'gray';
    function doCounter(){
        newNum = getRand();
        numcolor = 'white';
    
        $({
            countNum: $('#trollpoints').text()
        }).animate({
            countNum: newNum
        }, {
            duration: 2000,
            //easing: 'linear',
            easing: 'easeInOutCirc',
            step: function() {
                // What todo on every count
                $('#trollpoints').text(Math.floor(this.countNum));
            },
            complete: function() {
                oldNum = parseInt($('#trollpoints').text());
                $('#trollpoints').animate({
                    'font-size': '8em',
                    'color': numcolor
                },{
                    easing: 'swing',
                    duration: 200,
                    complete: function(){
                        $('#trollpoints').animate({
                            'font-size': '7em',
                            'color': numcolor
                        },{
                            easing: 'easeOutCirc',
                            duration: 1200,
                            complete: function(){ 
                                $('#trollpoints').animate({
                                    'color': 'white'
                                },{
                                duration: 700
                                })
                            }
                            })
                    }
                })
            }
        });             
    };    
    doCounter();    
 
};
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! --- GRAFICO PIZZA --- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

//--------------------------------------
        if(id=="0"){//invoca ps dados das lanes
            }else if(jsondecoded_elo=="404"){
            }else{
                document.getElementById("lanediv").innerHTML = '<div class="col-xs-12 col-md-6 col-lg-6"><p>Loading...</p></div>';
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("lanediv").innerHTML = xmlhttp.responseText;
                        //Inicia o setup do grafico
                    	var options = {
                            responsive:false,
                            maintainAspectRatio:true
                            
                        };
                    
                        var data = [
                            {
                                value: document.getElementById("carry").innerHTML,
                                color:"#bf3737",
                                highlight: "#FF5A5E",
                                label: "Carry"
                            },
                            {
                                value: document.getElementById("support").innerHTML,
                                color: "#875373",
                                highlight: "#c57ba9",
                                label: "Support"
                            },
                            {
                                value: document.getElementById("mid").innerHTML,
                                color: "#b99e59",
                                highlight: "#ffd978",
                                label: "Mid"
                            },
                            {
                                value: document.getElementById("top").innerHTML,
                                color: "#073c63",
                                highlight: "#0c578e",
                                label: "Top"
                            },
                            {
                                value: document.getElementById("jungle").innerHTML,
                                color: "#37715a",
                                highlight: "#53ab88",
                                label: "Jungle"
                            }
                        ]
                        //inicia o grafico
                        setTimeout(createChart, 200);//temporização para criar o grafico (solucao de bug)
                        function createChart(){
                        var ctx = document.getElementById("GraficoPizza").getContext("2d");
                        //ctx.canvas.width = 300;
                        //ctx.canvas.height= 300;
                        var PizzaChart = new Chart(ctx).Pie(data, {responsive: true});//Doughnut
                        }
                    }
                }
                xmlhttp.open("GET","Lane.php?id="+id+"&server="+server, true);
                xmlhttp.send();
            }

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!