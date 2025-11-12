<div class="modal fade modal-sm" id="modal-import" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Import Faktur Atap</h1>
                <button type="button" class="btn-close" wire:click="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Option 1: Excel File (Multi-sheet) -->
                    {{-- <div class="col-12">
                        <div class="form-label">Upload File Excel (.xlsx) <span class="text-muted">(Multi-sheet: faktur
                                & pembayaran)</span></div>
                        <input type="file" class="form-control @error('file_import') is-invalid @enderror"
                            wire:model="file_import" accept=".xlsx,.xls" placeholder="Upload Excel dengan 2 sheet">
                        @error('file_import')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <!-- OR separator -->
                    {{-- <div class="col-12 text-center">
                        <span class="badge bg-secondary">ATAU</span>
                    </div> --}}

                    <!-- Option 2: CSV Files (Separate) -->
                    <div class="col-12">
                        <div class="form-label">Upload CSV Faktur <span class="text-danger">*</span> <span
                                class="text-muted">(Delimiter: ; )</span></div>
                        <input type="file" class="form-control @error('file_faktur') is-invalid @enderror"
                            wire:model="file_faktur" accept=".csv" placeholder="Upload file CSV faktur">
                        @error('file_faktur')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div wire:loading wire:target="file_faktur" class="text-primary mt-1">
                            <small><i class="fa fa-spinner fa-spin"></i> Uploading faktur...</small>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-label">Upload CSV Pembayaran <span class="text-muted">(Optional)</span></div>
                        <input type="file" class="form-control @error('file_pembayaran') is-invalid @enderror"
                            wire:model="file_pembayaran" accept=".csv"
                            placeholder="Upload file CSV pembayaran (opsional)">
                        @error('file_pembayaran')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div wire:loading wire:target="file_pembayaran" class="text-primary mt-1">
                            <small><i class="fa fa-spinner fa-spin"></i> Uploading pembayaran...</small>
                        </div>
                        @if ($file_pembayaran)
                            <div class="text-success mt-1">
                                <small><i class="fa fa-check"></i> File pembayaran ter-upload:
                                    {{ $file_pembayaran->getClientOriginalName() }}</small>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    {{-- <div class="col-12">
                        <div class="alert alert-info mb-0" role="alert">
                            <small>
                                <strong>Catatan:</strong><br>
                                - Gunakan <strong>Excel</strong> jika file memiliki 2 sheet (faktur + pembayaran)<br>
                                - Gunakan <strong>CSV</strong> jika file terpisah (delimiter: semicolon <code>;</code>)
                            </small>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal()">Tutup <i
                        class="fa-solid fa-circle-xmark fa-fw ms-2"></i></button>
                <button type="button" class="btn btn-success btn-sm" wire:click="importInvoiceData()">Simpan <i
                        class="fa-solid fa-circle-check fa-fw ms-2"></i></button>
            </div>
        </div>
    </div>
</div>
