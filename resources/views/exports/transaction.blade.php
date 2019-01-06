<table>
    <thead>
        <tr>
            <th>
                Id Transaksi
            </th>
            <th>
                List Barang dan jumlah
            </th>
            <th>
                Total*
            </th>
            <th>
                Metode Pembayaran
            </th>
            <th>
                Tanggal Transaksi
            </th>
            <th>
                Status
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($reports as $report)
        <tr>
            <td>
                {{$report->id}}
            </td>
            <td>
                    @foreach ($report->detail as $item)
                    <ul>
                        <li>{{$item->cart->item->name}}</li>
                        <li>{{$item->cart->quantity}}</li>
                    </ul>
                    @endforeach
            </td>
            <td>
                Rp {{$report->total + $report->shipping - $report->diskon}}
            </td>
            <td class="center">
            @if ($report->status == 0)
                <span>-</span>
            @elseif($report->status == 1)
                <span>Transfer Tunai</span>
            @elseif($report->status == 2)
                <span>Cash on delivery</span>
            @endif
            </td>
            <td class="center">
                {{$report->created_at}}
            </td>
            <td class="center">
            @if ($report->status < 3)
                <span>Belum terverfikiasi</span>
            @else
                <span>Terverfikiasi</span>
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
