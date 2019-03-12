<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttachConsultRequest;
use App\Http\Requests\UpdateAttachConsultRequest;
use App\Repositories\AttachConsultRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AttachConsultController extends AppBaseController
{
    /** @var  AttachConsultRepository */
    private $attachConsultRepository;

    public function __construct(AttachConsultRepository $attachConsultRepo)
    {
        $this->attachConsultRepository = $attachConsultRepo;
    }

    /**
     * Display a listing of the AttachConsult.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->attachConsultRepository->pushCriteria(new RequestCriteria($request));
        $attachConsults = $this->attachConsultRepository->all();

        return view('attach_consults.index')
            ->with('attachConsults', $attachConsults);
    }

    /**
     * Show the form for creating a new AttachConsult.
     *
     * @return Response
     */
    public function create()
    {
        return view('attach_consults.create');
    }

    /**
     * Store a newly created AttachConsult in storage.
     *
     * @param CreateAttachConsultRequest $request
     *
     * @return Response
     */
    public function store(CreateAttachConsultRequest $request)
    {
        $input = $request->all();

        $attachConsult = $this->attachConsultRepository->create($input);

        Flash::success('Attach Consult saved successfully.');

        return redirect(route('attachConsults.index'));
    }

    /**
     * Display the specified AttachConsult.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attachConsult = $this->attachConsultRepository->findWithoutFail($id);

        if (empty($attachConsult)) {
            Flash::error('Attach Consult not found');

            return redirect(route('attachConsults.index'));
        }

        return view('attach_consults.show')->with('attachConsult', $attachConsult);
    }

    /**
     * Show the form for editing the specified AttachConsult.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attachConsult = $this->attachConsultRepository->findWithoutFail($id);

        if (empty($attachConsult)) {
            Flash::error('Attach Consult not found');

            return redirect(route('attachConsults.index'));
        }

        return view('attach_consults.edit')->with('attachConsult', $attachConsult);
    }

    /**
     * Update the specified AttachConsult in storage.
     *
     * @param  int              $id
     * @param UpdateAttachConsultRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttachConsultRequest $request)
    {
        $attachConsult = $this->attachConsultRepository->findWithoutFail($id);

        if (empty($attachConsult)) {
            Flash::error('Attach Consult not found');

            return redirect(route('attachConsults.index'));
        }

        $attachConsult = $this->attachConsultRepository->update($request->all(), $id);

        Flash::success('Attach Consult updated successfully.');

        return redirect(route('attachConsults.index'));
    }

    /**
     * Remove the specified AttachConsult from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attachConsult = $this->attachConsultRepository->findWithoutFail($id);

        if (empty($attachConsult)) {
            Flash::error('Attach Consult not found');

            return redirect(route('attachConsults.index'));
        }

        $this->attachConsultRepository->delete($id);

        Flash::success('Attach Consult deleted successfully.');

        return redirect(route('attachConsults.index'));
    }
}
