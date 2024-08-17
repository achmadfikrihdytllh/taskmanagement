<?php namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\RESTful\ResourceController;

class TaskController extends ResourceController
{
    protected $modelName = TaskModel::class;
    protected $format    = 'json';

    private $taskModel;

    public function __construct()
    {
        parent::__construct();
        $this->taskModel = new TaskModel();
    }

    public function index()
    {
        $tasks = $this->taskModel->findAll();
        return $this->respond($tasks);
    }

    public function show($id = null)
    {
        $task = $this->taskModel->find($id);
        if (!$task) {
            return $this->failNotFound('Task not found');
        }
        return $this->respond($task);
    }

    public function create()
    {
        $data = $this->request->getPost();
    
        if (!$this->taskModel->insert($data)) {
            return $this->fail($this->taskModel->errors());
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Task created successfully',
            'data'    => $data,
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $task = $this->taskModel->find($id);
        if (!$task) {
            return $this->failNotFound('Task not found');
        }

        if (!$this->taskModel->update($id, $data)) {
            return $this->fail($this->taskModel->errors());
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Task updated successfully',
            'data'    => $data,
        ]);
    }

    public function delete($id = null)
    {
        if (!$this->taskModel->find($id)) {
            return $this->failNotFound('Task not found');
        }

        $this->taskModel->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
}
