<?php
 include('Header.php');
 ?>
 <head>
    <title>Assignments Tracker</title>
 </head>
<body>
    <div>
        <h1>Assignments Tracker</h1>
        <button class="w3-button w3-green" onclick="search()">Search</button>
        <table id="list" class="w3-table-all"></table>
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

</body>
</html>