<table>
    <thead>
        <tr></tr>
        <tr>
            <th colspan = "16" style = "font-sixe: 20px;font-weight: bold;text-align: center;text-transform: uppercase;">Perhitungan Komisi BM/SPV Atap</th>
        </tr>
        <tr></tr>
        <tr>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">DEPO</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">BM/SPV</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">NIK</th>
             @foreach ($target_percentage as $target_percentage_1)
                <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Target {{ $target_percentage_1 }}%</th>
            @endforeach
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Penjualan</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Pencapaian</th>
            <th rowspan = "1" colspan="{{ count($payment_percentage) }}" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Pembayaran</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Komisi</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">BM/SPV 80%</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">BM 10%</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Team 10%</th>
        <tr>
            @foreach ($payment_percentage as $payment_percentage_1)
                <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">{{ $payment_percentage_1 }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($roof_datas as $key => $result)
            <tr>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $result?->depo }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;"></td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;"></td>
                 @php
                    $targets = json_decode($result?->targets, true);
                    krsort($targets);
                @endphp
                @foreach ($target_percentage as $target_percentage_2)
                    <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ isset($targets[$target_percentage_2]) ? "Rp. ". number_format($targets[$target_percentage_2], 0, ',', '.') : '-' }}</td>
                @endforeach
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($result?->total_income_tax, 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $result?->percentage_target ? $result?->percentage_target."%" : 'Tidak Mencapai' }}</td>
                @php
                    $payments = json_decode($result->payments, true);
                    $totalCommission = 0;
                @endphp
                @foreach ($payment_percentage as $key => $payment_percentage_2)
                    <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ isset($payments[$key]['total_amount']) ? "Rp. ". number_format($payments[$key]['total_amount'], 0, ',', '.') : '-' }}</td>
                    @php
                        $totalCommission += $payments[$key]['commission'] ?? 0;
                    @endphp
                @endforeach
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission, 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission * (80/100), 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr></tr>
        <tr>
            <th colspan = "16" style = "font-sixe: 20px;font-weight: bold;text-align: center;text-transform: uppercase;">Perhitungan Komisi BM/SPV Keramik</th>
        </tr>
        <tr></tr>
        <tr>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">DEPO</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">BM/SPV</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 50px;">NIK</th>
             @foreach ($target_percentage as $target_percentage_3)
                <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Target {{ $target_percentage_3 }}%</th>
            @endforeach
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Penjualan</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Pencapaian</th>
            <th rowspan = "1" colspan="{{ count($payment_percentage) }}" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Pembayaran</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Komisi</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">BM/SPV 80%</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">BM 10%</th>
            <th rowspan = "2" style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">Team 10%</th>
        <tr>
            @foreach ($payment_percentage as $payment_percentage_3)
                <th style = "font-weight: bold;border: 1.5px solid black;background-color: #eeeeee;text-align: center;text-transform: uppercase;width: 150px;">{{ $payment_percentage_3 }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($ceramic_datas as $key => $result)
            <tr>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $result?->depo }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;"></td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;"></td>
                 @php
                    $targets = json_decode($result?->targets, true);
                    krsort($targets);
                @endphp
                @foreach ($target_percentage as $target_percentage_4)
                    <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ isset($targets[$target_percentage_4]) ? "Rp. ". number_format($targets[$target_percentage_4], 0, ',', '.') : '-' }}</td>
                @endforeach
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($result?->total_income_tax, 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ $result?->percentage_target ? $result?->percentage_target."%" : 'Tidak Mencapai' }}</td>
                @php
                    $payments = json_decode($result->payments, true);
                    $totalCommission = 0;
                @endphp
                @foreach ($payment_percentage as $key => $payment_percentage_4)
                    <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ isset($payments[$key]['total_amount']) ? "Rp. ". number_format($payments[$key]['total_amount'], 0, ',', '.') : '-' }}</td>
                    @php
                        $totalCommission += $payments[$key]['commission'] ?? 0;
                    @endphp
                @endforeach
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission, 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission * (80/100), 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
                <td style="border: 1.5px solid black;text-align: start;vertical-align: middle;">{{ "Rp. ". number_format($totalCommission * (10/100), 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="3" style="text-align: center; vertical-align: middle">Dibuat Oleh,</td>
            <td></td>
            <td colspan="6" style="text-align: center; vertical-align: middle">Mengetahui,</td>
            <td></td>
            <td colspan="3" style="text-align: center; vertical-align: middle">Menyetujui,</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="3" style="text-align: center; vertical-align: middle">SPV Internal Controller</td>
            <td></td>
            <td colspan="3" style="text-align: center; vertical-align: middle">RM 1</td>
            <td colspan="3" style="text-align: center; vertical-align: middle">RM 2</td>
            <td></td>
            <td colspan="1" style="text-align: center; vertical-align: middle">NOM</td>
            <td></td>
            <td colspan="1" style="text-align: center; vertical-align: middle">Direktur ABC</td>
        </tr>
    </tbody>
</table>
