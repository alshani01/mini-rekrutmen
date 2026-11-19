<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');

        $candidates = Candidate::query()
            ->when($statusFilter && array_key_exists($statusFilter, Candidate::STATUSES), function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->latest()
            ->get();

        return view('candidates.index', [
            'candidates' => $candidates,
            'statuses' => Candidate::STATUSES,
            'activeStatus' => $statusFilter,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'registration_code' => ['required', 'string', 'max:50', 'unique:candidates,registration_code'],
            'name' => ['required', 'string', 'max:120'],
            'position' => ['required', 'string', 'max:120'],
            'unit_region' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Candidate::create([
            ...$validated,
            'status' => 'submitted',
        ]);

        return redirect()
            ->route('candidates.index')
            ->with('success', 'Data pelamar berhasil ditambahkan.');
    }

    public function update(Request $request, Candidate $candidate): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(array_keys(Candidate::STATUSES))],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $candidate->update($validated);

        return redirect()
            ->route('candidates.index')
            ->with('success', "Status pelamar {$candidate->name} berhasil diperbarui.");
    }

    public function destroy(Candidate $candidate): RedirectResponse
    {
        $candidate->delete();

        return redirect()
            ->route('candidates.index')
            ->with('success', 'Data pelamar berhasil dihapus.');
    }
}