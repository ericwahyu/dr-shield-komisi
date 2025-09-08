<div class="modal fade modal-lg" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Sales</h1>
                <button type="button" class="btn-close" wire:click="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-label">Nama Sales <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.live="name" placeholder="Contoh : Eric Wahyu Amiruddin">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Kode Depo <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('depo') is-invalid @enderror" wire:model.live="depo" placeholder="Contoh : SBY">
                        @error('depo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">NIK</div>
                        <input type="text" class="form-control @error('civil_registration_number') is-invalid @enderror" wire:model="civil_registration_number" placeholder="Contoh : 1234567890">
                        @error('civil_registration_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Tipe Sales <span class="text-danger">*</span></div>
                        <select class="form-select @error('sales_type') is-invalid @enderror" id="status" wire:model="sales_type" aria-label="Default select example">
                            <option value=""selected style="display: none">-- Pilih Tipe Sales --</option>
                            <option value="roof" {{ $sales_type == 'roof' ? "selected" : "" }}>Atap</option>
                            <option value="ceramic" {{ $sales_type == 'ceramic' ? "selected" : "" }}>Keramik</option>
                        </select>
                        @error('sales_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Kode Sales <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('sales_code') is-invalid @enderror" wire:model.live="sales_code" placeholder="Contoh : SBY - Eric">
                        @error('sales_code')
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
