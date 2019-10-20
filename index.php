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
  
    .popover{
        color: black;
        max-width: 40%;
    }
    p{
        font-size: 20px;
        text-align: center;
        font-family: arial;
    }
    </style>
    
    <title>InDepth Eye</title>
</head>

<body onload="search()">
    <h1 class="w3-center w3-wide">Assignments Tracker</h1>  
    

        <button class='printBtn' 
        onclick="printJS({
                printable: 'EmployeesList',
                type: 'html',
                css: 'styles/pdf.css'
                })">Print
        </button>

    <div class="w3-container">
        <table id="EmployeesList" class="w3-table-all w3-card-4 w3-large prinTable" style="width:30%;"></table>
    </div>
    
    
    <div id="AssignmentsList" class="w3-container">
        <table id="AssignmentsTable" class="w3-table w3-large">
        
        </table>
    </div>
    

    <div class="modal fade" id="assignment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button id="close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <table id="title" class="w3-table-all"></table>
    </div>
    <div class="modal-body">
    <div id="popover-content">
    <form class="form-inline" role="form">
        <div class="form-group">
            <p id="content">Hello</p> 
        </div>
    </form>
    </div>
    </div>
    <div class="modal-footer">
    <div class="modal-footer">            
        <button id="print" type="button" class="btn btn-primary btn-sm"
            onclick="printJS({
                printable: 'assignment',
                type: 'html',
                ignoreElements: ['close','print'],
                targetStyles: '*',
                css: 'styles/pdf.css'
            })">
        PRINT
    </button>
    </div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover(
                    {
                        html: true,
                        content: function () {
                            return $('#AssignmentsList').html();
                        }
                    }).$(".popover").on("click", function () {
                $(this).popover('hide');
            });


        });
    </script>

    <script>

        $('[data-toggle="popover1"]').popover(
                {

                    html: true,
                    content: function () {

                        return $('#assignment').html();
                    }
                });


    </script>

    <!-- List of Teachers -->
    <script type="text/javascript">
        function search() {
            var httpAssignments = new XMLHttpRequest();
            httpAssignments.onreadystatechange = function () {
                if (this.readyState === 4) {
                    document.getElementById("EmployeesList").innerHTML = this.responseText;
                }
            };
            httpAssignments.open("GET", "mysql/search.php", false);
            httpAssignments.send();
        }
    </script>
    
    <!--List of Assignments-->
    <script>
        document.getElementById("AssignmentsList").onload = function() {assignments(id)};

        function assignments(id) {
            var httpAssignments = new XMLHttpRequest();
            httpAssignments.onreadystatechange = function () {
                if (this.readyState === 4) {
                    document.getElementById("AssignmentsTable").innerHTML = this.responseText;
                }
            };
            httpAssignments.open("GET", "mysql/assignemtstable.php?id=" + id, false);
            httpAssignments.send();
        };
    </script>    
    
    <!-- Assignment Content -->
    <script type="text/javascript">
        function content(id) {
            
            var httpAssignments = new XMLHttpRequest();
            httpAssignments.onreadystatechange = function () {
                if (this.readyState === 4) {
                    document.getElementById("title").innerHTML = this.responseText;
                }
            };
            httpAssignments.open("GET", "mysql/title.php?id=" + id, false);
            httpAssignments.send();
            
            
            var httpAssignments = new XMLHttpRequest();
            httpAssignments.onreadystatechange = function () {
                if (this.readyState === 4) {
                    document.getElementById("content").innerHTML = this.responseText;
                }
            };
            httpAssignments.open("GET", "mysql/content.php?id=" + id, false);
            httpAssignments.send();
        }
    </script>
    <script type="text/javascript">
        function printassignments(id) {
            printJS({
                printable: 'EmployeesList',
                type: 'html',
                ignoreElements: ['close','print'],
                targetStyles: '*',
                css: 'styles/pdf.css'
            })
        }
    </script>  
</body>
</html>