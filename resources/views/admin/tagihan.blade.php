@extends('admin.layouts.app_admin')

@section('title', 'Tagihan & Bukti')
@section('page_title', 'Data Tagihan & Pembayaran')
@section('page_desc', 'Cek bukti transfer dan konfirmasi pendaftaran murid.')

@php
    // Kelompokkan tagihan per siswa supaya nama tidak diulang-ulang di tiap baris
    $grouped = collect($tagihans)->groupBy('nama_siswa');

    // Daftar unik pendaftaran (siswa + program) untuk dropdown "Tambah Pembayaran"
    $pendaftaranOptions = collect($tagihans)->unique('pendaftaran_id')->values();

    // Hitung angka untuk kartu ringkasan di atas
    $totalNominal   = collect($tagihans)->sum('jumlah');
    $countLunas     = collect($tagihans)->where('status', 'lunas')->count();
    $countCicilan   = collect($tagihans)->where('status', 'cicilan')->count();
    $countPending   = collect($tagihans)->filter(function ($t) {
        return empty($t->status) || $t->status === 'pending';
    })->count();
@endphp

@section('content')

@if (session('success'))
<div class="alert alert-success rounded-4 border-0" role="alert">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger rounded-4 border-0" role="alert">{{ session('error') }}</div>
@endif

@error('jumlah')
<div class="alert alert-danger rounded-4 border-0" role="alert">{{ $message }}</div>
@enderror

{{-- ================= KARTU RINGKASAN ================= --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="p-3 bg-white border rounded-4 h-100">
            <div class="text-muted small mb-1">Total nominal</div>
            <div class="fs-5 fw-semibold text-dark">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 bg-success-subtle border-0 rounded-4 h-100">
            <div class="text-success small mb-1">Lunas</div>
            <div class="fs-5 fw-semibold text-success">{{ $countLunas }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 bg-warning-subtle border-0 rounded-4 h-100">
            <div class="text-warning-emphasis small mb-1">Cicilan</div>
            <div class="fs-5 fw-semibold text-warning-emphasis">{{ $countCicilan }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 bg-danger-subtle border-0 rounded-4 h-100">
            <div class="text-danger small mb-1">Pending</div>
            <div class="fs-5 fw-semibold text-danger">{{ $countPending }}</div>
        </div>
    </div>
</div>

{{-- ================= SEARCH & FILTER ================= --}}
<div class="d-flex flex-wrap gap-2 mb-3">
    <div class="flex-grow-1" style="min-width: 220px;">
        <input type="text" id="filterSearch" class="form-control rounded-pill"
               placeholder="Cari nama siswa atau no. bukti...">
    </div>
    <select id="filterStatus" class="form-select rounded-pill" style="width: 160px;">
        <option value="">Semua status</option>
        <option value="lunas">Lunas</option>
        <option value="cicilan">Cicilan</option>
        <option value="pending">Pending</option>
    </select>
    <button type="button" class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambahPembayaran">
        <i class="fa fa-plus me-1"></i> Tambah Pembayaran
    </button>
</div>

{{-- ================= MODAL TAMBAH PEMBAYARAN ================= --}}
<div class="modal fade" id="modalTambahPembayaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px;">
            <form action="{{ route('admin.tagihan.simpan') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-semibold">Tambah pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Siswa & program</label>
                        <select name="pendaftaran_id" class="form-select" required>
                            <option value="" disabled selected>Pilih siswa & program</option>
                            @foreach ($pendaftaranOptions as $p)
                                <option value="{{ $p->pendaftaran_id }}">
                                    {{ $p->nama_siswa }} — {{ $p->nama_program }}
                                    (sisa Rp {{ number_format($p->sisa_bayar ?? 0, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nominal (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" min="1" required placeholder="Contoh: 500000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="cicilan">Cicilan</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= LIST TAGIHAN (GROUP PER SISWA > PER PROGRAM) ================= --}}
@forelse ($grouped as $namaSiswa => $items)
<div class="card border-0 shadow-sm mb-3 student-group" style="border-radius: 18px; overflow: hidden;">

    {{-- Header siswa --}}
    <div class="d-flex align-items-center gap-2 px-4 py-3 bg-light">
        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-semibold"
             style="width: 34px; height: 34px; font-size: 13px;">
            {{ strtoupper(substr($namaSiswa ?? '?', 0, 1)) }}{{ strtoupper(substr(strrchr($namaSiswa ?? '', ' ') ?: '', 1, 1)) }}
        </div>
        <div>
            <div class="fw-semibold text-dark">{{ $namaSiswa }}</div>
            <div class="text-muted small">{{ $items->count() }} tagihan</div>
        </div>
    </div>

    @php $byProgram = $items->groupBy('pendaftaran_id'); @endphp

    @foreach ($byProgram as $pendaftaranId => $programItems)
        @php
            $first = $programItems->first();
            $totalBiaya = $first->total_biaya_kelas ?? 0;
            $sisaRaw = $first->sisa_bayar ?? $totalBiaya;
            $sisaTampil = max(0, $sisaRaw);
            $lunasPenuh = $sisaRaw <= 0;
            $progress = $totalBiaya > 0
                ? max(0, min(100, round((($totalBiaya - $sisaRaw) / $totalBiaya) * 100)))
                : 0;
        @endphp

        {{-- Pembungkus 1 program: kasih jarak & garis pemisah yang jelas antar program --}}
        <div class="program-block {{ !$loop->last ? 'mb-4 pb-4 border-bottom' : '' }}">

{{-- Ringkasan per program --}}
<div class="px-4 pt-3 pb-2" style="background: #FCFCFB;">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
        <div>
            <div class="fw-semibold text-dark">{{ $first->nama_program }}</div>
            <div class="text-muted small">Total biaya Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
        </div>
        
        {{-- Logika Badge: Cek apakah sisa masih ada --}}
        <span class="badge {{ $sisaTampil == 0 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' }} rounded-pill px-3">
            {{ $sisaTampil == 0 ? 'Lunas' : 'Sisa Tagihan' }}
        </span>
    </div>
    
    <div class="progress" style="height: 6px; border-radius: 99px;">
        <div class="progress-bar {{ $sisaTampil == 0 ? 'bg-success' : 'bg-warning' }}" style="width: {{ $progress }} %"></div>
    </div>
    
    <div class="d-flex justify-content-between small mt-1">
        <span class="text-muted">{{ $progress }}% terbayar</span>
        <span class="fw-bold {{ $sisaTampil == 0 ? 'text-success' : 'text-danger' }}">
            {{ $sisaTampil == 0 ? 'Lunas' : 'Kurang: Rp ' . number_format($sisaTampil, 0, ',', '.') }}
        </span>
    </div>
</div>

            {{-- Riwayat pembayaran/cicilan untuk program ini --}}
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th class="py-2 px-4" style="width: 130px;">No. Bukti</th>
                            <th class="py-2 px-4">Nominal cicilan</th>
                            <th class="py-2 px-4 text-center" style="width: 110px;">Status</th>
                            <th class="py-2 px-4" style="width: 130px;">Tanggal Bayar</th>
                            <th class="py-2 px-4 text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programItems as $tagihan)
                        @php    
                            $status = $tagihan->status ?? 'pending';

                            $badgeClass = match($status) {
                                'lunas'   => 'bg-success-subtle text-success',
                                'cicilan' => 'bg-warning-subtle text-warning-emphasis',
                                default   => 'bg-danger-subtle text-danger',
                            };
                        @endphp
                        <tr data-status="{{ $status }}"
                            data-search="{{ strtolower($namaSiswa . ' ' . ($tagihan->id ? 'inv-' . str_pad($tagihan->id, 5, '0', STR_PAD_LEFT) : '')) }}"
                            class="{{ $status === 'pending' ? 'table-danger bg-opacity-10' : '' }}">

                            <td class="py-3 px-4">
                                @if ($tagihan->id)
                                    <span class="badge bg-light text-dark border px-2 rounded-pill font-monospace" style="font-weight: 500;">
                                        INV-{{ str_pad($tagihan->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                @else
                                    <span class="text-muted small">Belum ada bukti</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-dark">
                                {{ $tagihan->jumlah > 0 ? 'Rp ' . number_format($tagihan->jumlah, 0, ',', '.') : '—' }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                <span class="badge {{ $badgeClass }} rounded-pill px-3">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            {{-- KOLOM BARU: Tanggal Bayar. Tampil untuk status 'lunas' dan
                                 'cicilan' (keduanya berarti uang sudah masuk), pakai
                                 tagihan_updated_at sebagai waktu terakhir status ini diubah.
                                 Pending/ditolak tampil '-' karena belum ada uang masuk. --}}
                            <td class="py-3 px-4">
                                @if (in_array($status, ['lunas', 'cicilan']) && !empty($tagihan->tagihan_updated_at))
                                    <span class="text-success small fw-medium">
                                        {{ \Carbon\Carbon::parse($tagihan->tagihan_updated_at)->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if ($tagihan->id)
                                <form action="/admin/tagihan/{{ $tagihan->id }}/update-status" method="POST"
                                      class="d-flex align-items-center justify-content-center gap-1">
                                    @csrf
                                    @if(!empty($tagihan->buktiTransfer))
                                        <a href="{{ asset('uploads/bukti_pembayaran/' . $tagihan->buktiTransfer) }}"
                                           target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle"
                                           title="Lihat bukti transfer">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    @endif

                                    <select name="status" class="form-select form-select-sm rounded-pill" style="width: 100px;">
                                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="cicilan" {{ $status == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                                        <option value="lunas" {{ $status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-primary rounded-circle" title="Simpan">
                                        <i class="fa fa-save"></i>
                                    </button>
                                </form>
                                @else
                                    <span class="text-muted small">Menunggu siswa bayar</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div> {{-- /.program-block --}}
    @endforeach

</div> {{-- /.student-group --}}
@empty
<div class="card border-0 shadow-sm py-5 text-center text-muted" style="border-radius: 18px;">
    Belum ada data tagihan.
</div>
@endforelse

@endsection

@push('scripts')
<script>
    (function () {
        const search = document.getElementById('filterSearch');
        const statusFilter = document.getElementById('filterStatus');

        function applyFilter() {
            const q = search.value.trim().toLowerCase();
            const status = statusFilter.value;

            document.querySelectorAll('.student-group').forEach(function (group) {
                let visibleRows = 0;

                group.querySelectorAll('tbody tr').forEach(function (row) {
                    const matchesSearch = !q || row.dataset.search.includes(q);
                    const matchesStatus = !status || row.dataset.status === status;
                    const show = matchesSearch && matchesStatus;

                    row.style.display = show ? '' : 'none';
                    if (show) visibleRows++;
                });

                group.style.display = visibleRows > 0 ? '' : 'none';
            });
        }

        search.addEventListener('input', applyFilter);
        statusFilter.addEventListener('change', applyFilter);
    })();
</script>
@endpush