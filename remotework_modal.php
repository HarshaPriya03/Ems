<?php
include 'inc/config.php';

if(isset($_POST['edit_id5'])) {
    $id = mysqli_real_escape_string($con, $_POST['edit_id5']);
    
    // Fetch any necessary data based on the ID
    $query = "SELECT * FROM remotework_emp WHERE id = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Generate the modal content
$output = '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-md">
    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Verify Work</h2>
    <dt class="mb-4 text-sm text-gray-700 dark:text-gray-300">Before submitting the score, please verify the work by reviewing the report and photos uploaded by the employee. The score should be based on this verification.</dt>
    <form class="max-w-[24rem] mx-auto" id="verifyForm">
        <input type="hidden" name="id" value="' . $id . '">
        <div class="mb-4">
            <label for="productivity-score" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter the productivity score or use the slider to select the score:</label>
            <div class="flex">
                <div class="relative w-full">
                    <input type="number" id="productivity-score" name="score" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" required />
                </div>
            </div>
        </div>
        <div class="relative mb-8">
            <label for="price-range-input" class="sr-only">Productivity Range</label>
            <input id="price-range-input" type="range" min="10" max="100" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
            <div class="flex justify-between mt-2">
                <span class="text-xs text-gray-500 dark:text-gray-400">Min (10)</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">40</span>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-6" style="margin-right:-17px;">70</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Max (100)</span>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2" id="close-modalVerify">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Submit</button>
        </div>
    </form>
</div>
';

    echo $output;
}
?>
    <script>
  
  // Get the elements
  var rangeInput = document.getElementById('price-range-input');
  var currencyInput = document.getElementById('productivity-score');
  
  // Function to update the currency input
  function updateCurrencyInput() {
  currencyInput.value = rangeInput.value;
  }
  
  // Add event listener to the range input
  rangeInput.addEventListener('input', updateCurrencyInput);
  
  </script>