<?php

namespace App\Services\create;

use App\Contracts\IOrganizationRepository;
use App\DTO\OrganizationDTO;
use App\Exceptions\BusinessException;
use App\Models\Organization;
use App\Repositories\OrganizationRepository;

class CreateOrganizationService
{
    private IOrganizationRepository $repository;

    public function __construct()
    {
        $this->repository = new OrganizationRepository();
    }

    public function execute(OrganizationDTO $organizationDTO): Organization
    {
        $organizationWithName = $this->repository->getOrganizationByName($organizationDTO->getName());
        if ($organizationWithName !== null) {
            throw new BusinessException('Организация с таким названием уже существует.');
        }

        return $this->repository->createOrganization($organizationDTO);
    }
}
