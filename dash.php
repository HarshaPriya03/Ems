<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard with Kanban</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"> -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2d3748;
            color: #fff;
            position: fixed;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
            cursor: pointer;
        }
        .sidebar ul li:hover {
            background-color: #4a5568;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #2d3748;
            color: #fff;
        }
        .kanban-board {
            display: flex;
            overflow-x: auto;
        }
        .kanban-column {
            flex: 0 0 300px;
            margin-right: 20px;
            background-color: #edf2f7;
            border-radius: 5px;
            padding: 10px;
        }
        .kanban-column h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .kanban-item {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <ul>
        <li><i class="fas fa-home"></i> Dashboard</li>
        <li><i class="fas fa-tasks"></i> Tasks</li>
        <li><i class="fas fa-users"></i> Users</li>
        <li><i class="fas fa-cogs"></i> Settings</li>
    </ul>
</div>

<div class="content">
    <div class="navbar">
        <div>Logo</div>
        <div class="flex items-center">
            <input type="checkbox" id="toggle" class="hidden" />
            <label for="toggle" class="relative flex items-center cursor-pointer">
                <span class="block w-10 h-6 bg-gray-300 rounded-full shadow-inner"></span>
                <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-200 ease-in-out"></span>
            </label>
        </div>
        <div>User</div>
    </div>

    <div id="kanbanBoard1" class="kanban-board">
        <div class="kanban-column">
            <h2>To Do</h2>
            <div class="kanban-item">Task 1</div>
            <div class="kanban-item">Task 2</div>
        </div>
        <div class="kanban-column">
            <h2>In Progress</h2>
            <div class="kanban-item">Task 3</div>
        </div>
        <div class="kanban-column">
            <h2>Done</h2>
            <div class="kanban-item">Task 4</div>
        </div>
    </div>

    <div id="kanbanBoard2" class="kanban-board" style="display:none;">
        <div class="kanban-column">
            <h2>To Do</h2>
            <div class="kanban-item">New Task 1</div>
            <div class="kanban-item">New Task 2</div>
        </div>
        <div class="kanban-column">
            <h2>In Progress</h2>
            <div class="kanban-item">New Task 3</div>
        </div>
        <div class="kanban-column">
            <h2>Done</h2>
            <div class="kanban-item">New Task 4</div>
        </div>
    </div>
</div>

<script>
    document.getElementById('toggle').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('kanbanBoard1').style.display = 'none';
            document.getElementById('main5').style.display = 'none';
            document.getElementById('kanbanBoard2').style.display = 'flex';
        } else {
            document.getElementById('kanbanBoard1').style.display = 'flex';
            document.getElementById('main51').style.display = 'flex';
            document.getElementById('kanbanBoard2').style.display = 'none';
        }
    });
</script>

</body>
</html>
