<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\PenaltyRule;
use App\Models\ReturnChecklist;
use Illuminate\Http\Request;

class ReturnSettingController extends Controller
{
    public function index()
    {
        $checklists = ReturnChecklist::ordered()->get();
        $penaltyRules = PenaltyRule::orderBy('rule_name')->get();

        return view('petugas.return-settings.index', compact('checklists', 'penaltyRules'));
    }

    public function storeChecklist(Request $request)
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'item_name.required' => 'Nama checklist wajib diisi.',
            'sort_order.required' => 'Urutan checklist wajib diisi.',
            'sort_order.integer' => 'Urutan checklist harus berupa angka.',
            'sort_order.min' => 'Urutan checklist minimal 1.',
        ]);

        ReturnChecklist::create([
            'item_name' => $validated['item_name'],
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('petugas.return-settings.index')
            ->with('success', 'Checklist pengembalian berhasil ditambahkan.');
    }

    public function editChecklist(ReturnChecklist $checklist)
    {
        return view('petugas.return-settings.edit-checklist', compact('checklist'));
    }

    public function updateChecklist(Request $request, ReturnChecklist $checklist)
    {
        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'item_name.required' => 'Nama checklist wajib diisi.',
            'sort_order.required' => 'Urutan checklist wajib diisi.',
            'sort_order.integer' => 'Urutan checklist harus berupa angka.',
            'sort_order.min' => 'Urutan checklist minimal 1.',
        ]);

        $checklist->update([
            'item_name' => $validated['item_name'],
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('petugas.return-settings.index')
            ->with('success', 'Checklist pengembalian berhasil diperbarui.');
    }

    public function destroyChecklist(ReturnChecklist $checklist)
    {
        $checklist->delete();

        return redirect()
            ->route('petugas.return-settings.index')
            ->with('success', 'Checklist pengembalian berhasil dihapus.');
    }

    public function editPenaltyRule(PenaltyRule $penaltyRule)
    {
        return view('petugas.return-settings.edit-penalty-rule', compact('penaltyRule'));
    }

    public function updatePenaltyRule(Request $request, PenaltyRule $penaltyRule)
    {
        $validated = $request->validate([
            'rule_name' => ['required', 'string', 'max:255'],
            'calculation_type' => ['required', 'in:per_hari,flat,manual'],
            'default_settlement_method' => ['required', 'in:uang_tunai,ganti_buku,kombinasi'],
            'default_amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'rule_name.required' => 'Nama aturan denda wajib diisi.',
            'calculation_type.required' => 'Tipe perhitungan wajib dipilih.',
            'default_settlement_method.required' => 'Metode penyelesaian default wajib dipilih.',
            'default_amount.required' => 'Nominal default wajib diisi.',
            'default_amount.numeric' => 'Nominal default harus berupa angka.',
            'default_amount.min' => 'Nominal default tidak boleh negatif.',
        ]);

        $penaltyRule->update([
            'rule_name' => $validated['rule_name'],
            'calculation_type' => $validated['calculation_type'],
            'default_settlement_method' => $validated['default_settlement_method'],
            'default_amount' => $validated['default_amount'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('petugas.return-settings.index')
            ->with('success', 'Aturan denda berhasil diperbarui.');
    }
}
