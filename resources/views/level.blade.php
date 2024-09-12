<!DOCTYPE html>
<html>
    <head>
        <title>Data Level Pengguna</title>
    </head>
    <body>
        <h1>Data Level Pengguna</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <thead>
                <tr>
                    <th>Id Level</th>
                    <th>Kode Level</th>
                    <th>Nama Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $level)
                    <tr>
                        <td>{{ $level->level_id }}</td>
                        <td>{{ $level->level_kode }}</td>
                        <td>{{ $level->level_nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
