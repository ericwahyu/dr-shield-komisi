@section('title', 'Detail Komisi Keramik')
@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="d-flex align-items-center">
        <a href="{{ route('ceramic.commission') }}" class="btn btn-icon" style="margin-right: 15px"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h3 class="mb-0 fw-semibold">Detail Komisi Keramik</h3>
        </div>
        <div class="ms-auto">
            {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button> --}}
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4 card">
                {{-- <h5 class="card-header d-flex justify-content-between align-items-center">Data Akun Admin</h5> --}}
                {{-- <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="text-align: center">Data Sales</h5>
                </div> --}}
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="form-label">Nama Sales</div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $get_user?->name }}" placeholder="" disabled>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <div class="form-label">Kode Sales</div>
                            <input type="text" class="form-control @error('sales_code') is-invalid @enderror" value="{{ $get_user?->userDetail?->depo }}" placeholder="" disabled>
                            @error('sales_code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <div class="form-label">Komisi Penjualan</div>
                            <input type="text" class="form-control @error('civil_registration_number') is-invalid @enderror" value="{{ $get_month_commission }}" placeholder="" disabled>
                            @error('civil_registration_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-4 card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive scrollbar-x">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2" class="text-center" style="width: 10px;">No</th>
                                            {{-- <th class="text-center">Tipe</th> --}}
                                            <th rowspan="2" class="text-center">Tahun</th>
                                            <th rowspan="2" class="text-center">Bulan</th>
                                            <th colspan="2" class="text-center">100%</th>
                                            <th colspan="2" class="text-center">80%</th>
                                            <th colspan="2" class="text-center">50%</th>
                                            <th colspan="2" class="text-center">0%</th>
                                            <th rowspan="2" class="text-center">Uang Masuk</th>
                                            {{-- <th class="text-center" style="width: 10px;">Aksi</th> --}}
                                        </tr>
                                        <tr>
                                            <th class="text-center">Uang Masuk</th>
                                            <th class="text-center">Komisi</th>
                                            <th class="text-center">Uang Masuk</th>
                                            <th class="text-center">Komisi</th>
                                            <th class="text-center">Uang Masuk</th>
                                            <th class="text-center">Komisi</th>
                                            <th class="text-center">Uang Masuk</th>
                                            <th class="text-center">Komisi</th>
                                            {{-- <th class="text-center">80%</th>
                                            <th class="text-center">50%</th>
                                            <th class="text-center">0%</th> --}}
                                            {{-- <th class="text-center" style="width: 10px;">Aksi</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($get_list_years as $year)
                                            @foreach ($get_list_months as $month)
                                                <tr>
                                                    <td class = "text-center">{{ $loop->iteration }}</td>
                                                    <td class = "text-center">{{ $year }}</td>
                                                    <td class = "text-center">{{ Carbon::createFromFormat('m', $month)->translatedFormat('F') }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 100)?->total_income ? "Rp. ". number_format($this->getDetailCommission($year, $month, 100)?->total_income, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 100)?->value_of_due_date ? "Rp. ". number_format($this->getDetailCommission($year, $month, 100)?->value_of_due_date, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 80)?->total_income ? "Rp. ". number_format($this->getDetailCommission($year, $month, 80)?->total_income, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 80)?->value_of_due_date ? "Rp. ". number_format($this->getDetailCommission($year, $month, 80)?->value_of_due_date, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 50)?->total_income ? "Rp. ". number_format($this->getDetailCommission($year, $month, 50)?->total_income, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 50)?->value_of_due_date ? "Rp. ". number_format($this->getDetailCommission($year, $month, 50)?->value_of_due_date, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 0)?->total_income ? "Rp. ". number_format($this->getDetailCommission($year, $month, 0)?->total_income, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-center">{{ $this->getDetailCommission($year, $month, 0)?->value_of_due_date ? "Rp. ". number_format($this->getDetailCommission($year, $month, 0)?->value_of_due_date, 0, ',', '.') : '-' }}</td>
                                                    <td class = "text-end">{{ $this->getTotalIncome($year, $month, null) > 0 ? "Rp. ". number_format($this->getTotalIncome($year, $month, null), 0, ',', '.') : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center fw-bold">Belum Ada Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8"></td>
                                            <td class = "text-end"><b>{{ $this->getTotalCommission(null, null, null) > 0 ? "Rp. ". number_format($this->getTotalCommission(null, null, null), 0, ',', '.') : '-' }}</b></td>
                                            <td colspan="2"></td>
                                            <td class = "text-end"><b>{{ $this->getTotalIncome(null, null, null) > 0 ? "Rp. ". number_format($this->getTotalIncome(null, null, null), 0, ',', '.') : '-' }}</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
