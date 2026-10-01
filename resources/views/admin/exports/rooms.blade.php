<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    th {
        background-color: #0D9488;
        color: #ffffff;
        font-weight: bold;
        border: 1px solid #000000;
        text-align: center;
        padding: 10px;
    }
    td {
        border: 1px solid #000000;
        padding: 5px;
    }
</style>

<table>
    <thead>
        <tr>
            <th colspan="6" style="font-size: 16px; background-color: #ffffff; color: #000000; border: none; text-align: left; padding-bottom: 10px;">
                <strong>DATA RUANGAN - RUANGHUB</strong><br>
                Diekspor pada: {{ now()->format('d M Y H:i') }}
            </th>
        </tr>
        <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 250px;">Nama Ruangan</th>
            <th style="width: 150px;">Kapasitas (Orang)</th>
            <th style="width: 300px;">Fasilitas</th>
            <th style="width: 200px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $index => $r)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $r->name }}</td>
            <td style="text-align: center;">{{ $r->capacity }}</td>
            <td>{{ implode(', ', $r->facilities ?? []) }}</td>
            <td style="text-align: center; text-transform: capitalize;">{{ $r->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
