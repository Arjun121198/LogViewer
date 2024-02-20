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
            font-family: 'Arial', sans-serif;
        }

        #container {
            display: flex;
            height: 100vh;
        }

        #sidebar {
            width: 20%;
            padding: 20px;
            background-color: #f2f2f2;
            overflow-y: auto;
        }

        #content {
            width: 80%;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .log-file {
            cursor: pointer;
            color: #007bff;
            margin-bottom: 10px;
        }

        .log-file:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h2>Log Files</h2>
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
