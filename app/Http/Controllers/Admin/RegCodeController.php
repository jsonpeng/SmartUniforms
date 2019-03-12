<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateRegCodeRequest;
use App\Http\Requests\UpdateRegCodeRequest;
use App\Repositories\RegCodeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RegCodeController extends AppBaseController
{
    /** @var  RegCodeRepository */
    private $regCodeRepository;

    public function __construct(RegCodeRepository $regCodeRepo)
    {
        $this->regCodeRepository = $regCodeRepo;
    }


    public function com(Request $request){
          return view('admin.reg_codes.com');
    }

    public function comAction(CreateRegCodeRequest $request){
        $price = $request->get('price');
        $this->regCodeRepository->model()::orderBy('created_at','desc')->update(['price'=>$price]);
        Flash::success('统一设置激活码价格成功.');

        return redirect(route('regCodes.index'));
    }


    /**
     * Display a listing of the RegCode.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->regCodeRepository->pushCriteria(new RequestCriteria($request));

        $regCodes=$this->defaultSearchState($this->regCodeRepository->model());

        $input=$request->all();
        $input =array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );
        $tools=$this->varifyTools($input);

        if(array_key_exists('code',$input)){
            
            $regCodes=$regCodes->where('code','like','%'.$input['code'].'%');
            
        }
        if(array_key_exists('status',$input)){
            if($input['status'] != '-1'){
                $regCodes=$regCodes->where('status',$input['status']);
            }
        }

        $regCodes = $this->descAndPaginateToShow($regCodes,'id','desc');

        return view('admin.reg_codes.index')
            ->with('regCodes', $regCodes)
            ->with('tools',$tools)
            ->with('input',$input);
    }

    /**
     * Show the form for creating a new RegCode.
     *
     * @return Response
     */
    public function create()
    {
        $code=$this->regCodeRepository->newCode();
        return view('admin.reg_codes.create')
                ->with('code',$code);
    }

    /**
     * Store a newly created RegCode in storage.
     *
     * @param CreateRegCodeRequest $request
     *
     * @return Response
     */
    public function store(CreateRegCodeRequest $request)
    {
        $input = $request->all();

        if(array_key_exists('num', $input)){
            $input['num']=$input['num']===1?0:$input['num'];
            #如果输入了数量 累加循环
            if(!empty($input['num'])){
               for($i=$input['num'];$i>=0;$i--){
                     //$input['code']=$this->regCodeRepository->newCode();
                     $this->regCodeRepository->create($input);
                     ++$input['code'];
               }
            }#没有输入数量或者只输入了1 就创建对应的一个
            else{
                 $regCode = $this->regCodeRepository->create($input);
            }
        }

        Flash::success('激活码创建成功.');

        return redirect(route('regCodes.index'));
    }

    /**
     * Display the specified RegCode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $regCode = $this->regCodeRepository->findWithoutFail($id);

        if (empty($regCode)) {
            Flash::error('Reg Code not found');

            return redirect(route('regCodes.index'));
        }

        return view('admin.reg_codes.show')->with('regCode', $regCode);
    }

    /**
     * Show the form for editing the specified RegCode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $regCode = $this->regCodeRepository->findWithoutFail($id);

        if (empty($regCode)) {
            Flash::error('Reg Code not found');

            return redirect(route('regCodes.index'));
        }

        return view('admin.reg_codes.edit')->with('regCode', $regCode);
    }

    /**
     * Update the specified RegCode in storage.
     *
     * @param  int              $id
     * @param UpdateRegCodeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegCodeRequest $request)
    {
        $regCode = $this->regCodeRepository->findWithoutFail($id);

        if (empty($regCode)) {
            Flash::error('Reg Code not found');

            return redirect(route('regCodes.index'));
        }

        $regCode = $this->regCodeRepository->update($request->all(), $id);

        Flash::success('激活码更新成功.');

        return redirect(route('regCodes.index'));
    }

    /**
     * Remove the specified RegCode from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $regCode = $this->regCodeRepository->findWithoutFail($id);

        if (empty($regCode)) {
            Flash::error('Reg Code not found');

            return redirect(route('regCodes.index'));
        }

        $this->regCodeRepository->delete($id);

        Flash::success('激活码删除成功.');

        return redirect(route('regCodes.index'));
    }
}
