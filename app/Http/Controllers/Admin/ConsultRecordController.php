<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateConsultRecordRequest;
use App\Http\Requests\UpdateConsultRecordRequest;
use App\Repositories\ConsultRecordRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\AttachConsult;
use App\Models\School;

class ConsultRecordController extends AppBaseController
{
    /** @var  ConsultRecordRepository */
    private $consultRecordRepository;

    public function __construct(ConsultRecordRepository $consultRecordRepo)
    {
        $this->consultRecordRepository = $consultRecordRepo;
    }

    public function dealForm(Request $request,$id)
    {
        $input = $request->all();
        $consultRecord = $this->consultRecordRepository->findWithoutFail($id);

        if (empty($consultRecord)) {
            Flash::error('Consult Record not found');

            return redirect(route('consultRecords.index'));
        }

        $do = 0;

        if($consultRecord->do == 0){
            $do =1;
        }

         $consultRecord->update(
            [
                'do' => $do,
            ]
            );

         AttachConsult::where('consult_id',$consultRecord->id)->update(
            [
                'do' => $do,
            ]
            );

        Flash::success('处理成功.');

        return redirect(route('consultRecords.index'));
    }

    /**
     * Display a listing of the ConsultRecord.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->consultRecordRepository->pushCriteria(new RequestCriteria($request));

        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );
        
  
        $tools=$this->varifyTools($input);

        $consultRecords = $this->consultRecordRepository->model()::where('id','>',0);

        if (array_key_exists('schools_name', $input)) {
            $consultRecords = $consultRecords->where('school_name',$input['schools_name']);
        }

        if (array_key_exists('type', $input)) {
            $consultRecords = $consultRecords->where('type',$input['type']);
        }

        if (array_key_exists('class', $input)) {
            $consultRecords = $consultRecords->where('class','like','%'.$input['class'].'%');
        }

        if (array_key_exists('name', $input)) {
            $consultRecords = $consultRecords->where('name','like','%'.$input['name'].'%');
        }

        $consultRecords =  $this->descAndPaginateToShow($consultRecords,'created_at','desc');

        $schools = School::all();
        return view('admin.consult_records.index')
            ->with('consultRecords', $consultRecords)
            ->with('schools',$schools)
            ->with('tools',$tools)
            ->with('input',$input);
    }

    /**
     * Show the form for creating a new ConsultRecord.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.consult_records.create');
    }

    /**
     * Store a newly created ConsultRecord in storage.
     *
     * @param CreateConsultRecordRequest $request
     *
     * @return Response
     */
    public function store(CreateConsultRecordRequest $request)
    {
        $input = $request->all();

        $consultRecord = $this->consultRecordRepository->create($input);

        Flash::success('Consult Record saved successfully.');

        return redirect(route('consultRecords.index'));
    }

    /**
     * Display the specified ConsultRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $consultRecord = $this->consultRecordRepository->findWithoutFail($id);

        if (empty($consultRecord)) {
            Flash::error('Consult Record not found');

            return redirect(route('consultRecords.index'));
        }

        return view('admin.consult_records.show')->with('consultRecord', $consultRecord);
    }

    /**
     * Show the form for editing the specified ConsultRecord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $consultRecord = $this->consultRecordRepository->findWithoutFail($id);

        if (empty($consultRecord)) {
            Flash::error('Consult Record not found');

            return redirect(route('consultRecords.index'));
        }
        $records = AttachConsult::where('consult_id',$consultRecord->id)->get();
        return view('admin.consult_records.edit')
        ->with('consultRecord', $consultRecord)
        ->with('records',$records);
    }

    /**
     * Update the specified ConsultRecord in storage.
     *
     * @param  int              $id
     * @param UpdateConsultRecordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConsultRecordRequest $request)
    {
        $input = $request->all();
        $consultRecord = $this->consultRecordRepository->findWithoutFail($id);

        if (empty($consultRecord)) {
            Flash::error('Consult Record not found');

            return redirect(route('consultRecords.index'));
        }

         $consultRecord->update(
            [
                'name' => $input['name'],
                'class'=>$input['class'],
                'shengao'=>$input['shengao'],
                'tizhong'=>$input['tizhong'],
                'remark'=>$input['remark'],
                'school_name'=>$input['school_name']
            ]
            );

        if(isset($input['pname']) && isset($input['chima'])){
                    #先滞空
                    AttachConsult::where('consult_id',$consultRecord->id)->delete();
                    #然后加
                    
                    if(count($input['pname']) && count($input['chima']) && count($input['zengding']) && count($input['tuihui'])){
                        $i = 0;
                        foreach ($input['pname'] as $key => $value) {
                            AttachConsult::create(
                                [
                                    'consult_id'=>$consultRecord->id,
                                    'pname' => $input['pname'][$i],
                                    'chima' => $input['chima'][$i],
                                    'zengding' => $input['zengding'][$i],
                                    'tuihui' => $input['tuihui'][$i],
                                    'price' => $input['price'][$i]
                                ]
                            );
                            $i++;
                        }
                    }
        }

        Flash::success('保存成功.');

        return redirect(route('consultRecords.index'));
    }

    /**
     * Remove the specified ConsultRecord from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $consultRecord = $this->consultRecordRepository->findWithoutFail($id);

        if (empty($consultRecord)) {
            Flash::error('Consult Record not found');

            return redirect(route('consultRecords.index'));
        }

        $this->consultRecordRepository->delete($id);
        
        #先滞空
        AttachConsult::where('consult_id',$id)->delete();

        Flash::success('删除成功.');

        return redirect(route('consultRecords.index'));
    }
}
