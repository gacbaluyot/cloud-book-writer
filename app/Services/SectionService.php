<?php

namespace App\Services;

use App\Models\Section;
use App\Models\SectionClosure;
use App\Models\Book;

/**
 * Class SectionService
 *
 * This service handles the business logic related to the management of book sections.
 *
 * @package App\Services

 */
class SectionService
{
    /**
     * Stores a new section.
     *
     * This method is responsible for storing a new section and setting up
     * its relationship in the closure table, if it has a parent.
     *
     * @param array $data Associative array containing data about the section.
     * @return Section The created section.
     */
    public function storeSection(array $data): Section
    {
        //... logic for storing a section
        // 1. Store the new section

        $section = new Section();
        $section->book_id = $data['book_id'];
        $section->title = $data['title'];
        $section->content = $data['content'];
        $section->save();

        // 2. Store the closure relationships
        // The section is an ancestor of itself with a depth of 0
        $closureSelf = new SectionClosure();
        $closureSelf->ancestor = $section->id;
        $closureSelf->descendant = $section->id;
        $closureSelf->depth = 0;
        $closureSelf->save();

        if (isset($data['parent_section_id']) && $data['parent_section_id']) {
            $parentClosures = SectionClosure::where('descendant', $data['parent_section_id'])->get();
            // Get the parent's closure entries

            foreach ($parentClosures as $parentClosure) {
                $existingRelation = SectionClosure::where('ancestor', $parentClosure->ancestor)
                    ->where('descendant', $section->id)
                    ->first();

                // Check if the direct ancestor entry already exists

                if (!$existingRelation) {
                    $closure = new SectionClosure();
                    $closure->ancestor = $parentClosure->ancestor;
                    $closure->descendant = $section->id;
                    $closure->depth = $parentClosure->depth + 1;
                    $closure->save();
                }
            }
            // Check if the direct ancestor entry already exists
            $directRelationExists = SectionClosure::where('ancestor', $data['parent_section_id'])
                ->where('descendant', $section->id)
                ->first();

            if (!$directRelationExists) {
                // Insert the direct ancestor entry
                $directAncestor = new SectionClosure();
                $directAncestor->ancestor = $data['parent_section_id'];
                $directAncestor->descendant = $section->id;
                $directAncestor->depth = 1;
                $directAncestor->save();
            }
        }

        return $section;
    }

    /**
     * Updates an existing section.
     *
     * This method updates an existing section. If the parent section has changed,
     * it re-establishes the closure table relationships accordingly.
     *
     * @param int $id The ID of the section to be updated.
     * @param array $data Associative array containing data to update.
     * @return Section The updated section.
     */
    public function updateSection(int $id, array $data): Section
    {
        $section = Section::find($id);

        if ($section->parent_id && $section->parent_section_id != $data['parent_section_id']) {
            SectionClosure::where('descendant', $section->id)->delete();

            SectionClosure::create([
                'ancestor' => $section->id,
                'descendant' => $section->id,
                'depth' => 0
            ]);

            if (isset($data['parent_section_id'])) {
                $parent_id = $data['parent_section_id'];
                $ancestorsOfParent = SectionClosure::where('descendant', $parent_id)->get();

                foreach ($ancestorsOfParent as $ancestor) {
                    SectionClosure::create([
                        'ancestor' => $ancestor->ancestor,
                        'descendant' => $section->id,
                        'depth' => $ancestor->depth + 1
                    ]);
                }

                SectionClosure::firstOrCreate([
                    'ancestor' => $parent_id,
                    'descendant' => $section->id,
                    'depth' => 1
                ]);
            }
        }

        $section->title = $data['title'];
        $section->content = $data['content'];
        $section->save();

        return $section;
    }

    /**
     * Deletes a section.
     *
     * This method deletes a section and its associated closure table entries.
     *
     * @param int $id The ID of the section to be deleted.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteSection(int $id): bool
    {
        //... logic for deleting a section
        $section = Section::find($id);

        if ($section) {
            // 1. Find all descendants of the ancestor.
            $descendants = SectionClosure::where('ancestor', $id)
                ->where('depth', '>', 0)
                ->pluck('descendant')
                ->toArray();

            // Add the ancestor to the list (to delete its relations too)
            $descendants[] = $id;

            // 2. Delete the corresponding closure table entries for the descendants and ancestor.
            SectionClosure::whereIn('descendant', $descendants)->delete();
            SectionClosure::whereIn('ancestor', $descendants)->delete();

            // 3. Delete the descendants (and ancestor) from the `sections` table.
            Section::whereIn('id', $descendants)->delete();

            return true;
        }

        return false;
    }

    /**
     * Retrieves all sections for a given book.
     *
     * This method fetches all the sections associated with a particular book.
     *
     * @param Book $book The book entity to fetch sections for.
     * @return \Illuminate\Support\Collection Collection of sections.
     */
    public function getSectionsForBook(Book $book): \Illuminate\Support\Collection
    {
        //... logic for retrieving sections for a book
        return $book->sections;
    }

    /**
     * Retrieve all sections from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllSections(): \Illuminate\Database\Eloquent\Collection|static
    {
        return Section::all();
    }

    /**
     * @return array{section: mixed, books: \Illuminate\Database\Eloquent\Collection, sections: mixed}
     */
    public function getDataForEdit($id): array
    {
        $section = Section::find($id);
        $books = Book::all();
        $sections = Section::where('id', '!=', $id)->get(); // Exclude the section being edited

        return [
            'section' => $section,
            'books' => $books,
            'sections' => $sections
        ];
    }

}
