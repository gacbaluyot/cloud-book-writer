<?php

namespace App\Http\Controllers;

use App\Services\SectionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected SectionService $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $sections = $this->sectionService->getAllSections();
        return view('sections.index', compact('sections'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $data = $this->sectionService->getDataForCreate();
        return view('sections.create', $data);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $section = $this->sectionService->storeSection([
            'book_id' => $request->get('book_id'),
            'parent_section_id' => $request->get('parent_section_id') ?? null,
            'title' => $request->get('title') ?? null,
            'content' => $request->get('content') ?? null
        ]);

        if ($section) {
            return redirect()->back()->with('success', 'Succesfully Created Section');
        } else {
            return redirect()->back()->with('error', 'Error in creating section.');
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        $section = $this->sectionService->getSectionById($id);
        return view('sections.show', compact('section'));
    }

    public function edit($id)
    {
        $data = $this->sectionService->getDataForEdit($id);
        return view('sections.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $section = $this->sectionService->updateSection($id, [
            'title' => $request->get('title'),
            'parent_section_id' => $request->get('parent_section_id'),
            'content' => $request->get('content')
        ]);

        if ($section) {
            return redirect()->back()->with('success', 'Successfully in updating section.');
        } else {
            return redirect()->back()->with('error', 'Error in updating section.');
        }
    }

    public function destroy($id)
    {
        $success = $this->sectionService->deleteSection($id);

        if ($success) {
            return redirect()->back()->with('success', 'Successfully in deleting section.');
        } else {
            return redirect()->back()->with('error', 'Error in deleting section.');
        }
    }

    public function getSectionsForBook(Book $book)
    {
        $sections = $this->sectionService->getSectionsForBook($book);
        return response()->json($sections);
    }
}
