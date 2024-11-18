<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\CreditStatus;
use App\Models\Member;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index()
    {
        $members = Member::with('credits')->get();
        $status = CreditStatus::firstOrCreate([], ['available' => 15000]); // Default dana koperasi
        return view('credits.index', compact('members', 'status'));
    }

    public function allocate(Request $request)
    {
        $status = CreditStatus::first();
        $available = $status->available;

        // Ambil semua data kredit
        $credits = Credit::with('member')->get();

        // Verifikasi kondisi aman
        $work = $available;
        $finish = array_fill(0, $credits->count(), false);

        while (true) {
            $found = false;

            foreach ($credits as $credit) {
                if (!$finish[$credit->id - 1] && $credit->calculateNeed() <= $work) {
                    $work += $credit->allocated;
                    $finish[$credit->id - 1] = true;
                    $found = true;
                }
            }

            if (!$found) {
                break;
            }
        }

        // Jika ada proses yang tidak selesai, alokasi gagal
        if (in_array(false, $finish)) {
            return back()->with('error', 'Allocation failed: Unsafe state detected!');
        }

        // Alokasikan kredit jika kondisi aman
        foreach ($credits as $credit) {
            $credit->allocated += $credit->calculateNeed();
            $credit->need = 0;
            $credit->save();
        }

        // Update dana tersedia
        $status->available = $work;
        $status->save();

        return back()->with('success', 'Credit allocated successfully!');
    }

    public function requestCredit(Request $request)
    {
        $credit = Credit::find($request->credit_id);
        $requested = $request->amount;

        // Validasi permintaan kredit
        if ($requested > $credit->calculateNeed()) {
            return back()->with('error', 'Request exceeds maximum allowed credit!');
        }

        $credit->allocated += $requested;
        $credit->save();

        return back()->with('success', 'Credit request processed!');
    }
}
