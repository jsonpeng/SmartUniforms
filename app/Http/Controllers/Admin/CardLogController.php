<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateCardLogRequest;
use App\Http\Requests\UpdateCardLogRequest;
use App\Repositories\CardLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CardLogController extends AppBaseController
{
    /** @var  CardLogRepository */
    private $cardLogRepository;

    public function __construct(CardLogRepository $cardLogRepo)
    {
        $this->cardLogRepository = $cardLogRepo;
    }

    /**
     * Display a listing of the CardLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->cardLogRepository->pushCriteria(new RequestCriteria($request));
        $cardLogs = $this->cardLogRepository->all();

        return view('card_logs.index')
            ->with('cardLogs', $cardLogs);
    }

    /**
     * Show the form for creating a new CardLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('card_logs.create');
    }

    /**
     * Store a newly created CardLog in storage.
     *
     * @param CreateCardLogRequest $request
     *
     * @return Response
     */
    public function store(CreateCardLogRequest $request)
    {
        $input = $request->all();

        $cardLog = $this->cardLogRepository->create($input);

        Flash::success('Card Log saved successfully.');

        return redirect(route('cardLogs.index'));
    }

    /**
     * Display the specified CardLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cardLog = $this->cardLogRepository->findWithoutFail($id);

        if (empty($cardLog)) {
            Flash::error('Card Log not found');

            return redirect(route('cardLogs.index'));
        }

        return view('card_logs.show')->with('cardLog', $cardLog);
    }

    /**
     * Show the form for editing the specified CardLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cardLog = $this->cardLogRepository->findWithoutFail($id);

        if (empty($cardLog)) {
            Flash::error('Card Log not found');

            return redirect(route('cardLogs.index'));
        }

        return view('card_logs.edit')->with('cardLog', $cardLog);
    }

    /**
     * Update the specified CardLog in storage.
     *
     * @param  int              $id
     * @param UpdateCardLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCardLogRequest $request)
    {
        $cardLog = $this->cardLogRepository->findWithoutFail($id);

        if (empty($cardLog)) {
            Flash::error('Card Log not found');

            return redirect(route('cardLogs.index'));
        }

        $cardLog = $this->cardLogRepository->update($request->all(), $id);

        Flash::success('Card Log updated successfully.');

        return redirect(route('cardLogs.index'));
    }

    /**
     * Remove the specified CardLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cardLog = $this->cardLogRepository->findWithoutFail($id);

        if (empty($cardLog)) {
            Flash::error('Card Log not found');

            return redirect(route('cardLogs.index'));
        }

        $this->cardLogRepository->delete($id);

        Flash::success('Card Log deleted successfully.');

        return redirect(route('cardLogs.index'));
    }
}
