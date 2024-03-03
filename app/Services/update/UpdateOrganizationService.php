<?php

namespace App\Services\update;

use App\Contracts\IOrganizationRepository;
use App\DTO\OrganizationDTO;
use App\Exceptions\BusinessException;
use App\Models\Organization;
use App\Repositories\OrganizationRepository;

class UpdateOrganizationService
{
    private IOrganizationRepository $repository;

    public function __construct()
    {
        $this->repository = new OrganizationRepository();
    }

    public function execute(OrganizationDTO $organizationDTO, Organization $organization): Organization
    {
        $organizationWithName = $this->repository->getOrganizationByName($organizationDTO->getName());
//        dd($organizationWithName->name);
        if ($organizationWithName !== null) {
            throw new BusinessException('Организация с таким названием уже существует.');
        } else if ($organization->name !== $organizationDTO->getName()) {
//            dd($organization->name);
//            dd($organizationDTO->getName());
            return $this->repository->updateOrganization($organizationDTO, $organization);
        }
    }
}
