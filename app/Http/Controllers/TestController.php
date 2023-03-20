<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTestRequest;
use App\Models\Doctor;
use App\Models\Test;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestController extends Controller
{
    public function index(): View
    {
        $tests = Test::with('referringDoctor')->orderBy('updated_at', 'desc')->paginate(100);

        return view('tests.index', compact('tests'));
    }

    public function create(): View
    {
        $doctors = Doctor::all();

        return view('tests.create', compact('doctors'));
    }

    public function store(StoreTestRequest $request): RedirectResponse
    {
        Test::create($request->validated());

        return redirect()->route('tests.index')->with('success', 'Test created successfully.');
    }
}
