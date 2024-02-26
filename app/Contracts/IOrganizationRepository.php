<?php

namespace App\Contracts;

use App\DTO\OrganizationDTO;
use App\Models\Organization;

interface IOrganizationRepository
{
    public function getOrganizationById(int $organizationId): ?Organization;

    public function getOrganizationByName(string $name): ?Organization;

    public function createOrganization(OrganizationDTO $organizationDTO): ?Organization;
}
