<?php
include('Header.php');
?>

<head>
    <script src="js/popover.js"></script>
    <title>Assignments Tracker</title>
</head>
<body onload="search()">
    <h1 class="w3-center">Assignments Tracker</h1> 
    <br>
    <table id="list"></table>
    
    <div id="showTasks" hidden >
        <table id='id'></table>
    </div>

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
        $(document).ready(
                function () {
                    $('[data-toggle="popover"]').popover({
                        trigger: "manual", html: true, content: function () {
                            return $('#showTasks').html();
                        }
                    }).on("mouseenter", function ()
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