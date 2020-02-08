<!-- Developed By Hesham Alatrash
     Heshamoov90@Gmail.com -->

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

    <body onload="initDate(); pdf_date(); current_date()">

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
                <th>Print</th>
                <th>Simple Track</th>
                <th>From</th>
                <th>To</th>
                <th>Track</th>
            </tr>
            <tr>
                <td>
                    <button id="pp" class='w3-button w3-hover-red'
                            onclick="print_teachers_list()" accesskey="q">
                    <i style="font-size:24px" class="fa">&#xf02f;</i>
                    </button>
                </td>
                <td>
                    <button class="w3-button w3-white w3-hover-green w3-border" onclick="getmonth()">
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
                <td>
                    <input class="w3-input w3-large" type="date" id="from" value="2018-10-20"/>
                </td>
                <td>
                    <input class="w3-input w3-large" type="date" id="to"/>
                </td>
                <td>
                    <button id="submit"
                            class="w3-button w3-ripple w3-hover-green w3-round-xxlarge fa fa-search w3-xlarge"
                            onclick="search()"></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="w3-row w3-container page-body">
        <div class="w3-quarter left-div" id="teachers-div">
            <p id="current_date" hidden></p>
            <table id="headerDiv" style="padding-top: 20px; margin-bottom: 30px;" hidden>
                <tr>
                    <td rowspan="3" class="textLeft" id="logoTd" >
                        <img src="assets/img/Alsanawbar-Logo.jpg" width="50" class="logoImage" alt="sanawbar logo">
                    </td>
                    <td class="school-name">AL SANAWBAR SCHOOL</td>
                </tr>
                <tr>
                    <td id="pdf_date_range"></td>
                </tr>
                <tr>
                    <td colspan="2"><hr style="min-width:100%"></td>
                </tr>
                <tr>
                    <th colspan="2">Assignments Tracker - Teachers List</th>
                </tr>
            </table>

            <table id="employees-list" class="w3-table-all"></table>
        </div>

        <div class="w3-twothird right-div">
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
                let fromdate = year + '-' + month + '-' + day;

                date = new Date($('#to').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let todate = year + '-' + month + '-' + day;

                var httpAssignments = new XMLHttpRequest();
                httpAssignments.onreadystatechange = function () {
                    if (this.readyState === 4) {
                        document.getElementById("employees-list").innerHTML = this.responseText;
                    }
                };
                httpAssignments.open("GET", "mysql/search.php?fromdate=" + fromdate + "&todate=" + todate, false);
                httpAssignments.send();
            }


            function assignments(id) {
                let date = new Date($('#from').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let fromdate = year + '-' + month + '-' + day;


                date = new Date($('#to').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let todate = year + '-' + month + '-' + day;

                var httpAssignments = new XMLHttpRequest();
                httpAssignments.onreadystatechange = function () {
                    if (this.readyState === 4) {
                        document.getElementById("assignments-list").innerHTML = this.responseText;
                    }
                };
                httpAssignments.open("GET", "mysql/assignemtstable.php?id=" + id + "&fromdate=" + fromdate + "&todate=" + todate, false);
                httpAssignments.send();
            };


            function today() {
                let today = new Date().toISOString().substr(0, 10);
                document.querySelector("#from").value = today;
                document.querySelector("#to").value = today;
                search();
                document.getElementById("out").innerHTML = "Today " + new Date().toUTCString();
            }

            function current_date() {
                let today = new Date().toISOString().substr(0, 10);
                document.getElementById("current_date").innerHTML = "Printing Date: " + today;

            }

            function week() {
                var curr = new Date; // get current date
                var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
                document.querySelector("#from").value = new Date(curr.setDate(first)).toISOString().substr(0, 10);

                document.getElementById("out").innerHTML = "From " + new Date(curr.setDate(first)).toUTCString();

                search();
            }

            function getmonth() {
                var date = new Date();
                var first = new Date(date.getFullYear(), date.getMonth(), 2).toISOString().substr(0, 10);
                document.querySelector("#from").value = new Date(date.getFullYear(), date.getMonth(), 2).toISOString().substr(0, 10);

                document.getElementById("out").innerHTML = "From " + new Date(date.getFullYear(), date.getMonth(), 2).toUTCString();

                search();
            }


            function pdf_date() {
                let date = new Date($('#from').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let fromdate = year + '-' + month + '-' + day;

                date = new Date($('#to').val());
                day = date.getDate();
                month = date.getMonth() + 1;
                year = date.getFullYear();
                let todate = year + '-' + month + '-' + day;

                document.getElementById('pdf_date_range').innerHTML = fromdate + " - " + todate;
            }

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

            function print_teachers_list() {

                printJS({
                    documentTitle: 'InDepth - Assignments Tracker',
                    printable: 'teachers-div',
                    type: 'html',
                    css: 'assets/css/pdf.css'
                })
            }
        </script>
    </body>
    </html>

<?php } ?>