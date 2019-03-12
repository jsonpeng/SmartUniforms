<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateBankSetsRequest;
use App\Http\Requests\UpdateBankSetsRequest;
use App\Repositories\BankSetsRepository;
use App\Repositories\ManagerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Repositories\RoleRepository;
use Hash;

class AdminSetsController extends AppBaseController
{
    /** @var  BankSetsRepository */
    private $managerRepository;
    private $roleRepository;

    public function __construct(ManagerRepository $managerRepo,RoleRepository $roleRepo)
    {
        $this->managerRepository = $managerRepo;
        $this->roleRepository=$roleRepo;
    }

    /**
     * Display a listing of the BankSets.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->managerRepository->pushCriteria(new RequestCriteria($request));
        $managers = $this->managerRepository->allManager();

        return view('admin.managers.index')
            ->with('managers', $managers);
    }

    /**
     * Show the form for creating a new BankSets.
     *
     * @return Response
     */
    public function create()
    {

        $roles = $this->roleRepository->all();
        return view('admin.managers.create')->with('roles',$roles);
    }

    /**
     * Store a newly created BankSets in storage.
     *
     * @param CreateBankSetsRequest $request
     *
     * @return Response
     */
    public function store(CreateBankSetsRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $bankSets = $this->managerRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('managers.index'));
    }

    /**
     * Display the specified BankSets.
     *
     * @param  int $id
     *
     * @return Response


    /**
     * Show the form for editing the specified BankSets.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $manager = $this->managerRepository->findWithoutFail($id);

        if (empty($manager)) {
            Flash::error('没有找到该管理员');

            return redirect(route('managers.index'));
        }
        $roles = $this->roleRepository->all();

        $selectedRoles = [];
        $tmparray = $manager->roles()->get()->toArray();
        while (list($key, $val) = each($tmparray)) {
            array_push($selectedRoles, $val['id']);
        }

        return view('admin.managers.edit')
            ->with('manager', $manager)
            ->with('roles', $roles)
            ->with('selectedRoles', $selectedRoles);

    }

    /**
     * Update the specified BankSets in storage.
     *
     * @param  int              $id
     * @param UpdateBankSetsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBankSetsRequest $request)
    {
        $input=$request->all();
        $manager = $this->managerRepository->findWithoutFail($id);

        if (empty($manager)) {
            Flash::error('管理员信息不存在');

            return redirect(route('managers.index'));
        }
        $input['password'] = Hash::make($input['password']);

        if (array_key_exists('roles', $input)) {
            $manager->roles()->sync($input['roles']);
        }else{
            $manager->roles()->sync([]);
        }
        $manager = $this->managerRepository->update($input, $id);



        Flash::success('保存成功.');

        return redirect(route('managers.index'));
    }

    /**
     * Remove the specified BankSets from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $manager = $this->managerRepository->findWithoutFail($id);

        if (empty($manager)) {
            Flash::error('没有找到该管理员');

            return redirect(route('managers.index'));
        }

        $this->managerRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('managers.index'));
    }
}
