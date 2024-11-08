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

            <div class="p-4 md:p-1 space-y-2">
                <div class="flex">
                    <!--<button onclick="myeditFuncr();"><img src="./public/edit.png" width="30px;" style="position:absolute; right:40px; top:100px;" /></button>-->
                    <h1 style="font-size: 25px; font-weight: 700;">Loan Summary</h1>
                    <span class="text-xs absolute text-gray-400" style="top:140px;">Created <?php echo date('d-m-Y H:i:s', strtotime('+12 hours 30 minutes', strtotime($row['created']))); ?></span>
                    <a href="#" data-id="<?php echo $row['empname']; ?>" target="_blank"  class="download-link py-2.5 px-5 ms-3 text-sm font-medium text-blue-700 focus:outline-none bg-white rounded-lg border border-blue-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Download</a> 
                </div>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Name</span> <span style="margin-left: 120px;"><?php echo $row['empname']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Loan Number</span> <span style="margin-left: 60px;"><?php echo $row['loanno']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Loan Amount</span> <span style="margin-left: 60px;">₹ <?php echo $row['loamt']; ?>/-</span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Tenure</span> <span style="margin-left: 115px;"><?php echo $row['loterm']; ?></span></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Mode of Transfer</span>
                    <select id="mot" class="inputselect" name="mop" style="margin-left: 20px;background-repeat: no-repeat; background-position: right center; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\" http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"%23000000\" width=\"24\" height=\"24\">
                        <path d=\"M0 0h24v24H0z\" fill=\"none\" />
                        <path d=\"M8.29 10.71a.996.996 0 0 0 0 1.41L11.59 15 8.29 18.29a.996.996 0 1 0 1.41 1.41l4.59-4.59a.996.996 0 0 0 0-1.41L9.7 8.29a.996.996 0 0 0-1.41 0z\" /></svg>'); " >
                        <option value="" disabled selected><?php echo $row['mop']; ?></option>
                        <option value="UPI">UPI</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Card Payment">Card Payment</option>
                    </select>
                </p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Transfer Date</span> <input type="date" class="inputselect" id="pad" value="<?php echo $row['pdate']; ?>" style="margin-left: 45px;" disabled></p>
                <hr>
                <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Transaction No</span> <input type="text" name="tno" id="tno" class="inputselect" value="<?php echo $row['tno']; ?>" style="margin-left: 35px;"></p>
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
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button id="modalsubmite" type="button" class="remove text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                <button onclick="window.location.reload();" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Close</button></div>

                    <!-- Add this JavaScript code to handle modal closing -->


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
        echo "No data found";
    }
} else {
    echo "No data received";
}
?>