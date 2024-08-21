<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>

<body>
    <h1>{{ $title }}</h1>

    <table border="1">
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
                    <td>{{ $candidates->persentase ?? '0%' }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
