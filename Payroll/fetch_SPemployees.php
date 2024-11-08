<?php
@include 'inc/config.php';

$service_provider = isset($_POST['service_provider']) ? $_POST['service_provider'] : '';

$sql = "SELECT emp.*, pms.ctc 
        FROM emp 
        LEFT JOIN payroll_msalarystruc pms ON emp.empname = pms.empname 
        WHERE emp.empty = '$service_provider'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
?>
<thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr>
        <th scope="col" class="px-6 py-3"></th>
        <th scope="col" class="px-6 py-3">Emp Name</th>
        <th scope="col" class="px-6 py-3">CTC</th>
        <th scope="col" class="px-6 py-3">Service Fee %</th>
        <th scope="col" class="px-6 py-3">Service Fee</th>
    </tr>
</thead>
<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <form id="employeeForm">
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4">
                <img src="../pics/<?php echo htmlspecialchars($row['pic'], ENT_QUOTES, 'UTF-8'); ?>" width="50px" style="border-radius: 50%;" alt="">
            </td>
            <td class="px-6 py-4">
                <?php echo htmlspecialchars($row['empname'], ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="px-6 py-4">
                <?php echo htmlspecialchars($row['ctc'], ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="px-6 py-4">
                <input type="text" name="sfper" oninput="calculateFee(this)">
            </td>
            <td class="px-6 py-4">
                <input type="text" name="sfee" readonly>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td colspan="5" class="px-6 py-4 text-center">No Data</td>
    </tr>
<?php endif; ?>
<br>
<input type="hidden" name="service_provider" value="<?php echo htmlspecialchars($service_provider, ENT_QUOTES, 'UTF-8'); ?>">
<button type="submit" onclick="submitFormData()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    Submit
</button>
</form>
