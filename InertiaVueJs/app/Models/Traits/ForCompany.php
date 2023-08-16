<?php

namespace App\Models\Traits;

trait ForCompany
{
    public function forCompany()
    {
        return $this->where([
            $this->getQualifiedColumn('country_id') => authUser()->country_id,
            $this->getQualifiedColumn('company_id') => current_company_id(),
        ]);
    }

    public function createForCompany($data = [])
    {
        return $this->create([
            ...$data,
            'country_id' => authUser()->country_id,
            'company_id' => current_company_id(),
        ]);
    }

    public function findCompanyOrFail(int $id)
    {
        return $this->forCompany()->findOrFail($id);
    }

    private function getQualifiedColumn(string $field): string
    {
        return $this->model->getTable().'.'.$field;
    }
}
