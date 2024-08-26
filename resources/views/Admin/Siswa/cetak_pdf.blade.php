<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Log Bimbingan</title>

    <style>
        :root {
            --header-height: 120px;
        }

        * {
            font-family: TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif;
            line-height: 1.5;
        }

        body {
            margin: 0;
            padding: var(--header-height) 0 0 0;
        }

        @page {
            margin-top: var(--header-height);
            margin-bottom: 20px;
        }

        .header {
            width: 100%;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background-color: white;
            padding-top: 5px;

            /* Ensure the header is always on top */
        }

        .header img {
            height: 100px;
            position: fixed;
            top: 10px;
        }

        .header hr {
            border-top: 4px double black;
        }

        .main-content {
            margin-top: 165px;
            padding: 0 20px;
        }

        .tbl-no span,
        .mhs th,
        .mhs td {
            font-size: 16px;
            padding: 5px;
        }

        .mhs th,
        .mhs td {
            border: 1px solid black;
        }

        .mhs td:first-child,
        .mhs td:last-child {
            text-align: center;
        }

        .judul {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }

        thead {
            display: table-header-group;

        }


        tr.data {
            page-break-inside: avoid;
            /* Hindari pemisahan baris */
        }

        .datalog {
            page-break-after: auto;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        @media print {
            @page {
                margin-top: 200px;
                margin-bottom: 20px;
            }

            .header {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
            }

            body {
                margin: 0;
                padding-top: 180px;
                /* Pastikan cukup ruang untuk header */
            }

            .main-content {
                margin-top: 200px;
            }

            .main-content2 {
                margin-top: 200px;
                page-break-inside: avoid;
            }

            .main-content2 td {
                word-break: keep-all;
                /* Mencegah pemisahan kata */
            }
        }
    </style>
</head>

<body>
    <div class="header">
        @php
            $logoPath = storage_path('app/public/' . $profiles->logo_profiles);
            $logoBase64 = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
        @endphp
        @if ($logoBase64)
            <img src="data:image/png;base64,{{ $logoBase64 }}" class="app-image-style" />
        @else
            <!-- Optionally handle missing logo, e.g., show placeholder -->
        @endif
        <div align="center">
            <span style="font-size: 18px;">{{ strtoupper($profiles->name_profiles) }}</span><br />
            <span style="font-size: 16px;">
                {{ $profiles->address_profiles }}<br />
                Telp: {{ $profiles->phone_profiles }} Email:
                {{ $profiles->email_profiles }}<br />
                Laman://www.sckis.ac.id</span>
            <hr />
        </div>
    </div>
    <div class="all">
        <div class="main-content2">
            <table align="center" border="1" style="margin-top: 5px; margin-bottom: 5px;" class="mhs">
                <thead>
                    <tr>
                        <th width="10" style="border: 1px solid black;"><span style="font-size: 16px;">No</span>
                        </th>
                        <th width="35" style="border: 1px solid black;"><span style="font-size: 16px;">Nama</span>
                        </th>
                        <th width="20" style="border: 1px solid black;"><span style="font-size: 16px;">Nis</span>
                        </th>
                        <th width="20" style="border: 1px solid black;"><span style="font-size: 16px;">Kelas</span>
                        </th>
                        <th width="30" style="border: 1px solid black;"><span style="font-size: 16px;">Status
                                Memilih</span></th>
                    </tr>
                </thead>
                <tbody class="datalog">
                    @foreach ($data as $key => $item)
                        <tr class="data">
                            <td width="10" style="border: 1px solid black; text-align: left; vertical-align: top;">
                                <span style="font-size: 16px; font-weight: normal;">{{ $key + 1 }}</span>
                            </td>
                            <td width="35" style="border: 1px solid black; text-align: left; vertical-align: top;">
                                <span style="font-size: 16px; font-weight: normal;">{{ $item->nama }}</span>
                            </td>
                            <td width="20" style="border: 1px solid black; text-align: left; vertical-align: top;">
                                <span style="font-size: 16px; font-weight: normal;">{{ $item->nis }}</span>
                            </td>
                            <td width="20" style="border: 1px solid black; text-align: left; vertical-align: top;">
                                <span style="font-size: 16px; font-weight: normal;">{{ $item->kelas }}</span>
                            </td>
                            <td width="90" style="border: 1px solid black; text-align: left; vertical-align: top;">
                                @if ($item->status_students == 1)
                                    <span class="badge badge-success" style="font-size: 16px;">Sudah Memilih</span>
                                @else
                                    <span class="badge badge-danger" style="font-size: 16px;">Belum Memilih</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
