<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Rekrutmen - Manajemen Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Mini Rekrutmen</h1>
                <p class="text-sm text-slate-600">Latihan CRUD & alur kerja tim Laravel 12 + Docker</p>
            </div>
            <div class="flex flex-wrap gap-2 text-xs">
                <a href="{{ route('candidates.index') }}"
                   class="px-3 py-1.5 rounded-md font-medium {{ !$activeStatus ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border' }}">
                    Semua
                </a>
                @foreach ($statuses as $key => $label)
                    <a href="{{ route('candidates.index', ['status' => $key]) }}"
                       class="px-3 py-1.5 rounded-md font-medium {{ $activeStatus === $key ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Form Tambah Pelamar --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 h-fit">
                <h2 class="text-base font-semibold text-slate-900 mb-4">Tambah Pelamar Baru</h2>
                <form action="{{ route('candidates.store') }}" method="POST" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">No. Registrasi *</label>
                        <input type="text" name="registration_code" value="{{ old('registration_code') }}"
                               placeholder="REG-2026-001" required
                               class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="Nama lengkap pelamar" required
                               class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Posisi Dilamar *</label>
                        <input type="text" name="position" value="{{ old('position') }}"
                               placeholder="Contoh: Petugas Operasional / Admin" required
                               class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Wilayah / Unit</label>
                        <input type="text" name="unit_region" value="{{ old('unit_region') }}"
                               placeholder="Contoh: Jakarta Barat"
                               class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Catatan</label>
                        <textarea name="notes" rows="2" placeholder="Catatan singkat seleksi..."
                                  class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium py-2.5 transition">
                        Simpan Pelamar
                    </button>
                </form>
            </div>

            {{-- Tabel Daftar Pelamar --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-900">Daftar Pelamar ({{ $candidates->count() }})</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead class="bg-slate-50 text-slate-600 text-xs uppercase border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4">Pelamar</th>
                                <th class="py-3 px-4">Posisi & Wilayah</th>
                                <th class="py-3 px-4">Update Status</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($candidates as $candidate)
                                <tr class="align-top hover:bg-slate-50/60">
                                    <td class="py-3.5 px-4">
                                        <div class="font-semibold text-slate-900">{{ $candidate->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $candidate->registration_code }}</div>
                                        @if ($candidate->notes)
                                            <div class="text-xs text-slate-600 mt-1 italic">"{{ $candidate->notes }}"</div>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="text-slate-800">{{ $candidate->position }}</div>
                                        <div class="text-xs text-slate-500">{{ $candidate->unit_region ?? '-' }}</div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <form action="{{ route('candidates.update', $candidate) }}" method="POST" class="flex items-center gap-1.5">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="rounded border border-slate-300 px-2 py-1 text-xs bg-white">
                                                @foreach ($statuses as $key => $label)
                                                    <option value="{{ $key }}" @selected($candidate->status === $key)>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                    class="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-white text-xs font-medium">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <form action="{{ route('candidates.destroy', $candidate) }}" method="POST"
                                              onsubmit="return confirm('Hapus data pelamar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs font-medium text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-4 text-center text-slate-500 text-sm">
                                        Belum ada data pelamar. Silakan tambahkan lewat form di samping.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>