<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
}

if (isset($_POST['edit_id5']) && isset($_POST['current_month'])) {
  $eid = $_POST['edit_id5'];
  $currentMonth = $_POST['current_month'];

  @include 'inc/config.php';
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "SELECT * FROM payroll_loan WHERE empname = ? ";
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

      <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      </head>
      <div class="p-4 md:p-5 space-y-4">
        <h1 style="font-size: 25px; font-weight: 700; text-align: center;">Confirm EMI Deduction</h1>
        <h1 style="font-size: 18px; font-weight: 400; text-align: center;">
          You are about to initiate the deduction of the EMI for the <b><?php echo $currentMonth; ?></b> month.Please ensure that employee's loan details are accurate before proceeding. Below are the details.</h1>
        <hr>
        <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Name</span> <span style="margin-left: 120px; font-size:17px;"><?php echo $row['empname']; ?></span></p>
        <hr>
        <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Loan ID</span> <span style="margin-left: 107px;"><?php echo $row['loanno']; ?></span></p>
        <hr>
        <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">EMI Amount</span> <span style="margin-left: 70px;">₹ <?php echo $row['emi']; ?>/-</span></p>
        <hr>

        <p style="font-size: 18px;"><span style="color: rgb(145, 145, 145);">Month</span> <span style="margin-left: 120px;"><?php echo $currentMonth; ?></span></p>
        <hr>
        <div class="text-center">
          <form id="employeeEMI">
            <input type="hidden" name="empname" value="<?php echo $row['empname']; ?>">
            <input type="hidden" name="loanno" value="<?php echo $row['loanno']; ?>">
            <input type="hidden" name="emi" value="<?php echo $row['emi']; ?>">
            <input type="hidden" name="emimonth" value="<?php echo $currentMonth; ?>">

            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
              Yes, confirm
            </button>
            <button onclick="closeDeductModal()" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
              No, cancel</button>
          </form>

        </div>
      </div>
      <script>
        function closeDeductModal() {
                    var modal = document.getElementById("default-modale");
                    modal.style.display = "none";
                }
  $(document).ready(function() {
    $('#employeeEMI').submit(function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to deduct EMI ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, deduct EMI',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: 'insert_emi.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
              console.log('Success:', response);
              Swal.fire({
                icon: 'success',
                title: 'Deducted!',
                text: response,
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'p3_loans.php';
                  $('#employeeEMI')[0].reset();
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
            text: 'The submission of EMI deduction was cancelled',
            icon: 'info',
            confirmButtonText: 'OK'
          });
        }
      });
    });
  });
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