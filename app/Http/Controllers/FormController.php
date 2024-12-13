<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    // لیست تمام فرم‌ها
    public function index()
    {
        $forms = Form::all();
        return response()->json($forms);
    }

    // نمایش یک فرم خاص
    public function show($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }
        return response()->json($form);
    }

    // ذخیره یک فرم جدید
    public function store(Request $request)
    {
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

        // آپلود تصویر در صورت وجود
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $form = Form::create($validated);

        return response()->json([
            'message' => 'Form created successfully',
            'form' => $form
        ], 201);
    }

    // به‌روزرسانی یک فرم
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

        // آپلود تصویر در صورت وجود
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $form->update($validated);

        return response()->json([
            'message' => 'Form updated successfully',
            'form' => $form
        ]);
    }

    // حذف یک فرم
    public function destroy($id)
    {
        $form = Form::find($id);
        if (!$form) {
            return response()->json(['message' => 'Form not found'], 404);
        }

        $form->delete();

        return response()->json(['message' => 'Form deleted successfully']);
    }
}
