<?php include('Header.php'); ?>
<head>
<script src="js/popover.js"></script>    
<style>
    .popover-title {
        background-color: #3333ff; 
        color: #FFFFFF; 
        font-size: 20px;
        text-align:center;
    }
  
    .popover-content {
        font-size: 15px;
        color: black;
    }
</style>

<title>InDepth Eye</title>
</head>
<body onload="search()">
    
    <h1 class="w3-center">Assignments Tracker</h1> 
    <table id='list' class='w3-hoverable w3-centered w3-border'></table>
    <table id='popover'></table>
    
    <!-- List of Assignments -->
    <script type="text/javascript">
        function search() {
            var httpAssignments = new XMLHttpRequest();
            httpAssignments.onreadystatechange = function () {
                if (this.readyState === 4) {
                    document.getElementById("list").innerHTML = this.responseText;
                }
            };
            httpAssignments.open("GET", "mysql/search.php", false);
            httpAssignments.send();
        }
    // Popover box
        function getTask(id) {
            var httpTitle = new XMLHttpRequest();
            httpTitle.onreadystatechange = function () {
                if (this.readyState === 4) {
                   document.getElementById("popover").innerHTML  = this.responseText;
                }
            };
            httpTitle.open("GET", "mysql/popover.php?id=" + id, false);
            httpTitle.send();
        }     
        // popover activation
         $(document).ready(function(){
            $('[data-toggle="popover"]').popover({html:true, animation: true});   
        });   
    </script>

<!--         $(document).ready(
                function () {
                    $('[data-toggle="popover"]').popover();});
                            {
                        trigger: "manual", html: true, content: function () {
                            return $('#showTasks').html();
                        }
                   }).on("onclick", function ()
                    {
                        $(this).popover("show");
                    }
                    );
                });
        $(document).ready(
                function () {
                    $('[data-toggle="popover"]').popover({
                        trigger: "manual", html: true, content: function () {
                            return $('#showTasks').html();
                        }
                    }).on("mouseleave", function ()
                    {
                        $(this).popover("hide");
                    }
                    );
              });
 -->
</body>
</html>