<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Viewer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #2c3e50;
            color: #ecf0f1;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .top-bar {
            background-color: #34495e;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .search-input {
            width: 200px;
            padding: 5px;
            border: none;
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        
        .log-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .log-table th, .log-table td {
            padding: 10px;
            border-bottom: 1px solid #666;
        }
        
        .log-table th {
            background-color: #34495e;
            color: #ecf0f1;
            text-align: left;
        }
        
        .log-table tr:nth-child(even) {
            background-color: #2c3e50;
        }
        
        .log-level-icon {
            font-size: 18px;
            margin-right: 10px;
        }
        
        #container {
            display: flex;
            height: 100vh;
        }

        #sidebar {
            width: 20%;
            padding: 20px;
            background-color: #34495e;
            overflow-y: auto;
        }

        #content {
            width: 80%;
            padding: 20px;
        }

        .log-file {
            cursor: pointer;
            color: #ecf0f1;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .log-file:hover {
            text-decoration: underline;
            color: #3498db;
        }
        
        .active > .page-link,
        .page-link.active {
            background-color: #3498db;
            border-color: #3498db;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h2 class="header">Log Files</h2>
            <ul id="log-file-list">
                @foreach ($logs as $log)
                    <li class="log-file" data-file="{{ $log }}">
                        {{ basename($log) }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div id="content">
            <h1 class="text-center">Log Viewer</h1>
            <table id="log-table" class="table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Log Entry</th>
                    </tr>
                </thead>
                <tbody id="log-content">
                    <!-- Log entries will be displayed here -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        // Your JavaScript code here
        $(document).ready(function () {
            // Initialize DataTable
            var dataTable = $('#log-table').DataTable();

            // Function to fetch log entries
            function fetchLogEntries(logFile) {
                // Fetch the log content from the server
                $.ajax({
                    url: '/get-log-entries', // Replace with your backend route to fetch log entries
                    method: 'POST',
                    data: { logFile: logFile },
                    success: function (response) {
                        // Format log entries for DataTables
                        var logEntries = response.logEntries.map(function (entry) {
                            return [
                                entry.timestamp,
                                entry.content
                            ];
                        });

                        // Update the DataTable with the log entries
                        dataTable.clear().rows.add(logEntries).draw();
                    },
                    error: function (error) {
                        console.error('Error fetching log entries:', error);
                    }
                });
            }

            // Handle log file click event
            $('.log-file').on('click', function () {
                var logFile = $(this).data('file');
                fetchLogEntries(logFile);
            });

            // Trigger log entry fetch on page load (assuming a default log file)
            var defaultLogFile = $('.log-file:first').data('file');
            fetchLogEntries(defaultLogFile);
        });
    </script>
</body>
</html>
