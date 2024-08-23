<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            color: #333;
            margin: 40px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            color: #34495e;
            font-size: 18px;
            font-weight: normal;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2980b9;
            color: white;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            font-size: 13px;
            color: #2c3e50;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e1ecf4;
        }

        td.percent-cell {
            font-weight: bold;
            color: #2980b9;
        }

        /* Style for chart */
        .chart-container {
            text-align: center;
            margin-top: 40px;
        }

        .chart-container img {
            max-width: 100%;
            height: auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <h2>Periode: {{ $periode_nama }}</h2>

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
                    <td>{{ $candidates->jumlah_suara }}</td>
                    <td class="percent-cell">{{ $candidates->persentase }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="chart-container">
        <div class="chart-container">
            <div class="chart-container">
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Chart">
                @else
                    <p>Chart tidak tersedia.</p>
                @endif
            </div>
        </div>

    </div>

    <div class="footer">
        Laporan hasil perhitungan suara ini dibuat pada {{ $timestamp }}.
    </div>
</body>

</html>
