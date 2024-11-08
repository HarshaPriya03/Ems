<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if (isset($_POST['edit_id5'])) {
    $eid = $_POST['edit_id5'];

    $con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM payroll_loan
    WHERE empname = ?";


    $query = $con->prepare($sql);
    $query->bind_param('s', $eid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $disbursed = $row['disbursed'];
            $disbursedText = ($disbursed == "1") ? "Loan Disbursed" : "Pending Loan Disbursal";

?>

            <div class="p-4 md:p-1 space-y-2 responsive">
                <div class="flex">
                    <h1 style="font-size: 25px; font-weight: 700;">Loan Summary</h1>
                    <span class="text-xs absolute text-gray-400" style="top:140px;">Created <?php echo date('d-m-Y H:i:s', strtotime('+12 hours 30 minutes', strtotime($row['created']))); ?></span>
                    <a href="#" data-id="<?php echo $row['empname']; ?>" target="_blank"  class="download-link py-2.5 px-5 ms-3 text-sm font-medium text-blue-700 focus:outline-none bg-white rounded-lg border border-blue-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Download</a> 
                </div>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Loan Number</span> <span style="margin-left: 60px;"><?php echo $row['loanno']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Loan Amount</span> <span style="margin-left: 60px;">₹ <?php echo $row['loamt']; ?>/-</span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Tenure</span> <span style="margin-left: 115px;"><?php echo $row['loterm']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Mode of Transfer</span>
                <span style="margin-left: 35px;"><?php echo $row['mop']; ?></span>
                </p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Transfer Date</span> 
                <span style="margin-left: 55px;"><?php echo $row['pdate']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Transaction No</span> 
                <span style="margin-left: 45px;"><?php echo $row['tno']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Tenure Start Date</span><span id="datepicker" style="margin-left: 33px;"><?php echo $row['stmonth']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Disbursal Status</span><span style="margin-left: 45px;"><?php echo $disbursedText; ?></span>
                    <hr>
                    <?php if ($row['disbursed'] == "1") : ?>
                <h1 style="font-size: 25px; font-weight: 700;">Transaction History</h1>
                <div style="overflow-y: auto; height: 200px;">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Transaction
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center;">

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4"><?php echo $row['pdate']; ?></td>
                                <td class="px-6 py-4  whitespace-nowrap">Loan disbursed</td>
                                <td class="px-6 py-4"><?php echo $row['notes']; ?></td>
                            </tr>
                            <?php
                            $sql_emi = "SELECT * FROM payroll_emi WHERE empname = ?";
                            $query_emi = $con->prepare($sql_emi);
                            $query_emi->bind_param('s', $eid);
                            $query_emi->execute();
                            $result_emi = $query_emi->get_result();

                            if ($result_emi->num_rows > 0) {
                                while ($row_emi = $result_emi->fetch_assoc()) {
                            ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-7 py-4"><?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 mins', strtotime($row_emi['created']))); ?></td>
                                        <td class="px-6 py-4">EMI deducted</td>
                                        <td class="px-6 py-4  whitespace-nowrap">EMI:₹<?php echo $row_emi['emi']; ?>/- Month:<?php echo $row_emi['emimonth']; ?>
                                            <br>
                                            <?php
                                            if (!empty($row_emi['category']) || !empty($row_emi['reason'])) {
                                                echo "Pre closed loan as " . $row_emi['category'] . ', Reason: ' . $row_emi['reason'];
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            </div>


            <script>
//  function closeDeductModal() {
//                     var modal = document.getElementById("default-modals");
//                     modal.style.display = "none";
//                 }
                function myeditFuncr() {
                    document.getElementById("mot").classList.remove("inputselect");
                    document.getElementById("pad").classList.remove("inputselect");
                    document.getElementById("tno").classList.remove("inputselect");
                    document.getElementById("modalsubmite").classList.remove("remove");
                    document.getElementById("mot").disabled = false;
                    document.getElementById("pad").disabled = false;
                }
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
<?php
        }
    } else {
        echo '
          <div class="mb-6 p-4 bg-blue-50 rounded-lg dark:bg-gray-800">
            <div class="flex items-center justify-center mb-4">
              <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Your Loan Application is in Process</h4>
         <ol class="list-decimal list-inside text-sm text-gray-700 dark:text-gray-300">
              <li class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Apply: Fill loan amount, purpose, and submit.
              </li>
            </ol>
            <h6 class="text-sm font-semibold text-gray-900 dark:text-white mt-4 mb-2">Next Steps:</h6>
            <ol class="list-decimal list-inside text-sm text-gray-700 dark:text-gray-300">
              <li>HR Review: Your request is sent to HR for eligibility check and due diligence.</li>
              <li>Approval & Credit: If approved, the amount is credited to your salary account.</li>
              <li>Track Status: Check your loan request status anytime in the "Your Loan Requests" table.</li>
            </ol>
          </div>
        ';
    }
} else {
    echo "No data received";
}
?>