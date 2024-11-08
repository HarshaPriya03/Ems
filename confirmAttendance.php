<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global6.css" />
    <link rel="stylesheet" href="./css/email-form.css" />
    <link rel="stylesheet" href="./css/email-form2.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    <style>
        table {
            z-index: 100;
            border-collapse: collapse;
            /* border-radius: 200px; */
            background-color: white;
            /*   overflow: hidden; */
        }

        th,
        td {
            font-size: 20px;
            padding: 1em;
            background: white;
            color: rgb(52, 52, 52);
            border-bottom: 2px solid rgb(193, 193, 193);
            text-align: center;
        }

        th {
            font-weight: 600;
        }

        .container {
            padding-bottom: 20px;
            margin-right: -30px;
        }

        .input-text:focus {
            box-shadow: 0px 0px 0px;
            border-color: #fd7e14;
            outline: 0px;
        }

        .form-control {
            border: 1px solid #fd7e14;
        }
    </style>
</head>

<body>
    <div class="emailform">
        <div class="bg1"></div>
        <img class="emailform-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm1">
            <span>Anika</span>
            <span class="hrm1">HRM</span>
        </a>
        <a class="employee-management1" id="employeeManagement">Attendance Management</a>
        <!-- <img class="uitcalender-icon1" alt="" src="./public/uitcalemnder.svg" /> -->
        <div class="container" style=" margin-top:110px; margin-left:730px ">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group mb-3" style="width:400px">
                        <input type="text" class="form-control input-text" id="filterInput" onkeyup="filterTable()" placeholder="Search for employee name...">
                        <div class="input-group-append" style="background:white;">
                            <span style="border-radius:0px;pointer-events: none; border-color: #fd7e14;" class="btn btn-outline-warning btn-lg" type="button"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rectangle-parent" style="overflow: auto;">

            <?php
            $servername = "localhost";
            $username = "Anika12";
            $password = "Anika12";
            $dbname = "ems";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $targetDate = date("Y-m-d");
            $firstDayOfMonth = date("Y-m-01");
            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth)) . ' 23:59:59';
            $currentMonth = date('m');
            $currentYear = date('Y');

            $sql = "SELECT e.empname
            FROM emp e
            WHERE e.empstatus = 0
            AND NOT EXISTS (
                SELECT 1
                FROM CA c
                WHERE e.empname = c.empname
                AND MONTH(c.submissionTime) = MONTH(CURRENT_DATE())
                AND YEAR(c.submissionTime) = YEAR(CURRENT_DATE())
            )
            ORDER BY e.emp_no ASC
            
            ";



            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<form>';
                echo '<table class="data" id="attendanceTable" style="margin-left: auto; margin-right: auto;">';
                echo '<tr><th>S.No</th><th>Employee Name</th><th><input type="checkbox" id="checkAll" onclick="toggleCheckboxes(this)"> Confirm Attendance</th></tr>';

                $cnt = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $cnt . '</td>';
                    echo '<td>' . $row['empname'] . '</td>';
                    echo '<td><input type="checkbox" class="absentCheckbox" name="absentCheckbox[]" value="' . $row['empname'] . ' required"></td>';
                    echo '</tr>';
                    $cnt++;
                }

                echo '</table>';
                echo '<button type="submit" name="markAbsent" class="btn btn-outline-primary" style="display: block; margin-left: auto; margin-right: auto; margin-top: 10px;">Confirm Attendance</button>';
                echo '</form>';
            } else {
                echo "";
            }
            echo "<br>";
            $conn->close();
            ?>

            <?php
            $servername = "localhost";
            $username = "Anika12";
            $password = "Anika12";
            $dbname = "ems";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM CA ORDER BY submissionTime DESC" ;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table">
            <thead>
                <tr>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Marked time</th>
                    <th scope="col">Confirmed By</th>
                </tr>
            </thead>
            <tbody>';

                while ($row = $result->fetch_assoc()) {
                    $markedTime = new DateTime($row['submissionTime']);
                    $markedTime->modify('+5 hours 30 minutes');

                    echo '<tr>
                <td>' . $row['empname'] . '</td>
             <td>' . $markedTime->format('Y-m-d H:i:s') . '</td>
             <td>' . $row['confirmed'] . '</td>
              </tr>';
                }

                echo '</tbody></table>';
            } else {
                echo "No records found";
            }

            $conn->close();
            ?>

        </div>

    </div>

</body>
<script>
    function filterTable() {
        var input = document.getElementById('filterInput');
        var filter = input.value.toUpperCase();

        var table = document.getElementById('attendanceTable');

        var rows = table.getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var shouldShow = false;

            if (i === 0) {
                shouldShow = true;
            } else {
                for (var j = 0; j < cells.length; j++) {
                    var cell = cells[j];

                    var isHeaderCell = cell.classList.contains('static-cell');

                    if (!isHeaderCell) {
                        var txtValue = cell.textContent || cell.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            shouldShow = true;
                            break;
                        }
                    }
                }
            }

            if (shouldShow) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
</script>
<script>
    function toggleCheckboxes(checkbox) {
        const checkboxes = document.querySelectorAll('.absentCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = !checkbox.checked;
        });
    }

    $(document).ready(function() {
        $("form").submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();

            var submissionTime = new Date().toISOString().slice(0, 19).replace("T", " "); // Format date as string
            var confirm = "hr";
            const selectedEmployees = [];
            $('.absentCheckbox:checked').each(function() {
                selectedEmployees.push($(this).closest('tr').find('td:nth-child(2)').text());
            });

            // Show SweetAlert confirmation box
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to confirm attendance for selected employee(s) on behalf of the employee upon showing attendance to the employee and also will be responsible for the conflicts raised by employee in future. Continue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm Attendance'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with the form submission
                    Swal.fire({
                        title: 'Loading...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // Use AJAX to submit the form data
                    $.ajax({
                        type: "POST",
                        url: "mark_confirm.php",
                        data: {
                            selectedEmployees: selectedEmployees,
                            submissionTime: submissionTime,
                            confirm: confirm
                        },
                        success: function(response) {
                            // Parse the JSON response
                            var responseData = JSON.parse(response);

                            // Log the response to the console for debugging
                            console.log(responseData);

                            // Handle the response from the server using SweetAlert2
                            if (responseData.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Attendance confirmed successfully!',
                                    showConfirmButton: false,
                                    timer: 1500 // Close after 1.5 seconds
                                }).then(function() {
                                    window.location.href = 'confirmAttendance.php';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to confirm attendance.',
                                    text: responseData.message, // Display the error message from the server
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            Swal.close();
                        }
                    });

                }
            });
        });
    });
</script>



</html>