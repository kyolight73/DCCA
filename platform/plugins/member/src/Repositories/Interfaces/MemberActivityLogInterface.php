<?php

namespace Botble\Member\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MemberActivityLogInterface extends RepositoryInterface
{
    public function getAllLogs(int $memberId, int $paginate = 10): LengthAwarePaginator;
}
