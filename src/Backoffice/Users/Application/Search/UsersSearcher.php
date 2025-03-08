<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Search;

use MedineTech\Backoffice\Users\Domain\UserRepository;

class UsersSearcher
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function __invoke(UsersSearcherRequest $request): UsersSearcherResponse
    {
        $result = $this->repository->search($request->filters());

        return new UsersSearcherResponse(
            $result["items"] ?? [],
            $result["total"] ?? 0,
            $result["per_page"] ?? 20,
            $result["current_page"] ?? 1
        );
    }
}
