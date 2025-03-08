<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Search;

use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use function Lambdish\Phunctional\map;

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
            map(function (User $user) {
                return new UserSearcherResponse(
                    $user->id(),
                    $user->name(),
                    $user->email()
                );
            }, $result["items"]),
            $result["total"],
            $result["per_page"],
            $result["current_page"]
        );
    }
}
