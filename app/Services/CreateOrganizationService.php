<?php

namespace App\Services;

use App\Contracts\IOrganizationRepository;
use App\DTO\OrganizationDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\OrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\UserResource;
use App\Models\Organization;
use App\Models\User;
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
