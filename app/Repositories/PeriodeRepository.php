<?php

namespace App\Repositories;

use App\Models\Periode;

class PeriodeRepository
{
    public function getAll()
    {
        return Periode::select('id', 'uuid', 'periode_nama', 'periode_kepala_sekolah', 'periode_no_kepala_sekolah', 'actif')->get();
    }

    public function create($data)
    {
        return Periode::create($data);
    }

    public function findByUUID($uuid)
    {
        return Periode::where('uuid', $uuid)->firstOrFail();
    }

    public function update($periode, $data)
    {
        return $periode->update($data);
    }

    public function delete($periode)
    {
        return $periode->delete();
    }

    public function existsByName($name, $excludeUuid = null)
    {
        // Mulai query untuk mencari periode dengan nama yang sama
        $query = Periode::where('periode_nama', $name);

        // Jika ada UUID yang harus dikecualikan, tambahkan pengecualian pada query
        if (!is_null($excludeUuid)) {
            $query->where('uuid', '!=', $excludeUuid);
        }

        // Kembalikan apakah ada periode lain dengan nama yang sama (dengan pengecualian UUID)
        return $query->exists();
    }


    public function actifExists()
    {
        return Periode::where('actif', 1)->exists();
    }
}
