<?php

namespace App\Services;

use App\Repositories\PeriodeRepository;

class PeriodeService
{
    protected $periodeRepository;

    public function __construct(PeriodeRepository $periodeRepository)
    {
        $this->periodeRepository = $periodeRepository;
    }

    public function getAllPeriode()
    {
        // to get all periode
        return $this->periodeRepository->getAll();
    }

    public function createPeriode($request)
    {
        // Check if period name already exists
        if ($this->periodeRepository->existsByName($request->periode_nama)) {
            return ['error' => 'Periode sudah ada'];
        }

        // Check if there is an active period
        if ($this->periodeRepository->actifExists() && $request->actif == 1) {
            return ['error' => 'Terdapat periode yang masih aktif. Silahkan Atur Status Non Aktif terlebih dahulu.'];
        }

        return $this->periodeRepository->create($request->all());
    }

    public function updatePeriode($request, $uuid)
    {
        // to find periode by uuid
        $periode = $this->periodeRepository->findByUUID($uuid);

        // Check if period name already exists
        if ($this->periodeRepository->existsByName($request->periode_nama)) {
            return ['error' => 'Periode sudah ada'];
        }

        // Check if there is an active period
        if ($this->periodeRepository->actifExists() && $request->actif == 1) {
            return ['error' => 'Terdapat periode yang masih aktif. Silahkan Atur Status Non Aktif terlebih dahulu.'];
        }

        $this->periodeRepository->update($periode, $request->all());
    }

    public function deletePeriode($uuid)
    {
        // to find periode by uuid
        $periode = $this->periodeRepository->findByUUID($uuid);
        // Check if period is active
        if ($periode->actif == 1) {
            return ['error' => 'Tidak boleh menghapus periode aktif'];
        }
        $this->periodeRepository->delete($periode);
    }
    public function findByUUID($uuid)
    {
        // to find periode by uuid
        return $this->periodeRepository->findByUUID($uuid);
    }
}
