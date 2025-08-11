<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all();

        return view('projects.add', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'responsible' => 'required|exists:users,id',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'user_id' => auth()->id(),
        ]);

        // Registrar responsable
        ProjectUser::create([
            'project_id' => $project->id,
            'user_id' => $request->responsible,
            'role' => 'responsable',
        ]);

        // Registrar integrantes
        foreach ($request->members as $memberId) {
            if ($memberId != $request->responsible) {
                ProjectUser::create([
                    'project_id' => $project->id,
                    'user_id' => $memberId,
                    'role' => 'integrante',
                ]);
            }
        }

        return redirect()->route('projects.index')->with([
            'message' => 'Proyecto creado correctamente',
            'typealert' => 'success'
        ]);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $responsable = ProjectUser::where('project_id', $id)->where('role', 'responsable')->first();
        $integrantes = ProjectUser::where('project_id', $id)->where('role', 'integrante')->get();
        $responsableUser = $responsable ? User::find($responsable->user_id) : null;
        $integranteUsers = $integrantes->map(function($pu){ return User::find($pu->user_id); });
        return view('projects.show', [
            'project' => $project,
            'responsable' => $responsableUser,
            'integrantes' => $integranteUsers,
        ]);
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $users = User::all();
        $responsible = ProjectUser::where('project_id', $id)->where('role', 'responsable')->value('user_id');
        $members = ProjectUser::where('project_id', $id)->where('role', 'integrante')->pluck('user_id')->toArray();
        return view('projects.edit', compact('project', 'users', 'responsible', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'responsible' => 'required|exists:users,id',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
        ]);

        // Actualizar responsable
        ProjectUser::where('project_id', $id)->where('role', 'responsable')->delete();
        ProjectUser::create([
            'project_id' => $id,
            'user_id' => $request->responsible,
            'role' => 'responsable',
        ]);

        // Actualizar integrantes
        ProjectUser::where('project_id', $id)->where('role', 'integrante')->delete();
        foreach ($request->members as $memberId) {
            if ($memberId != $request->responsible) {
                ProjectUser::create([
                    'project_id' => $id,
                    'user_id' => $memberId,
                    'role' => 'integrante',
                ]);
            }
        }

        return redirect()->route('projects.index')->with([
            'message' => 'Proyecto actualizado correctamente',
            'typealert' => 'success'
        ]);
    }

    public function destroy($id)
    {
        // Logic to delete a specific project
    }
}
