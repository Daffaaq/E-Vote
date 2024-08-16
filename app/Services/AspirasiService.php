<?php

namespace App\Services;

use App\Repositories\AspirasiRepository;

class AspirasiService
{
    protected $repository;

    public function __construct(AspirasiRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAspirasi()
    {
        // to get all students
        return $this->repository->getAllAspirasi();
    }
    

    public function storeAspirasi(array $data)
    {
        $student = $this->repository->findByNis($data['nis']);

        if (!$student) {
            throw new \Exception('NIS yang Anda masukkan salah dan tidak terdaftar pada sistem!');
        }
        return $this->repository->store($data);
    }

    public function getAspirasiByUuid($uuid)
    {
        return $this->repository->findByUuid($uuid);
    }


    public function deleteAspirasi($uuid)
    {
        return $this->repository->delete($uuid);
    }
}
