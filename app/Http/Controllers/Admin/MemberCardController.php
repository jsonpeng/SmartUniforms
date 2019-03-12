<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateMemberCardRequest;
use App\Http\Requests\UpdateMemberCardRequest;
use App\Repositories\MemberCardRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use App\Models\MemberCard;

class MemberCardController extends AppBaseController
{
    /** @var  MemberCardRepository */
    private $memberCardRepository;

    public function __construct(MemberCardRepository $memberCardRepo)
    {
        $this->memberCardRepository = $memberCardRepo;
    }

    /**
     * Display a listing of the MemberCard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $input =array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        $tools=$this->varifyTools($input);

        $memberCards = MemberCard::orderBy('created_at', 'desc');

        if(array_key_exists('code', $input)){
             $memberCards =  $memberCards->where('code','like','%'.$input['code'].'%');
        }

        if(array_key_exists('mobile', $input)){
             $memberCards =  $memberCards->where('mobile','like','%'.$input['mobile'].'%');
        }

        if(array_key_exists('status', $input) && $input['status'] != '-1'){
             $memberCards =  $memberCards->where('status' , $input['status']);
        }


        $memberCards = $memberCards->paginate(18);

        return view('admin.member_cards.index')
            ->with('input',$input)
            ->with('tools',$tools)
            ->with('memberCards', $memberCards);
    }

    /**
     * Show the form for creating a new MemberCard.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.member_cards.create');
    }

    /**
     * Store a newly created MemberCard in storage.
     *
     * @param CreateMemberCardRequest $request
     *
     * @return Response
     */
    public function store(CreateMemberCardRequest $request)
    {
        $input = $request->all();

        $memberCard = $this->memberCardRepository->create($input);

        Flash::success('Member Card saved successfully.');

        return redirect(route('memberCards.index'));
    }

    /**
     * Display the specified MemberCard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $memberCard = $this->memberCardRepository->findWithoutFail($id);

        if (empty($memberCard)) {
            Flash::error('Member Card not found');

            return redirect(route('memberCards.index'));
        }

        return view('admin.member_cards.show')->with('memberCard', $memberCard);
    }

    /**
     * Show the form for editing the specified MemberCard.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $memberCard = $this->memberCardRepository->findWithoutFail($id);

        if (empty($memberCard)) {
            Flash::error('Member Card not found');

            return redirect(route('memberCards.index'));
        }

        return view('admin.member_cards.edit')->with('memberCard', $memberCard);
    }

    /**
     * Update the specified MemberCard in storage.
     *
     * @param  int              $id
     * @param UpdateMemberCardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMemberCardRequest $request)
    {
        $memberCard = $this->memberCardRepository->findWithoutFail($id);

        if (empty($memberCard)) {
            Flash::error('Member Card not found');

            return redirect(route('memberCards.index'));
        }

        $memberCard = $this->memberCardRepository->update($request->all(), $id);

        Flash::success('Member Card updated successfully.');

        return redirect(route('memberCards.index'));
    }

    /**
     * Remove the specified MemberCard from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $memberCard = $this->memberCardRepository->findWithoutFail($id);

        if (empty($memberCard)) {
            Flash::error('Member Card not found');

            return redirect(route('memberCards.index'));
        }

        $this->memberCardRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('memberCards.index'));
    }

    public function allDestroy()
    {
       
        $this->memberCardRepository->model()::orderBy('created_at','asc')->delete();

        Flash::success('全部删除成功.');

        return redirect(route('memberCards.index'));
    }
}
