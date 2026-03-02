<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    public function bulkAction(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('table_ids', []);
        if (empty($ids) || !$action) {
            return back()->with('error', 'No tables selected or action missing.');
        }
        if ($action === 'delete') {
            Table::whereIn('id', $ids)->delete();
            return back()->with('success', 'Selected tables deleted.');
        } elseif (in_array($action, ['available', 'occupied', 'reserved'])) {
            Table::whereIn('id', $ids)->update(['status' => $action]);
            return back()->with('success', 'Status updated for selected tables.');
        }
        return back()->with('error', 'Invalid bulk action.');
    }
    public function export($type)
    {
        $tables = Table::orderBy('id', 'desc')->get();
        if ($type === 'csv') {
            $filename = 'tables_' . date('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$filename"
            ];
            $callback = function() use ($tables) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Table Number', 'Capacity', 'Location', 'Status']);
                foreach ($tables as $t) {
                    fputcsv($file, [
                        $t->id,
                        $t->table_number ?? '',
                        $t->capacity,
                        $t->location,
                        $t->status
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } elseif ($type === 'pdf') {
            $pdf = \PDF::loadView('admin.tables.export_pdf', compact('tables'));
            return $pdf->download('tables_' . date('Ymd_His') . '.pdf');
        } else {
            return back()->withErrors('Invalid export type.');
        }
    }
    public function index(Request $request)
    {
        $query = Table::query();
        // Search by table number
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('table_number', 'like', "%$search%");
        }
        $tables = $query->orderBy('id', 'desc')->paginate(10);
        // Example categories and prices
        $categories = ['Silver', 'Gold', 'Normal'];
        $prices = ['Silver' => 500, 'Gold' => 1000, 'Normal' => 300];
        return view('admin.tables.index', compact('tables', 'categories', 'prices'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
   {
    $request->validate([
        'table_number' => 'required|unique:tables,table_number',
        'capacity' => 'required|integer',
        'location' => 'required',
        'status' => 'required|in:available,occupied,reserved'
    ]);

    Table::create([
        'table_number' => $request->table_number,
        'capacity' => $request->capacity,
        'location' => $request->location,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.tables.index')
        ->with('success', 'Table Added Successfully');
    }
    
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'table_number' => 'required|unique:tables,table_number,' . $table->id,
            'capacity' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:Available,Reserved,Occupied',
        ]);

        $table->update($request->all());

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table updated successfully.');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table deleted successfully.');
    }
}
