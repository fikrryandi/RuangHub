<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    th {
        background-color: #8B5CF6;
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
            <th colspan="9" style="font-size: 16px; background-color: #ffffff; color: #000000; border: none; text-align: left; padding-bottom: 10px;">
                <strong>DATA APPROVAL BOOKING - RUANGHUB</strong><br>
                Diekspor pada: {{ now()->format('d M Y H:i') }}
            </th>
        </tr>
        <tr>
            <th style="width: 50px;">No</th>
            <th style="width: 150px;">Kode Booking</th>
            <th style="width: 250px;">Peminjam</th>
            <th style="width: 200px;">Ruangan</th>
            <th style="width: 150px;">Tanggal</th>
            <th style="width: 150px;">Waktu</th>
            <th style="width: 300px;">Keperluan</th>
            <th style="width: 250px;">Catatan Tambahan</th>
            <th style="width: 150px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $index => $b)
        @php
            $bg = '';
            if($b->status == 'disetujui') $bg = '#D1FAE5'; // emerald-100
            else if($b->status == 'ditolak') $bg = '#FEE2E2'; // red-100
            else $bg = '#FEF3C7'; // amber-100
        @endphp
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td style="text-align: center; font-weight: bold;">{{ $b->code }}</td>
            <td>{{ $b->user->name ?? 'User Dihapus' }}</td>
            <td>{{ $b->room->name ?? 'Ruang Dihapus' }}</td>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($b->date)->format('d/m/Y') }}</td>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}</td>
            <td>{{ $b->purpose }}</td>
            <td>{{ $b->notes ?? '-' }}</td>
            <td style="text-align: center; background-color: {{ $bg }}; text-transform: uppercase; font-weight: bold;">
                {{ str_replace('_', ' ', $b->status) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
