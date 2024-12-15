<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return response()->json($forms);
    }

    public function show($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }
        return response()->json($form);
    }

    public function store(Request $request)
    {
        $existingUser = Form::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->first();

        if ($existingUser) {
            return response()->json(['error' => 'This combination of first name and last name already exists'], 400);
        }


        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'course' => 'required|in:.net developer,php developer,python developer,vue js developer,java developer,react developer,UX/UI designer',
            'course_number' => 'required|integer',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'role' => 'required|in:mentor,student',
            'photo' => 'nullable|image|max:2048',
        ]);


        $form = Form::create($validated);

        $this->handleImageUpload($request, $form);


        return response()->json([
            'message' => 'Form created successfully',
            'form' => $form
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'course' => 'nullable|in:.net developer,php developer,python developer,vue js developer,java developer,react developer,UX/UI designer',
            'course_number' => 'nullable|integer',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'role' => 'nullable|in:mentor,student',
            'photo' => 'nullable|image|max:2048',
        ]);

        $this->handleImageUpload($request, $form);

        $form->update($validated);

        return response()->json([
            'message' => 'Form updated successfully',
            'form' => $form
        ]);
    }

    public function destroy($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }

        $form->delete();

        return response()->json(['message' => 'Form deleted successfully']);
    }

    private function handleImageUpload(Request $request, Form $form, string $collection = 'image'): void
    {
        if ($request->hasFile('image')) {
            $form->clearMediaCollection($collection);
            $form->addMedia($request->file('image'))->toMediaCollection($collection);
        }
    }

    public function imageUpdate(Request $request, int $id): JsonResponse
    {
        $form = Form::findOrFail($id);
        $this->handleImageUpload($request, $form, 'image');

        return response()->json(['message' => 'Form image updated successfully.']);
    }
}
