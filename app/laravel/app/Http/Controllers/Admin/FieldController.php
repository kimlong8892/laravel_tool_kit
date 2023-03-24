<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Field\FieldStoreRequest;
use App\Http\Requests\Field\FieldUpdateRequest;
use App\Repositories\Field\FieldRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FieldController extends Controller {
    protected FieldRepositoryInterface $fieldRepository;

    public function __construct(FieldRepositoryInterface $fieldRepository) {
        $this->fieldRepository = $fieldRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View {
        $listField = $this->fieldRepository->getListInAdmin();

        return view('admin.field.index', compact('listField'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View {
        return view('admin.field.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FieldStoreRequest $request
     * @return RedirectResponse
     */
    public function store(FieldStoreRequest $request): RedirectResponse {
        try {
            $fieldId = $this->fieldRepository->store($request->all());

            return redirect()->route('admin.fields.edit', $fieldId)
                ->with('success', __('Create success', ['id' => $fieldId]));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View {
        $field = $this->fieldRepository->getDetail($id);

        return view('admin.field.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FieldUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(FieldUpdateRequest $request, int $id): RedirectResponse {
        try {
            $fieldId = $this->fieldRepository->update($id, $request->all());

            return redirect()->route('admin.fields.edit', $fieldId)
                ->with('success', __('Update success', ['id' => $fieldId]));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
