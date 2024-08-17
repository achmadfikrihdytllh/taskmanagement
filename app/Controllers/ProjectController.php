<?php namespace App\Controllers;

use App\Models\ProjectModel;
use CodeIgniter\RESTful\ResourceController;

class ProjectController extends ResourceController
{
    protected $modelName = 'App\Models\ProjectModel';
    protected $format    = 'json';

    public function index()
    {
        $projects = $this->model->findAll();
        return $this->respond($projects);
    }

    public function show($id = null)
    {
        $project = $this->model->find($id);
        if (!$project) {
            return $this->failNotFound('Project not found');
        }
        return $this->respond($project);
    }

    public function create()
    {
        $projectModel = new ProjectModel();
        $data = $this->request->getPost();
    
        if (!$projectModel->insert($data)) {
            return $this->fail($projectModel->errors());
        }

        return $this->respondCreated([
            'status' => 201,
            'message' => 'project created successfully',
            'data' => $data,
        ]);
    }
    
    public function update($id = null)
    {
        $model = new ProjectModel();
        $data = $this->request->getJSON();
        $project = $model->find($id);
        if (!$project) {
            return $this->failNotFound('Project not found');
        }
    
        // Perbarui data pengguna
        if (!$model->update($id, $data)) {
            return $this->fail($model->errors());
        }
    
        // Kembalikan respon berhasil
        return $this->respondUpdated([
            'status' => 200,
            'message' => 'Project updated successfully',
            'data' => $data
        ]);
    }

    public function delete($id = null)
    {
        $project=new ProjectModel();
        $project->delete($id);
        // $this->model->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
}