<!-- Developed By Hesham Alatrash-->
<!-- Heshamoov90@Gmail.com - mail@hesham.info-->
<?php
session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['notloggedin'] = 1;
    header('Location: index.php');
} else {
    include('Header.php');
    ?>
    <script src="assets/js/print_header.js"></script>

    <head>
        <title>InDepth Eye</title>
    </head>

    <body onload="initDate();">
    <!--<div id="out"></div>-->
    <div id='page-title' class="w3-container">
        <h2 class="w3-center w3-wide">Assignments Tracker - Al Sanawbar School
            <form action="logout.php" style="float: right;padding-top: 5px; padding-right: 10px;">
                <button type='submit' href='logout.php' class="btn btn-danger btn-sm">
                    <span class="glyphicon glyphicon-log-out"></span> Log out
                </button>
            </form>
        </h2>
        <table class="w3-table-all w3-centered w3-card-4 user-options">
            <tr class="w3-indigo">
                <th>Simple Track</th>
                <th>From</th>
                <th>To</th>
                <th>Track</th>
                <th>Print</th>
            </tr>
            <tr>
                <td>
                    <button class="w3-button w3-white w3-hover-green w3-border" onclick="get_month()">
                        This Month
                    </button>
                    ||
                    <button class="w3-button w3-white w3-hover-green w3-border" onclick="week()">
                        This Week
                    </button>
                    ||
                    <button class="w3-button w3-white w3-border w3-hover-green" onclick="today()">
                        Today
                    </button>
                </td>

                <form target="_blank" action="mysql/print-teachers.php" method="post">
                    <td>
                        <input name='date-from' class="w3-input w3-large" type="date" id="from" value="2018-10-20"
                               onchange="search()"/>
                    </td>
                    <td>
                        <input name="date-to" class="w3-input w3-large" type="date" id="to" onchange="search()"/>
                    </td>
                    <td>
                        <button id="submit"
                                class="w3-button w3-ripple w3-hover-green w3-round-xxlarge fa fa-search w3-xlarge"
                                onclick="search()"></button>
                    </td>
                    <td>
                        <button type="submit" class='w3-button w3-hover-red' name="print-teachers-btn">
                            <i style="font-size:24px" class="fa">&#xf02f;</i>
                        </button>
                    </td>
                </form>

            </tr>
        </table>
    </div>

    <div class="w3-row w3-container page-body">
        <div class="w3-quarter left-div" id="teachers-div">
            <table id="employees-list" class="w3-table-all"></table>
        </div>

        <div class="w3-twothird right-div" id="assignments-div">
            <table id="assignments-list" class="w3-table-all"></table>
        </div>
    </div>

    <div class="modal fade" id="assignment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button id="close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <table id="title" class="w3-table-all"></table>
                </div>
                <div class="modal-body">
                    <div id="popover-content">
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <p id="content">No Date</p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer">
<form target='_blank' action='mysql/assignments-print.php' method='post'>
    <input hidden id="assignment_id_input" name="assignment_id">
    <button id="print" type="submit" name="print-assignment" class="btn btn-primary btn-sm">PRINT</button>
</form>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function initDate() {
                let today = new Date().toISOString().substr(0, 10);
                document.querySelector("#to").value = today;
                search();
            }

            function search() {
                let date = new Date($('#from').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let from_date = year + '-' + month + '-' + day;

                date = new Date($('#to').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let to_date = year + '-' + month + '-' + day;

                var httpAssignments = new XMLHttpRequest();
                httpAssignments.onreadystatechange = function () {
                    if (this.readyState === 4) {
                        document.getElementById("employees-list").innerHTML = this.responseText;
                    }
                };
                httpAssignments.open("GET", "mysql/search.php?from_date=" + from_date + "&to_date=" + to_date, false);
                httpAssignments.send();
            }


            function assignments(employee_id) {
                let date = new Date($('#from').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let from_date = year + '-' + month + '-' + day;


                date = new Date($('#to').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let to_date = year + '-' + month + '-' + day;

                var httpAssignments = new XMLHttpRequest();
                httpAssignments.onreadystatechange = function () {
                    if (this.readyState === 4) {
                        document.getElementById("assignments-list").innerHTML = this.responseText;
                    }
                };
                httpAssignments.open("GET", "mysql/assignemtstable.php?employee_id=" + employee_id + "&from_date=" + from_date + "&to_date=" + to_date, false);
                httpAssignments.send();
            };


            function today() {
                let today = new Date().toISOString().substr(0, 10);
                document.querySelector("#from").value = today;
                document.querySelector("#to").value = today;
                search();
                // document.getElementById("out").innerHTML = "Today " + new Date().toUTCString();
            }

            function week() {
                let curr = new Date; // get current date
                let first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
                document.querySelector("#from").value = new Date(curr.setDate(first)).toISOString().substr(0, 10); // Update Date Picker
                // document.getElementById("out").innerHTML = "From " + new Date(curr.setDate(first)).toUTCString();

                search();
            }

            function get_month() {
                let date = new Date();
                let first = new Date(date.getFullYear(), date.getMonth(), 2).toISOString().substr(0, 10);
                document.querySelector("#from").value = new Date(date.getFullYear(), date.getMonth(), 2).toISOString().substr(0, 10);
                // document.getElementById("out").innerHTML = "From " + new Date(date.getFullYear(), date.getMonth(), 2).toUTCString();
                search();
            }
        </script>


        <!-- Assignment Content -->
        <script type="text/javascript">
            function content(assignment_id) {
                document.getElementById("assignment_id_input").value = assignment_id;
                var httpAssignments = new XMLHttpRequest();
                httpAssignments.onreadystatechange = function () {
                    if (this.readyState === 4) {
                        document.getElementById("title").innerHTML = this.responseText;
                    }
                };
                httpAssignments.open("GET", "mysql/title.php?id=" + assignment_id, false);
                httpAssignments.send();


                var httpAssignments = new XMLHttpRequest();
                httpAssignments.onreadystatechange = function () {
                    if (this.readyState === 4) {
                        document.getElementById("content").innerHTML = this.responseText;
                    }
                };
                httpAssignments.open("GET", "mysql/content.php?id=" + assignment_id, false);
                httpAssignments.send();
            }

            function print_teachers_list() {
                pdf_date();
                printJS({
                    documentTitle: 'InDepth - Assignments Tracker',
                    printable: 'teachers-div',
                    type: 'html',
                    css: 'assets/css/pdf.css',
                    header: false
                });
            }

            function print_assignments_list() {
                pdf_date();
                printJS({
                    documentTitle: "InDepth - Assignments Tracker",
                    printable: 'assignments-div',
                    type: 'html',
                    css: 'assets/css/pdf.css'
                })
            }
        </script>
    </body>
    </html>

<?php } ?>