<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    th {
        background-color: #2563EB;
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
            <th colspan="7" style="font-size: 16px; background-color: #ffffff; color: #000000; border: none; text-align: left; padding-bottom: 10px;">
                <strong>DATA USER - RUANGHUB</strong><br>
                Diekspor pada: {{ now()->format('d M Y H:i') }}
            </th>
        </tr>
        <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 250px;">Nama Lengkap</th>
            <th style="width: 150px;">NIP</th>
            <th style="width: 250px;">Email</th>
            <th style="width: 150px;">Role</th>
            <th style="width: 200px;">Departemen</th>
            <th style="width: 150px;">Tanggal Daftar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $index => $u)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $u->name }}</td>
            <td>="{{ $u->nip }}"</td>
            <td>{{ $u->email }}</td>
            <td style="text-transform: capitalize;">{{ $u->role }}</td>
            <td>{{ $u->department ? $u->department->name : '-' }}</td>
            <td>{{ $u->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
