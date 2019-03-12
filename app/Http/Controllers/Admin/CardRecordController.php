<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateCardRecordRequest;
use App\Http\Requests\UpdateCardRecordRequest;
use App\Repositories\CardRecordRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Maatwebsite\Excel\Facades\Excel;

class CardRecordController extends AppBaseController
{
    /** @var  CardRecordRepository */
    private $cardRecordRepository;

    public function __construct(CardRecordRepository $cardRecordRepo)
    {
        $this->cardRecordRepository = $cardRecordRepo;
    }

    /**
     * Display a listing of the CardRecord.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->cardRecordRepository->pushCriteria(new RequestCriteria($request));
        $input = $request->all();

        $input =array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        $tools=$this->varifyTools($input);

        $cardRecords=$this->defaultSearchState($this->cardRecordRepository->model());

         if(array_key_exists('id', $input)){
             $cardRecords =  $cardRecords->where('card_id','like','%'.$input['id'].'%');
        }

        if(array_key_exists('remark', $input)){
             $cardRecords =  $cardRecords->where('remark','like','%'.$input['remark'].'%');
        }

        $cardRecords = $this->descAndPaginateToShow($cardRecords,'created_at','desc');

        return view('admin.card_records.index')
            ->with('input',$input)
            ->with('tools',$tools)
            ->with('cardRecords', $cardRecords);
    }

    /**
     * Show the form for creating a new CardRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.card_records.create');
    }

    /**
     * Store a newly created CardRecord in storage.
     *
     * @param CreateCardRecordRequest $request
     *
     * @return Response
     */
    public function store(CreateCardRecordRequest $request)
    {
        $input = $request->all();

        $cardRecord = $this->cardRecordRepository->create($input);

        Flash::success('Card Record saved successfully.');

        return redirect(route('cardRecords.index'));
    }

    /**
     * Display the specified CardRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cardRecord = $this->cardRecordRepository->findWithoutFail($id);

        if (empty($cardRecord)) {
            Flash::error('没有找到该条记录');

            return redirect(route('cardRecords.index'));
        }

        return view('admin.card_records.show')->with('cardRecord', $cardRecord);
    }

    /**
     * Show the form for editing the specified CardRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cardRecord = $this->cardRecordRepository->findWithoutFail($id);

        if (empty($cardRecord)) {
            Flash::error('没有找到该条记录');

            return redirect(route('cardRecords.index'));
        }

        return view('admin.card_records.edit')->with('cardRecord', $cardRecord);
    }

    /**
     * Update the specified CardRecord in storage.
     *
     * @param  int              $id
     * @param UpdateCardRecordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCardRecordRequest $request)
    {
        $cardRecord = $this->cardRecordRepository->findWithoutFail($id);

        if (empty($cardRecord)) {
            Flash::error('没有找到该条记录');

            return redirect(route('cardRecords.index'));
        }

        $cardRecord = $this->cardRecordRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('cardRecords.index'));
    }

    /**
     * Remove the specified CardRecord from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cardRecord = $this->cardRecordRepository->findWithoutFail($id);

        if (empty($cardRecord)) {
            Flash::error('没有找到该条记录');

            return redirect(route('cardRecords.index'));
        }

        $this->cardRecordRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('cardRecords.index'));
    }


    public function report($id){
        $cardRecord = $this->cardRecordRepository->findWithoutFail($id);

        if (empty($cardRecord)) {
            Flash::error('没有找到该条记录');

            return redirect(route('cardRecords.index'));
        }

        $card_id=$cardRecord->card_id;
        Excel::create('读卡器ID'.$card_id.'报告', function($excel) use($cardRecord) {
            // 第一列sheet
            $excel->sheet('读卡器详情', function($sheet) use($cardRecord) {
                $sheet->setWidth(array(
                    'A'     =>  11,
                    'B'     =>  40,
                    'C'     =>  20,
                    'D'     =>  30,
                    'E'     =>  20
                ));
                $sheet->appendRow(array('读卡器ID', '读取到的信息', '位置信息', '别名', '读取到的时间'));
                 
                    $sheet->appendRow(array(
                        $cardRecord->id, //读卡器ID
                        $cardRecord->content, //读取到的信息
                        $cardRecord->location, //位置信息
                        $cardRecord->remark, //别名
                        $cardRecord->created_at //读取到的时间
                    ));
            });
  
        })->download('xls');


    }
}
