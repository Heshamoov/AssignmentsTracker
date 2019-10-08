<?php
include('Header.php');
?>
<head>
<style>
    .popover {
        /*max-width: 600px;*/
    }
    .popover-title {
    background-color: #73AD21; 
    color: #FFFFFF; 
    font-size: 20px;
    text-align:center;
  }
  
  /* Popover Body */
  .popover-content {
    /*background-color: coral;*/
    /*color: #FFFFFF;*/
    font-size: 15px;
    padding: 25px;
  }
</style>
    <script src="js/popover.js"></script>
    <title>InDepth Eye</title>
</head>
<body onload="search()">
    <h1 class="w3-center">Assignments Tracker</h1> 
    <br>
    <table id='list'></table>
    <table id='id'></table>

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
    </script>

<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover({html:true, animation: true});   
    });
        
//        $(document).ready(
//                function () {
//                    $('[data-toggle="popover"]').popover();});
//                            {
//                        trigger: "manual", html: true, content: function () {
//                            return $('#showTasks').html();
//                        }
//                    }).on("onclick", function ()
//                    {
//                        $(this).popover("show");
//                    }
//                    );
//                });

//        $(document).ready(
//                function () {
//                    $('[data-toggle="popover"]').popover({
//                        trigger: "manual", html: true, content: function () {
//                            return $('#showTasks').html();
//                        }
//                    }).on("mouseleave", function ()
//                    {
//                        $(this).popover("hide");
//                    }
//                    );
//                });
    </script>

    <script>
        function getTask(id) {
            var httpTitle = new XMLHttpRequest();
            httpTitle.onreadystatechange = function () {
                if (this.readyState === 4) {
                   document.getElementById("id").innerHTML  = this.responseText;
                }
            };
            httpTitle.open("GET", "mysql/titles.php?id=" + id, false);
            httpTitle.send();
        }
    </script>
</body>
</html>