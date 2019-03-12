<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateMachineIdeRequest;
use App\Http\Requests\UpdateMachineIdeRequest;
use App\Repositories\MachineIdeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MachineIdeController extends AppBaseController
{
    /** @var  MachineIdeRepository */
    private $machineIdeRepository;

    public function __construct(MachineIdeRepository $machineIdeRepo)
    {
        $this->machineIdeRepository = $machineIdeRepo;
    }

    /**
     * Display a listing of the MachineIde.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->machineIdeRepository->pushCriteria(new RequestCriteria($request));

        $input = $request->all();

        $input =array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        $tools=$this->varifyTools($input);

        $machineIdes=$this->defaultSearchState($this->machineIdeRepository->model());

        if(array_key_exists('id', $input)){
             $machineIdes =  $machineIdes->where('machine_id','like','%'.$input['id'].'%');
        }

        if(array_key_exists('name', $input)){
             $machineIdes =  $machineIdes->where('machine_name','like','%'.$input['name'].'%');
        }

        $machineIdes = $this->descAndPaginateToShow($machineIdes,'created_at','desc');

        return view('admin.machine_ides.index')
            ->with('machineIdes', $machineIdes)
            ->with('input',$input)
            ->with('tools',$tools);
    }

    /**
     * Show the form for creating a new MachineIde.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.machine_ides.create');
    }

    /**
     * Store a newly created MachineIde in storage.
     *
     * @param CreateMachineIdeRequest $request
     *
     * @return Response
     */
    public function store(CreateMachineIdeRequest $request)
    {
        $input = $request->all();

        $machineIde = $this->machineIdeRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('machineIdes.index'));
    }

    /**
     * Display the specified MachineIde.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $machineIde = $this->machineIdeRepository->findWithoutFail($id);

        if (empty($machineIde)) {
            Flash::error('没有找到该机器');

            return redirect(route('machineIdes.index'));
        }

        return view('admin.machine_ides.show')->with('machineIde', $machineIde);
    }

    /**
     * Show the form for editing the specified MachineIde.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $machineIde = $this->machineIdeRepository->findWithoutFail($id);

        if (empty($machineIde)) {
            Flash::error('没有找到该机器');

            return redirect(route('machineIdes.index'));
        }

        return view('admin.machine_ides.edit')->with('machineIde', $machineIde);
    }

    /**
     * Update the specified MachineIde in storage.
     *
     * @param  int              $id
     * @param UpdateMachineIdeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMachineIdeRequest $request)
    {
        $machineIde = $this->machineIdeRepository->findWithoutFail($id);

        if (empty($machineIde)) {
            Flash::error('没有找到该机器');

            return redirect(route('machineIdes.index'));
        }

        $machineIde = $this->machineIdeRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('machineIdes.index'));
    }

    /**
     * Remove the specified MachineIde from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $machineIde = $this->machineIdeRepository->findWithoutFail($id);

        if (empty($machineIde)) {
            Flash::error('没有找到该机器');

            return redirect(route('machineIdes.index'));
        }

        $this->machineIdeRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('machineIdes.index'));
    }
}
