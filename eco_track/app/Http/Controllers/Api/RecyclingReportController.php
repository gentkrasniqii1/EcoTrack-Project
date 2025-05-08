<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecyclingReport;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewRecyclingReport;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class RecyclingReportController extends Controller
{
    /**
     * ✅ List all reports
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return RecyclingReport::with('user:id,name')->latest()->get();
        }

        return RecyclingReport::where('user_id', $user->id)->latest()->get();
    }

    /**
     * ✅ Store new report
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
        ]);

        $report = RecyclingReport::create([
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'amount' => $data['amount'],
            'location' => $data['location'] ?? null,
        ]);

        // Dërgo notifikim tek të gjithë adminët
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewRecyclingReport($report));

        return response()->json($report, 201);
    }

    /**
     * ✅ Show single report
     */
    public function show($id)
    {
        $report = RecyclingReport::with('user:id,name')->findOrFail($id);

        if (Auth::user()->role !== 'admin' && $report->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $report;
    }

    /**
     * ✅ Update report
     */
    public function update(Request $request, $id)
    {
        $report = RecyclingReport::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $report->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'type' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
        ]);

        $report->update($data);

        return response()->json(['message' => 'Report updated successfully']);
    }

    /**
     * ✅ Delete report
     */
    public function destroy($id)
    {
        $report = RecyclingReport::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $report->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $report->delete();

        return response()->json(['message' => 'Report deleted successfully']);
    }
}
