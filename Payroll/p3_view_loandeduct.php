<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if (isset($_POST['edit_id5'])) {
    $eid = $_POST['edit_id5'];

    @include 'inc/config.php';
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM payroll_loan WHERE empname = ?";
    $query = $con->prepare($sql);
    $query->bind_param('s', $eid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            preg_match('/\d+/', $row['loterm'], $matches);
            $loterm = $matches[0];
            $stmonth = $row['stmonth'];
?>

            <style>
                .deduct:hover {
                    background-color: #E5E7EB;
                }

                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1000;
                    overflow: auto;
                    background-color: rgba(0, 0, 0, 0.5);
                }

                .modal-content {
                    background-color: #fefefe;
                    margin: 15% auto;
                    padding: 20px;
                    width: 80%;
                    max-width: 600px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .close {
                    color: #aaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }

                .close:hover,
                .close:focus {
                    color: black;
                    text-decoration: none;
                    cursor: pointer;
                }
            </style>

            <div style="overflow-y: hidden;">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Loan no
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Month-Year
                            </th>
                            <th scope="col" class="px-6 py-3">
                                EMI
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DEDUCTED OR NOT
                            </th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <?php
                        $sql_loan = "SELECT * FROM payroll_loan WHERE empname = ?";
                        $query_loan = $con->prepare($sql_loan);
                        $query_loan->bind_param('s', $eid);
                        $query_loan->execute();
                        $result_loan = $query_loan->get_result();

                        if ($result_loan->num_rows > 0) {
                            while ($row_loan = $result_loan->fetch_assoc()) {
                                for ($i = 0; $i <= $loterm - 1; $i++) {
                                    $current_month = date('F Y', strtotime("+$i months", strtotime($stmonth)));
                                    $sql_emi = "SELECT * FROM payroll_emi WHERE loanno = ? AND emimonth = ?";
                                    $query_emi = $con->prepare($sql_emi);
                                    $query_emi->bind_param('ss', $row_loan['loanno'], $current_month);
                                    $query_emi->execute();
                                    $result_emi = $query_emi->get_result();
                                    if ($result_emi->num_rows > 0) {
                        ?>
                                        <tr id="tr<?php echo $i; ?>" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4"><?php echo $row_loan['loanno']; ?></td>
                                            <td class="px-6 py-4"><?php echo $current_month; ?></td>
                                            <td class="px-6 py-4"><?php echo $row_loan['emi']; ?></td>
                                            <td class="px-6 py-4">EMI Deducted</td>
                                        </tr>
                                    <?php
                                    } else {
                                    ?>
                                        <tr id="tr<?php echo $i; ?>" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4"><?php echo $row_loan['loanno']; ?></td>
                                            <td class="px-6 py-4"><?php echo $current_month; ?></td>
                                            <td class="px-6 py-4"><?php echo $row_loan['emi']; ?></td>
                                            <td class="px-6 py-4">
                                                <?php
                                                $status = $row_loan['status'];
                                                if ($status == 0) { ?>
                                                    EMI Deducted
                                                <?php } else { ?>
                                                    <button data-modal-target="default-modale" data-modal-toggle="default-modale" data-current-month="<?php echo $current_month; ?>" id="<?php echo $row_loan['empname']; ?>" type="button" class="edit_data7 text-gray-900 font-extrabold" onclick="openDeductModal('<?php echo $current_month; ?>')">
                                                    Deduct Now</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                        <?php
                                    }
                                }
                            }
                        } else {
                        }
                        ?>
                </table>
            </div>
            <?php
            $sql = "SELECT *  FROM payroll_loan WHERE empname = ?";
            $query = $con->prepare($sql);
            $query->bind_param('s', $eid);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $status = $row['status'];
                $closed = $row['closed'];

                if ($status == 1) {
                    echo '<button id="closeLoanBtn" type="button" style="margin-top:10px; margin-left:450px;"  class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Close Loan
                </span>
            </button>';
                }else {
                    echo '<span style="margin-left:100px;"  class="text-gray-500 dark:text-gray-400">
                    <a class="font-semibold text-gray-900 underline dark:text-white decoration-red-500 decoration-dashed">LOAN CLOSED ON ' . $closed . '</a>
                    </span>';
                }
                
            } else {
                echo "No data found";
            }
            ?>




            <div id="default-modale" style="overflow-y:hidden; margin-top:-80px; margin-left:2px; padding-bottom:80px;" class="modal hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0">
                <div class="modal-content" id="info_update7">
                    <form id="deductionForm">
                        <?php @include("p3_view_emimodal.php"); ?>
                        <input type="hidden" id="currentMonthInput" name="current_month">
                    </form>
                </div>
            </div>

            <?php
            $sql = "SELECT pl.*, SUM(pe.emi) AS total_emi 
        FROM payroll_loan pl 
        LEFT JOIN payroll_emi pe 
        ON pl.empname = pe.empname AND pl.loanno = pe.loanno 
        WHERE pl.empname=? AND pl.loanno=?
        GROUP BY pl.empname, pl.loanno";
            $query = $con->prepare($sql);
            $query->bind_param('ss', $eid, $row['loanno']);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                $loan = $result->fetch_assoc();
                $balance = $loan['loamt'] - $loan['total_emi'];
            } else {
            }
            ?>
            <div id="default-modalc" style="overflow-y:hidden; margin-top:-80px; padding-bottom:80px;" class="modal hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0">
                <div class="modal-content" id="info_update7">
                    <!-- Modal header -->
                    <div class="p-4 md:p-5 space-y-4">
                        <h1 style="font-size: 25px; font-weight: 700; text-align: center;">Pre-closure Loan Form</h1>
                        <h1 style="font-size: 18px; font-weight: 400; text-align: center;">
                            Please ensure accurate completion of the pre-closure loan form and its details below. This is necessary to successfully close the loan.</h1>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" id="closeForm">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 sm:col-span-1">
                                <input type="hidden" name="loanno" value="<?php echo $loan['loanno']; ?>">
                                <input type="hidden" name="empname" value="<?php echo $loan['empname']; ?>">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pending EMI Amount</label>
                                <input name="emi" type="number" value="<?php echo $balance; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payout Salary Month</label>
                                <input name="emimonth" type="text" id="datepicker" class="datepicker-without-calendar bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select name="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option selected="">Select category</option>
                                    <option value="Employee opts for accelerated loan closure">Employee opts for accelerated loan closure</option>
                                    <option value="Employee departed,loan remains unsettled">Employee departed, loan remains unsettled</option>
                                    <option value="some other category">some other category</option>

                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason for Pre-Closure</label>
                                <textarea name="reason" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write reason here"></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, confirm
                            </button>
                            <button onclick="window.location.reload()"  type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                No, cancel</button>
                        </div>
                    </form>
                </div>
            </div>


            <script>
                $('.datepicker-without-calendar').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'MM yy',
                    beforeShow: function(input) {
                        $(input).datepicker("widget").addClass('hide-calendar');
                    },
                    onClose: function(dateText, inst) {
                        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                        $(this).datepicker('widget').removeClass('hide-calendar');
                    }
                });

                $('.datepicker').datepicker();
            </script>
            <script>
                $(document).ready(function() {
                    $('#closeForm').submit(function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'Do you want to close the loan?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, close loan',
                            cancelButtonText: 'No, cancel',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'insert_closeemi.php',
                                    data: new FormData(this),
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        console.log('Success:', response);
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Closed!',
                                            text: response,
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = 'p3_loans.php';
                                                $('#closeForm')[0].reset();
                                            }
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.log('Error:', xhr.responseText);
                                    }
                                });
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: 'Cancelled',
                                    text: 'The loan closure operation was cancelled',
                                    icon: 'info',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    });
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $(document).on('click', '.edit_data7', function() {
                        var edit_id5 = $(this).attr('id');
                        var currentMonth = $(this).data('current-month');
                        $.ajax({
                            url: "p3_view_emimodal.php",
                            type: "post",
                            data: {
                                edit_id5: edit_id5,
                                current_month: currentMonth
                            },
                            success: function(data) {
                                $("#info_update7").html(data);
                                $("body").addClass("modal-open");
                            }
                        });
                    });

                    $('#closeLoanBtn').click(function() {
                        var empname = '<?php echo $eid; ?>';
                        var loanno = '<?php echo $row['loanno']; ?>';
                        var balance = <?php echo $loan['loamt'] - $loan['total_emi']; ?>;

                        if (balance == 0) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'Do you want to close the loan?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, close it',
                                cancelButtonText: 'No, cancel',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: 'close_loan.php',
                                        type: 'POST',
                                        data: {
                                            empname: empname,
                                            loanno: loanno
                                        },
                                        success: function(response) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Loan Closed!',
                                                text: response,
                                                confirmButtonText: 'OK'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = 'p3_loans.php';
                                                }
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error!',
                                                text: 'Error occurred while closing the loan',
                                                confirmButtonText: 'OK'
                                            });
                                        }
                                    });
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    Swal.fire({
                                        title: 'Cancelled',
                                        text: 'The loan closure was cancelled',
                                        icon: 'info',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        } else {
                            var modal = document.getElementById("default-modalc");
                            modal.style.display = "block";
                        }
                    });
                });
            </script>

            <script>
                function openDeductModal(currentMonth) {
                    var modal = document.getElementById("default-modale");
                    modal.style.display = "block";
                }

                function closeDeductModal() {
                    var modal = document.getElementById("default-modale");
                    modal.style.display = "none";
                }

            </script>

<?php
        }
    } else {
        echo "No data found";
    }
} else {
    echo "No data received";
}
?>