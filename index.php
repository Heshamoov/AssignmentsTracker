<?php
include('Header.php');
?>

<head>
    <title>Assignments Tracker</title>
</head>
<body onload="search()">
    <h1 class="w3-center">Assignments Tracker</h1> 
    <br>
    <table id="list"></table>
    
    <div id="showTasks" hidden >
        <p id='id'></p>
    </div>

    <script type="text/javascript">
        function search() {
            var httpSections = new XMLHttpRequest();
            httpSections.onreadystatechange = function () {
                if (this.readyState === 4) {
                    document.getElementById("list").innerHTML = this.responseText;
                }
            };
            httpSections.open("GET", "mysql/search.php", false);
            httpSections.send();
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
            document.getElementById("id").innerHTML = id;
        }
    </script>
</body>
</html>