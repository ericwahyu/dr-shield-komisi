<div class="modal fade modal-lg" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Detail Pembayaran</h1>
                <button type="button" class="btn-close" wire:click="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-label">Jenis <span class="text-danger">*</span></div>
                        <select class="form-select @error('category') is-invalid @enderror" id="status" wire:model.live="category" aria-label="Default select example">
                            <option value=""selected style="display: none">-- Pilih Jenis Pembayaran  --</option>
                            <option value="dr-shield" {{ $category == 'dr-shield' ? "selected" : "" }}>Dr Shield</option>
                            <option value="dr-sonne" {{ $category == 'dr-sonne' ? "selected" : "" }}>Dr Sonne</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></div>
                        <input type="date" class="form-control @error('invoice_detail_date') is-invalid @enderror" wire:model.live="invoice_detail_date" placeholder="">
                        @error('invoice_detail_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Nominal Pembayaran <span class="text-danger">*</span></div>
                        <input type="number" class="form-control @error('invoice_detail_amount') is-invalid @enderror" wire:model.live="invoice_detail_amount" placeholder="Contoh : 2000000">
                        @error('invoice_detail_amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Persentase <span class="text-danger">*</span></div>
                        <input type="number" class="form-control @error('percentage') is-invalid @enderror" wire:model.live="percentage" placeholder="Contoh : 100" disabled>
                        @error('percentage')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="col-6">
                        <div class="form-label">Nomor Faktur <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" wire:model="invoice_number" placeholder="Contoh : C3/035/SI-ABC.KBN/04-24">
                        @error('invoice_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    {{-- <div class="col-5">
                        <div class="form-label">Nama Pelanggan <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('customer') is-invalid @enderror" wire:model="customer" placeholder="Contoh : BERDIKARI EXPO">
                        @error('customer')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-5">
                        <div class="form-label">Id Pelanggan <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('id_customer') is-invalid @enderror" wire:model="id_customer" placeholder="Contoh : C/ABC/BDG/00121">
                        @error('id_customer')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-2">
                        <div class="form-label">Masa Jatuh Tempo <span class="text-danger">*</span></div>
                        <input type="number" class="form-control @error('due_date') is-invalid @enderror" wire:model="due_date" min="0" placeholder="Contoh : 30">
                        @error('due_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Nominal DPP <span class="text-danger">*</span></div>
                        <input type="number" class="form-control @error('income_tax') is-invalid @enderror" wire:model.live="income_tax" min="0"placeholder="">
                        @error('income_tax')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Nilai PPN <span class="text-danger">*</span></div>
                        <input type="number" class="form-control @error('value_tax') is-invalid @enderror" wire:model="value_tax" min="0" placeholder="">
                        @error('value_tax')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <div class="form-label">Total <span class="text-danger">*</span></div>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" wire:model="amount" min="0" placeholder="">
                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal()">Tutup <i class="fa-solid fa-circle-xmark fa-fw ms-2"></i></button>
                <button type="button" class="btn btn-success btn-sm" wire:click="saveData()">Simpan <i class="fa-solid fa-circle-check fa-fw ms-2"></i></button>
            </div>
        </div>
    </div>
</div>
