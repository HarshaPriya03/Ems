
<?php
include 'inc/config.php'; 

$link_id = mysqli_real_escape_string($con, $_GET['link_id']);
$query = "SELECT * FROM remotework_emp WHERE link_id='$link_id'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

function getColorBasedOnScore($score) {
    if ($score >= 75) {
        $green = min(255, intval(($score - 75) * 12.75)); // More the score greener the color
        return "color: rgb(0, {$green}, 0);"; // Green color range
    } elseif ($score < 50) {
        $red = min(255, intval((50 - $score) * 12.75)); // Lesser the score redder the color
        return "color: rgb({$red}, 0, 0);"; // Red color range
    } else {
        return "color: rgb(0, 0, 0);"; // Neutral color (black)
    }
}


$output = '';

while ($row = mysqli_fetch_assoc($result)) {
    $start_date = date('d-m-Y', strtotime($row['start']));
    $work_pics = explode(',', $row['work_pics']); 
    $id = $row['id'];
    
    $output .= '
   <div class="mb-6 pb-6 border border-gray-400 shadow-sm rounded-lg p-6 bg-gray-50 dark:bg-gray-800"">
        <h4 class="font-semibold text-lg mb-4">Remote Work Session Summary: ' . htmlspecialchars($start_date) . '</h4>
        <dl class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Time</dt>
                <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">' . htmlspecialchars($row['start']) . '</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">End Time</dt>
                <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">' . htmlspecialchars($row['end']) . '</dd>
            </div>
            <div class="col-span-2">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Remote Time</dt>
                <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">' . htmlspecialchars($row['total']) . '</dd>
            </div>
        </dl>
        <div class="mb-4">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Work Report</dt>
            <p class="text-sm text-gray-900 dark:text-white">' . htmlspecialchars($row['report']) . '</p>
        </div>
        ';

    if ($row['status'] == 0) {
        if ($row['status'] == 0) {
            $output .= '
            <button class="verify-work inline-flex items-center px-4 py-2 bg-yellow-100 border border-grey-800 rounded-lg cursor-pointer" data-id="' . $id . '">
             <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
             </svg>
             <span class="text-sm font-medium text-yellow-700">Verify Work</span>
            </button>';
        }
    } elseif ($row['status'] == 1) {
        $output .= '
        <div class="inline-flex items-center px-4 py-2 bg-green-100 border border-green-400 rounded-lg">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium text-green-700">Work Verified</span>
        </div>';
    }

    $output .= '
    <button type="button" onclick="showPreviewModal(' . htmlspecialchars(json_encode($work_pics)) . ')" class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">

<svg class="w-5 h-5 me-2"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
  <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg>

Work Pics
</button>
<br>';
$colorStyle = getColorBasedOnScore($row['score']);
if ($row['status'] == 1) {
    $output .= '
    <div>
        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Productivity Score</dt>
          <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white" style="' . $colorStyle . '">' . htmlspecialchars($row['score']) . '</dd>
    </div>';
}

$output .= '</div>';
}


echo $output;
?>
<div id="previewModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Work Pics Preview</h3>
                <div id="previewContent" class="flex flex-wrap justify-center gap-4">
                    <!-- Images will be inserted here -->
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="hidePreviewModal()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modalVerify" class="fixed inset-0 z-10 flex items-center justify-center hidden">
    <!-- The content of this div will be replaced by the AJAX response -->
</div>

