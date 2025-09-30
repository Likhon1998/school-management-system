<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function __construct()
    {
        // Ensure you have permission middleware for these actions
        $this->middleware('permission:view permissions')->only('index', 'show');
        $this->middleware('permission:edit permissions')->only('edit', 'update');
        $this->middleware('permission:create permissions')->only('create', 'store');
        $this->middleware('permission:delete permissions')->only('destroy');
    }

    // This method will show the permissions page
    public function index(Request $request)
{
    $query = Permission::query();

    // Check if search query exists
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('name', 'like', "%{$search}%");
    }

    // Paginate results
    $permissions = $query->orderBy('id', 'desc')->paginate(25);

    return view('permissions.list', compact('permissions'));
}


    // This method will show the create permission page
    public function create()
    {
        return view('permissions.create');
    }

    // This method will insert a permission in DB
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions|min:3'
        ]);

        if ($validated) {
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->save();

            return redirect()->route('permissions.index')->with('success', 'Permission added successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validated);
        }
    }

    // This method will show the edit permission page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', ['OurPermission' => $permission]);
    }

    // This method will update the permission in DB
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions|min:3'
        ]);

        if ($validated) {
            $permission = Permission::findOrFail($id);
            $permission->name = $request->name;
            $permission->save();

            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validated);
        }
    }

    // This method will delete the permission from the DB
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
    }
}


