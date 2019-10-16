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

    <button  data-toggle="popover" title='Popover' data-trigger="focus" onclick="assignments('45')">Level 1</button>


    <table id='EmployeesList' class='w3-hoverable w3-centered w3-border'></table>
    
    
    <div id='AssignmentsList'>
        <h1 id='h1'></h1>
        <script>
    document.getElementById("AssignmentsList").onload = function() {assignments(id)};
    
    function assignments(id) {
    document.getElementById("h1").innerHTML = id;
    };
    </script>
    <br>
<!--    <button data-toggle="modal" data-target="#assignment" title='Popover'>Share</button>-->
    </div>
    

    <div class="modal fade" id="assignment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div id="popover-content" >
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <input type="text" placeholder="Name" class="form-control" maxlength="5">                            
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="EmailToSomeOne();">Send</button>
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

                        return $('#hh2').html();
                    }
                });


    </script>

    <!-- List of Assignments -->
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
</body>
</html>