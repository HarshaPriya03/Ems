<?php
session_start();
require_once("dbConfig.php");

function generateDates($year)
{
  $dates = array();
  $startDate = new DateTime("$year-01-01");
  $endDate = new DateTime("$year-12-31");

  while ($startDate <= $endDate) {
    $dates[] = $startDate->format('d-m-Y');
    $startDate->add(new DateInterval('P1D'));
  }

  return $dates;
}

$currentYear = date('Y');
$dates = generateDates($currentYear);
$valuesFromDatabase = array();
$sql = "SELECT date, value FROM holiday_ggm";
$result = $db->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $valuesFromDatabase[$row['date']] = $row['value'];
  }
}

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($db, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];
    $work_location = $row['work_location'];

    if ($user_type1 !== 'admin' && $user_type !== 'user') {
      header('location:loginpage.php');
      exit();
    }
  } else {
    die("Error: Unable to fetch user details.");
  }
} else {
  die("Error: " . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />
  <link rel="stylesheet" href="./css/global6.css" />
  <link rel="stylesheet" href="./css/email-form.css" />
  <link rel="stylesheet" href="./css/email-form2.css" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font: 16px Arial;
    }

    .autocomplete {
      position: relative;
      display: inline-block;
    }

    input {
      border: 1px solid transparent;
      border-radius: 5px;
      background-color: #f1f1f1;
      padding: 10px;
      font-size: 16px;
    }

    input[type=text] {
      width: 100%;
    }

    input[type=submit],
    input[type=button] {
      background-color: DodgerBlue;
      color: #fff;
      cursor: pointer;
    }

    .autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      top: 100%;
      left: 0;
      right: 0;
    }

    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #fff;
      border-bottom: 1px solid #d4d4d4;
    }

    .autocomplete-items div:hover {
      background-color: #e9e9e9;
    }

    .autocomplete-active {
      background-color: DodgerBlue !important;
      color: #ffffff;
    }

    .calendar-container {
      height: auto;
      width: 400px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.4);
      padding: 20px 20px;
    }

    .calendar-week {
      display: flex;
      list-style: none;
      align-items: center;
      padding-inline-start: 0px;
    }

    .calendar-week-day {
      max-width: 67.1px;
      width: 100%;
      text-align: center;
      color: #525659;
    }

    .calendar-days {
      margin-top: 30px;
      list-style: none;
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
      gap: 20px;
      padding-inline-start: 0px;
    }

    .calendar-day {
      text-align: center;
      color: #525659;
      padding: 10px;
    }

    .calendar-day-holiday {
      color: #cc0000 !important;
    }

    .holiday-name {
      font-size: 10px;
      color: #ff0000;
      text-align: start !important;
      position: absolute;
      transform: translateX(-20%);
    }

    .calendar-month-arrow-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .calendar-month-year-container {
      padding: 10px 10px 20px 10px;
      color: #525659;
      cursor: pointer;
    }

    .calendar-arrow-container {
      margin-top: -5px;
    }

    .calendar-left-arrow,
    .calendar-right-arrow {
      height: 30px;
      width: 30px;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      color: #525659;
    }

    .calendar-today-button {
      margin-top: -10px;
      border-radius: 10px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      color: #525659;
      padding: 5px 10px;
    }

    .calendar-today-button {
      height: 27px;
      margin-right: 10px;
      background-color: #ec7625;
      color: white;
    }

    .calendar-months,
    .calendar-years {
      flex: 1;
      border-radius: 10px;
      height: 30px;
      border: none;
      cursor: pointer;
      outline: none;
      color: #525659;
      font-size: 15px;
    }

    .calendar-day-active {
      background-color: #ec7625;
      color: white;
      border-radius: 50%;
    }

    .udbtn:hover {
      color: black !important;
      background-color: white !important;
      outline: 1px solid #F46114;
    }
  </style>
</head>

<body style="overflow-y:hidden;">
  <div class="emailform">
    <div class="bg1"></div>
    <img class="emailform-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm1">
      <span>Anika</span>
      <span class="hrm1">HRM</span>
    </a>
    <a class="employee-management1" id="employeeManagement">Leave Management</a>
    <img class="uitcalender-icon1" alt="" src="./public/uitcalemnder.svg" />
    <div style="margin-top: 120px;overflow-y:auto;height:800px;position: absolute;">
      <table border="1" class="table table-hover" style=" width: 1000px; margin-left: 100px;">
        <tr>
          <td colspan=4 style="text-align:center; font-weight:bold;">
            <?php

            if ($work_location == 'All') {
            ?>
              <a class="btn udbtn" style="background-color: #FB8A0B;color:white;" href="holiday.php">Access VSP Employees Holidays</a>
            <?php }
            ?>
          </td>
        </tr>
        <tr style="font-size:20px;">
          <th>Date</th>
          <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Holiday</th>
          <th>Action</th>
        </tr>

        <?php foreach ($dates as $date) : ?>
          <tr>
            <td style="font-size:17px;"><?php echo $date; ?></td>
            <td>
              <div class="autocomplete" style="width:300px;">
                <input id="input_<?php echo $date; ?>" type="text" name="input_value_<?php echo $date; ?>" placeholder="Enter Holiday here.." value="<?php echo isset($valuesFromDatabase[date('Y-m-d', strtotime($date))]) ? $valuesFromDatabase[date('Y-m-d', strtotime($date))] : ''; ?>">

              </div>
            </td>
            <td>
              <?php if (isset($valuesFromDatabase[date('Y-m-d', strtotime($date))])) : ?>
                <button class="btn btn-outline-success" style="scale: 0.85;" onclick="updateValue('<?php echo $date; ?>')">Update</button>
                <button class="btn btn-outline-danger" style="scale: 0.85;" onclick="deleteValue('<?php echo $date; ?>')">Delete</button>
              <?php else : ?>
                <button class="btn btn-outline-info" style="scale: 0.85;" onclick="addValue('<?php echo $date; ?>')">Add</button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="calendar-container" style="width: 500px; position: absolute; margin-top: 120px; margin-left: 1130px;">
      <div class="calendar-month-arrow-container">
        <div class="calendar-month-year-container">
          <select class="calendar-years"></select>
          <select class="calendar-months"></select>
        </div>
        <div class="calendar-month-year"></div>
        <div class="calendar-arrow-container">
          <button style="font-size: 15px;" class="calendar-today-button"></button>
          <button style="font-size: 15px;" class="calendar-left-arrow">← </button>
          <button style="font-size: 15px;" class="calendar-right-arrow"> →</button>
        </div>
      </div>
      <ul style="font-size: 15px;" class="calendar-week"></ul>
      <ul style="font-size: 15px;" class="calendar-days"></ul>
    </div>

    <script>
      const weekArray = ["Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat"];
      const monthArray = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
      ];
      const current = new Date();
      const todaysDate = current.getDate();
      const currentYear = current.getFullYear();
      const currentMonth = current.getMonth();
      let holidaysData = [];

      // async function fetchHolidaysAndGenerateCalendar() {
      //   try {
      //     const response = await fetch('fetchHolidays.php');
      //     const holidays = await response.json();
      //     updateCalendarWithHolidays(holidays);
      //   } catch (error) {
      //     console.error('Error fetching holidays:', error);
      //   }
      // }
      async function fetchHolidaysAndGenerateCalendar() {
        try {
          const response = await fetch('fetchHolidays_ggm.php');
          holidaysData = await response.json();
          updateCalendarWithHolidays(holidaysData);
          generateCalendarDays(new Date());
        } catch (error) {
          console.error('Error fetching holidays:', error);
        }
      }

      function updateCalendarWithHolidays(holidays) {
        console.log('Received holidays:', holidaysData);
        const holidayDates = holidaysData.map(holiday => holiday.date);
        console.log('Holiday dates:', holidayDates);
        const calendarDays = document.getElementsByClassName("calendar-day");

        Array.from(calendarDays).forEach((dayElement, index) => {
          const day = index + 1;
          const currentDate = new Date(currentYear, currentMonth, day);

          const matchingHoliday = holidays.find(holiday =>
            holiday.date === currentDate.toISOString().split('T')[0]
          );

          if (matchingHoliday) {
            console.log(`Adding holiday styles to day ${day}`);

            // Apply styles directly using inline styles
            dayElement.style.backgroundColor = "#ffcccc";
            dayElement.style.color = "#cc0000";

            const holidayName = document.createElement("div");
            holidayName.textContent = matchingHoliday.name;
            holidayName.classList.add("holiday-name");

            // Apply styles directly using inline styles
            holidayName.style.fontSize = "10px";
            holidayName.style.color = "#ff0000";
            holidayName.style.textAlign = "start";
            holidayName.style.position = "absolute";
            holidayName.style.transform = "translateX(-20%)";

            dayElement.appendChild(holidayName);
          }
        });
      }

      function applyHolidayStyles() {
        const holidayElements = document.querySelectorAll(".calendar-day-holiday");
        holidayElements.forEach(holidayElement => {
          holidayElement.classList.add("holiday-style");
        });

        const holidayNameElements = document.querySelectorAll(".holiday-name");
        holidayNameElements.forEach(nameElement => {
          nameElement.classList.add("holiday-name-style");
        });
      }



      window.onload = function() {
        const currentDate = new Date();
        generateCalendarDays(currentDate);

        let calendarWeek = document.getElementsByClassName("calendar-week")[0];
        let calendarTodayButton = document.getElementsByClassName("calendar-today-button")[0];
        calendarTodayButton.textContent = "Today";

        calendarTodayButton.addEventListener("click", () => {
          generateCalendarDays(currentDate);
        });

        weekArray.forEach((week) => {
          let li = document.createElement("li");
          li.textContent = week;
          li.classList.add("calendar-week-day");
          calendarWeek.appendChild(li);
        });

        const calendarMonths = document.getElementsByClassName("calendar-months")[0];
        const calendarYears = document.getElementsByClassName("calendar-years")[0];
        const monthYear = document.getElementsByClassName("calendar-month-year")[0];

        const selectedMonth = parseInt(monthYear.getAttribute("data-month") || 0);
        const selectedYear = parseInt(monthYear.getAttribute("data-year") || 0);

        monthArray.forEach((month, index) => {
          let option = document.createElement("option");
          option.textContent = month;
          option.value = index;
          option.selected = index === selectedMonth;
          calendarMonths.appendChild(option);
        });

        const startYear = currentYear - 60;
        const endYear = currentYear + 60;
        let newYear = startYear;
        while (newYear <= endYear) {
          let option = document.createElement("option");
          option.textContent = newYear;
          option.value = newYear;
          option.selected = newYear === selectedYear;
          calendarYears.appendChild(option);
          newYear++;
        }

        const leftArrow = document.getElementsByClassName("calendar-left-arrow")[0];

        leftArrow.addEventListener("click", () => {
          const monthYear = document.getElementsByClassName("calendar-month-year")[0];
          const month = parseInt(monthYear.getAttribute("data-month") || 0);
          const year = parseInt(monthYear.getAttribute("data-year") || 0);

          let newMonth = month === 0 ? 11 : month - 1;
          let newYear = month === 0 ? year - 1 : year;
          let newDate = new Date(newYear, newMonth, 1);
          generateCalendarDays(newDate);
        });

        const rightArrow = document.getElementsByClassName("calendar-right-arrow")[0];

        rightArrow.addEventListener("click", () => {
          const monthYear = document.getElementsByClassName("calendar-month-year")[0];
          const month = parseInt(monthYear.getAttribute("data-month") || 0);
          const year = parseInt(monthYear.getAttribute("data-year") || 0);
          let newMonth = month + 1;
          newMonth = newMonth === 12 ? 0 : newMonth;
          let newYear = newMonth === 0 ? year + 1 : year;
          let newDate = new Date(newYear, newMonth, 1);
          generateCalendarDays(newDate);
        });

        calendarMonths.addEventListener("change", function() {
          let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
          generateCalendarDays(newDate);
        });

        calendarYears.addEventListener("change", function() {
          let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
          generateCalendarDays(newDate);
        });

        fetchHolidaysAndGenerateCalendar();
      };

      function generateCalendarDays(currentDate) {
        const newDate = new Date(currentDate);
        const year = newDate.getFullYear();
        const month = newDate.getMonth();
        const totalDaysInMonth = getTotalDaysInAMonth(year, month);
        const firstDayOfWeek = getFirstDayOfWeek(year, month);
        let calendarDays = document.getElementsByClassName("calendar-days")[0];

        removeAllChildren(calendarDays);

        let firstDay = 1;
        while (firstDay <= firstDayOfWeek) {
          let li = document.createElement("li");
          li.classList.add("calendar-day");
          calendarDays.appendChild(li);
          firstDay++;
        }

        let day = 1;
        while (day <= totalDaysInMonth) {
          let li = document.createElement("li");
          li.textContent = day;
          li.classList.add("calendar-day");
          if (todaysDate === day && currentMonth === month && currentYear === year) {
            li.classList.add("calendar-day-active");
          }
          calendarDays.appendChild(li);

          const matchingHoliday = holidaysData.find(holiday =>
            holiday.date === new Date(Date.UTC(year, month, day)).toISOString().split('T')[0]
          );

          if (matchingHoliday) {
            li.classList.add("calendar-day-holiday");
            const holidayName = document.createElement("div");
            holidayName.textContent = matchingHoliday.name;
            holidayName.classList.add("holiday-name");
            li.appendChild(holidayName);
          }

          day++;
        }

        const monthYear = document.getElementsByClassName("calendar-month-year")[0];
        monthYear.setAttribute("data-month", month);
        monthYear.setAttribute("data-year", year);
        const calendarMonths = document.getElementsByClassName("calendar-months")[0];
        const calendarYears = document.getElementsByClassName("calendar-years")[0];
        calendarMonths.value = month;
        calendarYears.value = year;
      }



      function getTotalDaysInAMonth(year, month) {
        return new Date(year, month + 1, 0).getDate();
      }

      function getFirstDayOfWeek(year, month) {
        return new Date(year, month, 1).getDay();
      }

      function removeAllChildren(parent) {
        while (parent.firstChild) {
          parent.removeChild(parent.firstChild);
        }
      }
    </script>
    <script>
      function addValue(date) {
        var inputField = document.querySelector('input[name="input_value_' + date + '"]');
        var inputValue = inputField.value;

        // Make an AJAX request to the server-side PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "insert_holiday_ggm.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
            if (xhr.status == 200) {
              console.log('Input value for ' + date + ': ' + inputValue);

              // Update the input field with the added value
              inputField.value = xhr.responseText;

              // Change action buttons to update and delete
              var actionButtons = document.querySelector('td button');
              actionButtons.innerHTML = '<button onclick="updateValue(\'' + date + '\')">Update</button>' +
                '<button onclick="deleteValue(\'' + date + '\')">Delete</button>';

              // Show SweetAlert for success
              Swal.fire({
                title: 'Success!',
                text: 'Holiday  added successfully.',
                icon: 'success',
                timer: 2000, // Close after 2 seconds
                showConfirmButton: false
              }).then(() => {
                window.location.href = 'holiday_ggm.php';
              });
            } else {
              // Show SweetAlert for error
              Swal.fire({
                title: 'Error!',
                text: 'Failed to add value.',
                icon: 'error'
              });
            }
          }
        };

        // Send the input value and date to the server-side script
        xhr.send("date=" + date + "&value=" + inputValue);
      }

      function updateValue(date) {
        var inputField = document.querySelector('input[name="input_value_' + date + '"]');
        var updatedValue = inputField.value;

        // Make an AJAX request to the server-side PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_holiday_ggm.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
            if (xhr.status == 200) {
              console.log('Update value for ' + date + ': ' + updatedValue);

              // Show SweetAlert for success
              Swal.fire({
                title: 'Success!',
                text: 'Holiday updated successfully.',
                icon: 'success',
                timer: 2000, // Close after 2 seconds
                showConfirmButton: false
              }).then(() => {
                window.location.href = 'holiday_ggm.php';
              });
            } else {
              // Show SweetAlert for error
              Swal.fire({
                title: 'Error!',
                text: 'Failed to update value.',
                icon: 'error'
              });
            }
          }
        };

        // Send the updated value and date to the server-side script
        xhr.send("date=" + date + "&value=" + updatedValue);
      }

      function deleteValue(date) {
        // Make an AJAX request to the server-side PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_holiday_ggm.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4) {
            if (xhr.status == 200) {
              console.log('Delete value for ' + date);

              // Update the input field with an empty value
              var inputField = document.querySelector('input[name="input_value_' + date + '"]');
              inputField.value = '';

              // Change action buttons back to add
              var actionButtons = document.querySelector('td button');
              actionButtons.innerHTML = '<button onclick="addValue(\'' + date + '\')">Add</button>';

              // Show SweetAlert for success
              Swal.fire({
                title: 'Success!',
                text: 'Holiday deleted successfully.',
                icon: 'success',
                timer: 2000, // Close after 2 seconds
                showConfirmButton: false
              }).then(() => {
                window.location.href = 'holiday_ggm.php';
              });

            } else {
              // Show SweetAlert for error
              Swal.fire({
                title: 'Error!',
                text: 'Failed to delete value.',
                icon: 'error'
              });
            }
          }
        };

        // Send the date to the server-side script for deletion
        xhr.send("date=" + date);
      }

      function autocomplete(inp, arr) {
        var currentFocus;

        inp.addEventListener("input", function(e) {
          closeAllLists();
          if (!this.value) {
            return false;
          }

          currentFocus = -1;

          var a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");

          this.parentNode.appendChild(a);

          for (var i = 0; i < arr.length; i++) {
            if (arr[i].substr(0, this.value.length).toUpperCase() == this.value.toUpperCase()) {
              var b = document.createElement("DIV");
              b.innerHTML = "<strong>" + arr[i].substr(0, this.value.length) + "</strong>";
              b.innerHTML += arr[i].substr(this.value.length);
              b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              b.addEventListener("click", function(e) {
                inp.value = this.getElementsByTagName("input")[0].value;
                closeAllLists();
              });
              a.appendChild(b);
            }
          }
        });

        inp.addEventListener("keydown", function(e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
          } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
          } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
              if (x) x[currentFocus].click();
            }
          }
        });

        function addActive(x) {
          if (!x) return false;
          removeActive(x);
          if (currentFocus >= x.length) currentFocus = 0;
          if (currentFocus < 0) currentFocus = (x.length - 1);
          x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
          for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
          }
        }

        function closeAllLists(elmnt) {
          var x = document.getElementsByClassName("autocomplete-items");
          for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
              x[i].parentNode.removeChild(x[i]);
            }
          }
        }

        document.addEventListener("click", function(e) {
          closeAllLists(e.target);
        });
      }

      var holidays = ["Sankranti", "Bhogi", "Holiday", "YSS", "OKOK"];

      <?php foreach ($dates as $date) : ?>
        autocomplete(document.getElementById("input_<?php echo $date; ?>"), holidays);
      <?php endforeach; ?>
    </script>

</body>

</html>