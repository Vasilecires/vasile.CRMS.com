<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class OrganizationDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function index(Organization $organization)
    {
        return view('control-panel.organizations.show.documents', [
            'organization' => $organization,
            'documents' => $organization->media()->latest()->paginate(10),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Document\StoreDocumentRequest  $request
     * @param  \App\Models\Organization  $Organization
     * @param  \App\Services\DocumentService  $documentService
     * @return \Illuminate\Http\Response
     */
    public function store(Organization $organization, Request $request, DocumentService $documentService)
    {
        try {
            $documentService->store($organization, $request->file('document'));
            session()->flash('success', 'File uploaded successfully');
        }
        catch (UploadException $exception) {
            session()->flash('error', 'Failed to upload the file');
        }

        return redirect()->back();
    }
}
