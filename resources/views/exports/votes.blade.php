<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Gaya tambahan untuk membuat presentase terlihat lebih jelas */
        td.percent-cell {
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>

    <table>
        <thead>
            <tr>
                @if ($statusCandidate === 'ganda')
                    <th>Nama Ketua</th>
                    <th>Nama Wakil</th>
                @else
                    <th>Nama Ketua</th>
                @endif
                <th>Jumlah Suara</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($candidate as $candidates)
                <tr>
                    @if ($statusCandidate === 'ganda')
                        <td>{{ $candidates->nama_ketua }}</td>
                        <td>{{ $candidates->nama_wakil }}</td>
                    @else
                        <td>{{ $candidates->nama }}</td>
                    @endif
                    <td>{{ $candidates->jumlah_suara ?? 0 }}</td>
                    <td class="percent-cell">{{ $candidates->persentase ?? '0' }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
