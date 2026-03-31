@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Cradle your way into the xterm!
    </div>

    <div class="card-body">
        <div class="container">
            <h1>Shhh....c2wapi</h1>
            <div id="terminal"></div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$('#bookRoom').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var roomId = button.data('room-id');
    var modal = $(this);
    modal.find('#room_id').val(roomId);
    modal.find('.modal-title').text('Booking of a room ' + button.parents('tr').children('.room-name').text());

    $('#submitBooking').click(() => {
        modal.find('button[type="submit"]').trigger('click');
    });
});
</script>

<!-- Include the xterm.js JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/xterm@4.16.0/lib/xterm.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const terminal = new Terminal();
    terminal.open(document.getElementById('terminal'));

    terminal.writeln('You found a way into the backend.');
    terminal.writeln('Can you unleash my power?');
    showPrompt();

    let commandBuffer = '';

    terminal.onData(data => {
        if (data === '\r') {
            terminal.write('\r\n');
            executeCommand(commandBuffer);
            commandBuffer = '';
        } else if (data === '\x7F') {
            if (commandBuffer.length > 0) {
                commandBuffer = commandBuffer.slice(0, -1);
                terminal.write('\b \b');
            }
        } else {
            commandBuffer += data;
            terminal.write(data);
        }
    });

    function executeCommand(cmd) {
        fetch("{{ route('admin.execute') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ cmd: cmd })
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === '__CLEAR_SCREEN__') {
                terminal.clear();
            } else {
                data.split("\n").forEach(line => {
                    terminal.writeln(line.replace(/ /g, '\xa0')); // Preserve spaces
                });
            }
            showPrompt();
        })
        .catch(error => {
            terminal.writeln('Error executing command');
            console.error(error);
            showPrompt();
        });
    }

    function showPrompt() {
        terminal.write('$ ');
    }
});

</script>


<!-- Include the xterm.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/xterm@4.16.0/css/xterm.css" />

<!-- Optional: Include custom CSS -->
<style>
    #terminal {
        width: 100%;
        height: 400px;
        border: 2px solid #ccc;
        margin-top: 20px;
    }
@endsection
