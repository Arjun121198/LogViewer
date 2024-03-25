<?php

namespace Logviewer\Logviewer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogViewerController extends Controller
{
    public function index()
    {
        // Get all log files from the storage/logs directory
        $logs = $this->getLogFiles();
    
        // Fetch the content of the first log file (you can modify this based on your requirements)
        $logContent = $this->getLogContent($logs[0] ?? null);
        // Collect log entries along with timestamps
        return view('logviewer::index', [
            'logs' => $logs,
            'logContent' => $logContent
        ]);
    }

    public function loginCheck(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $logEmail = config('app.log_user_email');
        $logPassword = config('app.log_user_password');
        
        if ($email === $logEmail && $password === $logPassword) {
            // Authentication successful
            $message = 'Login is successful';
            session()->put('logginguseremail', $email);
            return redirect('/log-viewer');
        } else {
            // Authentication failed
            $message = 'Invalid email or password.';
            return view('logviewer::login', compact('message'));
        }
    }
    
    public function getLogEntries(Request $request)
    {
        $logFile = $request->input('logFile');
        $logEntries = $this->parseLogEntries($logFile);

        return response()->json(['logEntries' => $logEntries]);
    }

    protected function getLogFiles()
    {
        // Get all log files from the storage/logs directory
        return array_reverse(glob(storage_path('logs/*.log')));
    }

    protected function getLogContent($file)
    {
        // Fetch the content of the selected log file
        if ($file && File::exists($file)) {
            return File::get($file);
        }

        return "Log file not found.";
    }

    private function parseLogEntries($logFile)
    {
        $logEntries = [];
    
        // Check if the log file exists
        if (File::exists($logFile)) {
            // Read the content of the log file
            $logContent = File::get($logFile);
    
            // Define a regular expression pattern to match log entries
            $pattern = '/\[(.*?)\] (.*?): (.*)/';
    
            // Match log entries using the pattern
            preg_match_all($pattern, $logContent, $matches, PREG_SET_ORDER);
    
            // Iterate through matched entries
            foreach ($matches as $match) {
                $timestamp = $match[1];
                $level = $match[2];
                $content = $match[3];
    
                // Add the parsed entry to the logEntries array
                $logEntries[] = [
                    'timestamp' => $timestamp,
                    'level' => $level,
                    'content' => $content,
                ];
            }
        }
    
        return $logEntries;
    }
    
}
