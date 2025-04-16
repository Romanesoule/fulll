<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\Fleet\Fleet;
use Fulll\Domain\Fleet\FleetRepositoryInterface;
use Exception;

class CreateFleetCommand
{
    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $userId): string
    {
        $fleet = new Fleet($userId);

        if ($this->fleetRepository->exists($fleet->getId())) {
            throw new Exception("fleet already exists");
        }

        $this->fleetRepository->create($fleet);
        return $fleet->getId();
    }
}
