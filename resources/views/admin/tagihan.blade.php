@extends('admin.layouts.app_admin')

@section('title', 'Tagihan & Bukti')
@section('page_title', 'Data Tagihan & Pembayaran')
@section('page_desc', 'Cek bukti transfer dan konfirmasi pendaftaran murid.')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted">No. Bukti</th>
                    <th class="py-3 px-4 text-muted">Nama Siswa</th>
                    <th class="py-3 px-4 text-muted">Program Didaftar</th>
                    <th class="py-3 px-4 text-muted">Nominal Angsuran</th>
                    <th class="py-3 px-4 text-muted">Sisa Bayar Total</th>
                    <th class="py-3 px-4 text-muted text-center">Status</th>
                    <th class="py-3 px-4 text-muted text-center">Aksi (Ubah Status)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tagihans as $tagihan)
                <tr>
                    <td class="py-3 px-4">
                        <span class="badge bg-secondary rounded-pill px-3">
                            INV-{{ str_pad($tagihan->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>

                    <td class="py-3 px-4 fw-bold text-dark">{{ $tagihan->nama_siswa }}</td>
                    <td class="py-3 px-4 text-muted">{{ $tagihan->nama_program }}</td>
                    
                    <td class="py-3 px-4 fw-semibold" style="color: #7c3aed;">
                        Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
                    </td>
                    
                    <td class="py-3 px-4">
                        @if (isset($tagihan->sisa_bayar) && $tagihan->sisa_bayar <= 0)
                            <span class="text-success fw-bold">
                                <i class="fa fa-check-circle me-1"></i> Lunas Total
                            </span>
                        @else
                            <span class="text-danger fw-bold">
                                Rp {{ number_format($tagihan->sisa_bayar ?? 0, 0, ',', '.') }}
                            </span>
                        @endif
                    </td>

                    <td class="py-3 px-4 text-center">
                        <span class="badge 
                            @if($tagihan->status == 'lunas') bg-success
                            @elseif($tagihan->status == 'cicilan') bg-warning text-dark
                            @elseif($tagihan->status == 'ditolak') bg-danger
                            @else bg-secondary
                            @endif
                            rounded-pill px-3">
                            {{ ucfirst(str_replace('_', ' ', $tagihan->status)) }}
                        </span>
                    </td>
                    
                    <td class="py-3 px-4 text-center">
                        <form action="/admin/tagihan/{{ $tagihan->id }}/update-status" method="POST" class="d-flex align-items-center justify-content-center gap-1 m-0">
                            @csrf
                            
                            @if(!empty($tagihan->buktiTransfer))
                                <a href="{{ asset('uploads/bukti_pembayaran/' . $tagihan->buktiTransfer) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-2" title="Lihat Bukti">
                                    <i class="fa fa-image"></i>
                                </a>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2" disabled title="Tidak ada bukti">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endif

                            <select name="status" class="form-select form-select-sm rounded-pill" style="width: 110px; font-size: 0.8rem; cursor: pointer;">
                                <option value="belum_lunas" {{ $tagihan->status == 'belum_lunas' ? 'selected' : '' }}>Pending</option>
                                <option value="lunas" {{ $tagihan->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="cicilan" {{ $tagihan->status == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                                <option value="ditolak" {{ $tagihan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>

                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-2" title="Simpan">
                                <i class="fa fa-save"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-5 text-center text-muted">
                        <i class="fa fa-inbox fs-1 mb-3 opacity-50"></i>
                        <h5>Belum ada data pendaftaran & tagihan yang masuk.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection