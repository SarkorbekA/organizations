<?php

namespace App\Repositories;

use App\Contracts\IOrganizationRepository;
use App\DTO\OrganizationDTO;
use App\Models\Organization;
use App\Models\User;


class OrganizationRepository implements IOrganizationRepository
{
    public function getOrganizationById(int $organizationId): ?Organization
    {
        /** @var Organization|null $organization */
        $organization = Organization::query()->find($organizationId);
        return $organization;
    }

    public function createOrganization(OrganizationDTO $organizationDTO): Organization
    {
        $organization = new Organization();
        $organization->name = $organizationDTO->getName();
        $organization->country = $organizationDTO->getCountry();
        $organization->address = $organizationDTO->getAddress();
        $organization->save();

        return $organization;
    }

    public function getOrganizationByName(string $name): ?Organization
    {
        /** @var Organization|null $organization */
        $organization = Organization::query()->where('name', $name)->first();

        return $organization;
    }
}
