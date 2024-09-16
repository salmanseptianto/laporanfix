<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Harian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>
     {{$title}}
    </h2>


    <table>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama Marketing</th>
                <th>Tanggal</th>
                <th>Project</th>
                <th>Leads</th>
                <th>Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($harianData as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->marketing->name ?? 'Marketing tidak ditemukan' }}</td>
                    <td>{{ $data->date }}</td>
                    <td>{{ $data->project }}</td>
                    <td>{{ $data->leads }}</td>
                    <td>{{ $data->aktivitas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
