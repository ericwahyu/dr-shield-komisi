<div class="modal fade modal-lg" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Faktur Keramik</h1>
                <button type="button" class="btn-close" wire:click="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-8">
                        <div class="form-label">Nama Sales <span class="text-danger">*</span></div>
                        <select class="form-select @error('sales_id') is-invalid @enderror" id="status" wire:model.live="sales_id" aria-label="Default select example">
                            <option value=""selected style="display: none">-- Pilih Tipe Sales --</option>
                                @foreach ($sales as $sales)
                                <option value="{{ $sales?->id }}" {{ $sales_id == $sales?->id ? "selected" : "" }}>{{ Str::title($sales?->name) }}</option>
                                @endforeach
                        </select>
                        @error('sales_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Nama Penjual Utama <span class="text-danger">*</span></div>
                        <input type="sales_code" class="form-control @error('sales_code') is-invalid @enderror" wire:model.live="sales_code" placeholder="Contoh : SBY - Ewa" disabled>
                        @error('sales_code')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-5">
                        <div class="form-label">Tanggal <span class="text-danger">*</span></div>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" wire:model.live="date" placeholder="Contoh : SBY">
                        @error('date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-7">
                        <div class="form-label">Nomor Faktur <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" wire:model="invoice_number" placeholder="Contoh : C3/035/SI-ABC.KBN/04-24">
                        @error('invoice_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-5">
                        <div class="form-label">Nama Pelanggan <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('customer') is-invalid @enderror" wire:model="customer" placeholder="Contoh : BERDIKARI EXPO">
                        @error('customer')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Id Pelanggan <span class="text-danger"></span></div>
                        <input type="text" class="form-control @error('id_customer') is-invalid @enderror" wire:model="id_customer" placeholder="Contoh : C/ABC/BDG/00121">
                        @error('id_customer')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-3">
                        <div class="form-label">Masa Jatuh Tempo <span class="text-danger">*</span></div>
                        <input type="number" class="form-control @error('due_date') is-invalid @enderror" wire:model="due_date" min="0" placeholder="Contoh : 30">
                        @error('due_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Nominal DPP <span class="text-danger">*</span></div>
                        {{-- <input type="text" class="form-control @error('income_tax') is-invalid @enderror" wire:model.live="income_tax" onkeyup="convertToRupiah(this)" placeholder=""> --}}
                        <input type="number" class="form-control @error('income_tax') is-invalid @enderror" wire:model.live="income_tax" min="1" placeholder="">
                        @error('income_tax')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Nilai PPN <span class="text-danger">*</span></div>
                        {{-- <input type="text" class="form-control @error('value_tax') is-invalid @enderror" wire:model.lazy="value_tax" onkeyup="convertToRupiah(this)" placeholder=""> --}}
                        <input type="number" class="form-control @error('value_tax') is-invalid @enderror" wire:model.live="value_tax" min="1" placeholder="">
                        @error('value_tax')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Total <span class="text-danger">*</span></div>
                        {{-- <input type="text" class="form-control @error('amount') is-invalid @enderror" wire:model.lazy="amount" onkeyup="convertToRupiah(this)" placeholder=""> --}}
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" wire:model="amount" min="1" placeholder="">
                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal()">Tutup <i class="fa-solid fa-circle-xmark fa-fw ms-2"></i></button>
                <button type="button" class="btn btn-success btn-sm" wire:click="saveData()">Simpan <i class="fa-solid fa-circle-check fa-fw ms-2"></i></button>
            </div>
        </div>
    </div>
</div>
